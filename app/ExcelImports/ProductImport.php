<?php
namespace App\ExcelImports;

use App\Helpers\FileHelper;
use App\Model\Admin\Category;
use App\Model\Admin\Origin;
use App\Model\Admin\Product;
use App\Model\Admin\ProductGallery;
use DateTime;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Model\Common\File as FileModel;

class ProductImport implements ToCollection, WithStartRow, WithMultipleSheets
{
    private $import_rows = 0;
    private $skip_rows = 0;
    private $invalid_rows = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row)
        {
            $errors = [];
            if (empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[9])) {
                $this->skip_rows++;
                continue;
            }
            $product_name = trim($row[1]);
            $origin_name = trim($row[2]);
            $cate_1 = trim($row[3]);
            $cate_2 = trim($row[4]);
            $cate_3 = trim($row[5]);
            $intro = $row[6];
            $body = $row[7];
            $string_images = $row[8];
            $aff_product_code = trim($row[9]);
            $origin_link = trim($row[10]);
            $aff_link = trim($row[11]);
            $price = trim($row[12]);
            $revenue_price = trim($row[13]);

            $images = explode(',', $string_images);

            $origin = Origin::where('name', $origin_name)->first();
            if(!$origin) {
                $errors[] = 'Nguồn(sàn) không tồn tại';
            }

            $category = Category::where('name', $cate_1)->where('level', 0)->first();
            if(!$category) {
                $errors[] = 'Danh mục lớn không tồn tại';
            }
            $cate_child = Category::where('name', $cate_2)->where('parent_id', $category->id)->where('level', 1)->first();
            $cate_child_child = Category::where('name', $cate_3)->where('parent_id', $cate_child->id)->where('level', 2)->first();
            if(count($errors)) {
                $this->invalid_rows[] = [
                    'detail' => implode("\n", $errors),
                    'row' => $row,
                    'index' => $index + 2,
                ];
                $this->skip_rows++;
                continue;
            }
            $product = Product::query()->where(function ($query) use ($aff_product_code, $product_name) {
                $query->where('aff_product_code', $aff_product_code)
                    ->orWhere('name', $product_name);
            })->first();
            if($product) {
                $product->name = $product_name;
                $product->origin_id = $origin->id;
                $product->origin = $origin->name;
                $product->cate_id = $cate_child_child ? $cate_child_child->id : ($cate_child ? $cate_child->id : $category->id);
                $product->intro = $intro;
                $product->body = $body;
                $product->aff_product_code = $aff_product_code;
                $product->origin_link = $origin_link;
                $product->aff_link = $aff_link;
                $product->short_link = $aff_link;
                $product->price = $price ?? 0;
                $product->revenue_price = $revenue_price ?? 0;
                $product->status = Product::STATUS_SUCCESS;
                $product->state = Product::CON_HANG;
                $product->type = Product::TYPE_AFFILIATE;
                $product->slug = Str::slug($product_name);
                $product->save();
            } else {
                $product = new Product();
                $product->name = $product_name;
                $product->origin_id = $origin->id;
                $product->origin = $origin->name;
                $product->cate_id = $cate_child_child ? $cate_child_child->id : ($cate_child ? $cate_child->id : $category->id);
                $product->intro = $intro;
                $product->body = $body;
                $product->aff_product_code = $aff_product_code;
                $product->origin_link = $origin_link;
                $product->aff_link = $aff_link;
                $product->short_link = $aff_link;
                $product->price = $price ?? 0;
                $product->revenue_price = $revenue_price ?? 0;
                $product->status = Product::STATUS_SUCCESS;
                $product->state = Product::CON_HANG;
                $product->type = Product::TYPE_AFFILIATE;
                $product->slug = Str::slug($product_name);
                $product->button_type = 1;
                $product->save();
            }
            if(count($images)) {
                if ($product->image) {
                    FileHelper::forceDeleteFiles($product->image->id, $product->id, Product::class, 'image');
                }
                if (isset($product->galleries)) {
                    foreach ($product->galleries as $gallery) {
                        if($gallery->image) {
                            FileHelper::forceDeleteFiles($gallery->image->id, $gallery->id, ProductGallery::class, null);
                            $gallery->image->removeFromDB();
                        }
                        $gallery->removeFromDB();
                    }
                }
                $image_file_data = $this->downloadImage(trim($images[0]), 'products');
                if($image_file_data) {
                    $image_file_data['model_id'] = $product->id;
                    $image_file_data['model_type'] = Product::class;
                    $image_file_data['custom_field'] = 'image';
                    $product_image = new FileModel($image_file_data);
                    $product_image->save();
                }
                for ($i = 1; $i < count($images); $i++) {
                    $gallery = new ProductGallery();
                    $gallery->product_id = $product->id;
                    $gallery->sort = $i;
                    $gallery->save();
                    $gallery_image_data = $this->downloadImage(trim($images[$i]), 'product_gallery');
                    if($gallery_image_data) {
                        $gallery_image_data['model_id'] = $gallery->id;
                        $gallery_image_data['model_type'] = ProductGallery::class;
                        $gallery_image_data['custom_field'] = null;
                        $gallery_image = new FileModel($gallery_image_data);
                        $gallery_image->save();
                    }
                }
            }
            $this->import_rows++;
        }
    }

    public function downloadImage($url, $folder)
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $contents = curl_exec($ch);
        curl_close($ch);

        if (!$contents) {
            return null;
        }

        $name = basename(parse_url($url, PHP_URL_PATH)); // Lấy tên file từ URL
        $path = public_path('uploads/' . $folder . '/' . $name);

        File::put($path, $contents); // Lưu ảnh vào thư mục uploads

        $file_data = [
            'name' => $name,
            'path' => '/uploads/' . $folder . '/' . $name,
        ];

        return $file_data;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function getImportCount(): int
    {
        return $this->import_rows;
    }

    public function getSkipCount(): int
    {
        return $this->skip_rows;
    }

    public function getInvalidRow()
    {
        return $this->invalid_rows;
    }
}
