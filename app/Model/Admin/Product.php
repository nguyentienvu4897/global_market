<?php

namespace App\Model\Admin;

use App\Model\BaseModel;
use App\Model\Common\ProductCategory;
use App\Model\G7\G7Product;
use App\Model\G7\G7ProductPrice;
use App\Model\Traits\HasTagTrait;
use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;
use Illuminate\Support\Facades\Auth;
use App\Model\Common\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use File as FileSystem;

class Product extends BaseModel
{
    use HasTagTrait;

    const CON_HANG = 1;
    const HET_HANG = 2;

    const IS_PIN = 1;
    const NOT_PIN = 2;

    const STATE = [
        1 => 'Còn hàng',
        2 => 'Hết hàng'
    ];

    protected $fillable = ['name', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at',
        'price', 'cate_id', 'base_price', 'body', 'intro', 'slug', 'short_des', 'manufacturer_id', 'origin_id'];

    use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public const TYPE_NORMAL = 0; // Sản phẩm thông thường
    public const TYPE_AFFILIATE = 1; // Sản phẩm affiliate

    public const STATUS_SUCCESS = 1; // Hoạt động
    public const STATUS_DANGER = 0; // Khóa

    public const STATUSES = [
        [
            'id' => 1,
            'name' => 'Hoạt động',
            'type' => 'success'
        ],
        [
            'id' => 0,
            'name' => 'Khóa',
            'type' => 'danger'
        ]
    ];

    public function canDelete()
    {
        return true;
    }

    public function canEdit()
    {
        return Auth::guard('admin')->user()->type == User::SUPER_ADMIN || Auth::guard('admin')->user()->type == User::QUAN_TRI_VIEN;
    }

    public function image()
    {
        return $this->morphOne(File::class, 'model')->where('custom_field', 'image');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'product_id', 'id');
    }

    public function product_rates()
    {
        return $this->hasMany(ProductRate::class, 'product_id', 'id');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id', 'id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'product_posts', 'product_id', 'post_id')->withTimestamps();
    }

    public function attributeValues()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_values', 'product_id', 'attribute_id')->withPivot('value');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function product_origin()
    {
        return $this->belongsTo(Origin::class, 'origin_id');
    }

    public function category_specials()
    {
        return $this->belongsToMany(CategorySpecial::class, 'product_category_special', 'product_id', 'category_special_id');
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class, 'product_id');
    }

    public function getLinkAttribute()
    {
        if ($this->use_url_custom) {
            return '/san-pham/' . $this->url_custom;
        }
        return route('front.product-detail', $this->slug);
    }

    public function getPercentDiscountAttribute()
    {
        $percentDiscount = round((($this->base_price - $this->price) / $this->base_price) * 100 );

        return $percentDiscount;
    }


    public static function searchByFilter($request)
    {
        $result = self::with([
            'category',
            'image',
        ]);

        if (!empty($request->name)) {
            $result = $result->where('name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->cate_id)) {
            $category = Category::query()->where('id', $request->cate_id)->first();
            $category_parent_id = $category->parent ? $category->parent->id : null;
            $arr_category_id = array_merge($category->childs->pluck('id')->toArray(), [$category->id, $category_parent_id]);
            if ($category->childs) {
                foreach ($category->childs as $child) {
                    $arr_category_id = array_merge($arr_category_id, $child->childs->pluck('id')->toArray());
                }
            }
            $result = $result->whereIn('cate_id', $arr_category_id);
        }

        if (!empty($request->cate_special_id)) {
            $cate_special_id = $request->cate_special_id;
            $result = $result->whereHas('category_specials', function ($q) use ($cate_special_id) {
                $q->where('category_special_id', $cate_special_id);
            });
        }

        if ($request->status === 0 || $request->status === '0' || !empty($request->status)) {
            $result = $result->where('status', $request->status);
        }

        if (!empty($request->state)) {
            $result = $result->where('state', $request->state);
        }


        $result = $result->orderBy('created_at', 'desc')->get();
        return $result;
    }

    public static function getForSelect()
    {
        return self::select(['id', 'name'])
            ->where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public static function getDataForEdit($id)
    {
        $product = self::where('id', $id)
            ->with([
                'category' => function ($q) {
                    $q->select(['id', 'name']);
                },
                'image',
                'manufacturer',
                'videos',
                'galleries' => function ($q) {
                    $q->select(['id', 'product_id', 'sort'])
                        ->with(['image'])
                        ->orderBy('sort', 'ASC');
                },
                'attributeValues'
            ])
            ->firstOrFail();

        $product->category_special_ids = $product->category_specials->pluck('id')->toArray();
        $product->attributeValues->map(function ($attribute) {
            $attribute->attribute_id = $attribute->id;
            $attribute->value = $attribute->pivot->value;
            return $attribute;
        });

        $tags = $product->tags->map(function ($tag) {
            // $tag->name = '<a href="'.route('front.search').'?keyword='.$tag->name.'">'.$tag->name.'</a>' ;
            return $tag;
        });

        $product->tags_str = $tags->implode('name', ', ');

        return $product;
    }

    public static function findSlug($slug)
    {
        $object = self::findBySlug($slug);

        if (!$object) {
            $object = self::query()->where('url_custom', $slug)->first();
        }

        return self::where('id', $object->id)
            ->with([
                'category' => function ($q) {
                    $q->select(['id', 'name', 'slug']);
                },
                'image',
                'galleries' => function ($q) {
                    $q->select(['id', 'product_id', 'sort'])
                        ->with(['image'])
                        ->orderBy('sort', 'ASC');
                },
                'attributeValues',
                'product_rates' => function ($q) {
                    $q->with(['images'])->where('status', 2);
                }
            ])
            ->firstOrFail();
    }

    public static function getRelate($id, $cate_id)
    {
        return self::where('id', '<>', $id)
            ->where([
                'status' => 1,
                'cate_id' => $cate_id
            ])
            ->orderBy('created_at', 'desc')->get();
    }

    public function generateCode()
    {
        $this->code = "HH-" . generateCode(6, $this->id);
        $this->save();
    }

    public function syncAttributes($attributes)
    {
        $this->attributeValues()->detach();
        foreach ($attributes as $attribute) {
            $this->attributeValues()->attach($attribute['attribute_id'], ['value' => $attribute['value']]);
        }
    }

    public function syncGalleries($galleries)
    {
        if ($galleries) {
            $exist_ids = [];
            foreach ($galleries as $g) {
                if (isset($g['id'])) array_push($exist_ids, $g['id']);
            }

            $deleted = ProductGallery::where('product_id', $this->id)->whereNotIn('id', $exist_ids)->get();
            foreach ($deleted as $item) {
                if ($item->image) {
                    FileHelper::forceDeleteFiles($item->image->id, $item->id, ProductGallery::class, null);
                    $item->image->removeFromDB();
                }
                $item->removeFromDB();
            }

            for ($i = 0; $i < count($galleries); $i++) {
                $g = $galleries[$i];

                if (isset($g['id'])) $gallery = ProductGallery::find($g['id']);
                else $gallery = new ProductGallery();

                $gallery->product_id = $this->id;
                $gallery->sort = $i;
                $gallery->save();

                if (isset($g['image'])) {
                    if ($gallery->image) $gallery->image->removeFromDB();
                    $file = $g['image'];
                    FileHelper::uploadFile($file, 'product_gallery', $gallery->id, ProductGallery::class, null, 1);
                }
            }
        } else {
            $galleries = $this->galleries;
            foreach ($galleries as $gallery) {
                if ($gallery->image) {
                    FileHelper::forceDeleteFiles($gallery->image->id, $gallery->id, ProductGallery::class, null);
                    $gallery->image->removeFromDB();
                }
            }
            $this->galleries()->delete();
        }
    }

    public function syncDocuments($documents, $folder)
    {
        $folderDir = implode(DIRECTORY_SEPARATOR, ["public", "uploads", $folder]);
        $attachments = [$this->attachments];

        if ($documents) {
            foreach ($documents as $document)  {
                $filename = $document->getClientOriginalName();
                $name = Str::slug(str_replace("/", "", $filename));
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $destinationFileName = $name . '-' . time() . '-' . randomString(4);
                $destinationFile = $destinationFileName . '.' . $extension;
                $destinationPath = base_path() . DIRECTORY_SEPARATOR . $folderDir;

                if (!is_dir($destinationPath)) {
                    FileSystem::makeDirectory($destinationPath, 0777, true);
                }

                $document->move($destinationPath, $destinationFile);

                $path = DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, ["uploads", $folder, $destinationFile]);

                array_push($attachments, $path);
            }
            $this->attachments = join(', ', $attachments);
            $this->save();
        }
    }

    public static function filter($request, $product_ids)
    {
        $productIsPin = self::query()->where('is_pin', 1)->whereIn('id', $product_ids)
            ->with([
                'category' => function ($q) {
                    $q->select(['id', 'name']);
                },
                'image',
                'manufacturer',
                'galleries' => function ($q) {
                    $q->select(['id', 'product_id', 'sort'])
                        ->with(['image'])
                        ->orderBy('sort', 'ASC');
                },
                'attributeValues'
            ])
            ->select(['*']);

        $productInStock = self::query()->where('state', 1)->whereIn('id', $product_ids)
            ->with([
                'category' => function ($q) {
                    $q->select(['id', 'name']);
                },
                'image',
                'manufacturer',
                'galleries' => function ($q) {
                    $q->select(['id', 'product_id', 'sort'])
                        ->with(['image'])
                        ->orderBy('sort', 'ASC');
                },
                'attributeValues'
            ])
            ->select(['*']);

        $productOutStock = self::query()->where('state', 2)->whereIn('id', $product_ids)
            ->with([
                'category' => function ($q) {
                    $q->select(['id', 'name']);
                },
                'image',
                'manufacturer',
                'galleries' => function ($q) {
                    $q->select(['id', 'product_id', 'sort'])
                        ->with(['image'])
                        ->orderBy('sort', 'ASC');
                },
                'attributeValues'
            ])
            ->select(['*']);

        if ($keyword = $request->get('keyword')) {
            $productIsPin->where(function ($q) use ($keyword) {
                $q->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%')
                        ->orWhereHas('manufacturer', function ($q) use ($keyword) {
                            $q->where('manufacturers.name', 'like', '%' . $keyword . '%');
                        });
                })->orWhereHas('tags', function ($q) use ($keyword){
                    $q->where('tags.name', 'like', '%' . $keyword . '%');
                });
            });

            $productInStock->where(function ($q) use ($keyword) {
                $q->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%')
                        ->orWhereHas('manufacturer', function ($q) use ($keyword) {
                            $q->where('manufacturers.name', 'like', '%' . $keyword . '%');
                        });
                })->orWhereHas('tags', function ($q) use ($keyword){
                    $q->where('tags.name', 'like', '%' . $keyword . '%');
                });
            });

            $productOutStock->where(function ($q) use ($keyword) {
                $q->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%')
                        ->orWhereHas('manufacturer', function ($q) use ($keyword) {
                            $q->where('manufacturers.name', 'like', '%' . $keyword . '%');
                        });
                })->orWhereHas('tags', function ($q) use ($keyword){
                    $q->where('tags.name', 'like', '%' . $keyword . '%');
                });
            });

        }

        if ($request->get('minPrice')) {
            $productIsPin->where('price', '>=', $request->get('minPrice'));
            $productInStock->where('price', '>=', $request->get('minPrice'));
            $productOutStock->where('price', '>=', $request->get('minPrice'));
        }

        if ($request->get('maxPrice')) {
            $productIsPin->where('price', '<=', $request->get('maxPrice'));
            $productInStock->where('price', '<=', $request->get('maxPrice'));
            $productOutStock->where('price', '<=', $request->get('maxPrice'));
        }

        $query = $productIsPin->union($productInStock)->union($productOutStock)->orderBy('is_pin')->orderBy('state');

        if ($sort = $request->get('sort')) {
            if ($sort == 'lasted') {
                $query->orderBy('created_at', 'desc');
            } else if ($sort == 'priceAsc') {
                $query->orderBy('price', 'asc');
            } else if ($sort == 'priceDesc') {
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    public function scopeSort($query, $request)
    {
        $query->orderBy('is_pin')->orderBy('state')->orderBy('updated_at', 'desc');
    }

    public function scopeFilterV2($query, $filters)
    {
        $query = self::query();
        if ($filters) {
            $filters = array_merge(...array_values($filters));
            if (@$filters['manu']) {
                $query->whereIn('manufacturer_id', $filters['manu']);
            }
            if (@$filters['origin']) {
                $query->whereIn('origin_id', $filters['origin']);
            }

            if (@$filters['prices']) {
                $prices = $filters['prices'];

                $query->where(function ($q) use ($prices) {
                    foreach ($prices as $price) {
                        $price = json_decode($price, true);
                        if (count($price) > 1) {
                            $q->orWhere(function ($q) use ($price) {
                                $q->where('price', '>=', $price[0])
                                    ->where('price', '<=', $price[1]);
                            });
                        } else {
                            if ($price[0] == 16000000) {
                                $q->orWhere('price', '>=', 15000000);
                            } else {
                                $q->orWhere('price', '<=', $price[0]);
                            }
                        }
                    }
                });
            }
        }

        return $query;
    }

    public static function getTableList($products)
    {
        $rows = '';

        foreach ($products as $index => $item) {
            $category = $item->category;
            $cate_parent = $category->category_parent ?? $category;
            $cate_grandparent = $cate_parent->category_parent ?? $cate_parent;
            $level = 0;
            if(isset($cate_grandparent)) {
                $level = 3;
            } else if(isset($cate_parent) && !isset($cate_grandparent)) {
                $level = 2;
            } else if(isset($category) && !isset($cate_parent) && !isset($cate_grandparent)) {
                $level = 1;
            }
            $images = [$item->image->path];
            foreach($item->galleries as $gallery) {
                $images[] = $gallery->image->path;
            }
            $images = array_map(function($image) {
                return asset(trim($image));
            }, $images);
            $rows .= '<tr style="font-size: 16px;">';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black; text-align: center" >' . ($index + 1) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->name) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->origin) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $level == 3 ? $cate_grandparent->name : ($level == 2 ? $cate_parent->name : $category->name)) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $level == 3 ? $cate_parent->name : ($level == 2 ? $category->name : '')) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $level == 3 ? $category->name : '') . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace(['&lt;br&gt;', '&lt;br /&gt;', '&lt;br/&gt;'], "\n", htmlspecialchars($item->intro)) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace(['&lt;br&gt;', '&lt;br /&gt;', '&lt;br/&gt;'], "\n", htmlspecialchars($item->body)) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . join(', ', $images) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->aff_product_code) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->origin_link) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->aff_link) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . formatCurrency($item->price) . '</td>';
            $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . formatCurrency($item->revenue_price) . '</td>';
            $rows .= '</tr>';
        }

        $table = '<table style="width: 100%">
            <thead>
                <tr style="">
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 7px"><b>STT</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 40px"><b>Tên hàng hóa</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 10px"><b>Sản phẩm thuộc sàn</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 12px"><b>Danh mục lớn</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 12px"><b>Danh mục con</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 12px"><b>Danh mục con cấp 2</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 28px"><b>Mô tả sản phẩm</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 28px"><b>Chi tiết sản phẩm</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 28px"><b>Hình ảnh sản phẩm</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 12px"><b>Mã sản phẩn trên sàn</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 12px"><b>Link gốc</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 12px"><b>Link giới thiệu</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 12px"><b>Giá sản phẩm</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 12px"><b>Hoa hồng sản phẩm</b></td>
                </tr>
            </thead>
            <tbody>'
            . $rows .
            '</tbody>
        </table>';

        return $table;
    }
}
