<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Model\Admin\Product;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use stdClass;

class ProductController extends Controller
{
    use ResponseTrait;
    public function getProducts(Request $request)
    {
        try {
            $json = new stdClass();

            $readmePath = base_path('readme/product.md');
            $readmeContent = file_exists($readmePath) ? file_get_contents($readmePath) : 'README not found.';

            $products = Product::query()
                ->with([
                    'image',
                    'category',
                ])
                ->where('status', 1)
                ->select('id', 'aff_product_code', 'name', 'slug', 'status', 'type', 'cate_id', 'price', 'base_price', 'revenue_price', 'body', 'intro', 'short_des', 'origin_id', 'origin', 'origin_link', 'aff_link', 'short_link', 'created_at', 'updated_at');
            if (!empty($request->origin_id)) {
                $products->where('origin_id', $request->origin_id);
            }
            if (!empty($request->aff_product_code)) {
                $products->where('aff_product_code', $request->aff_product_code);
            }
            if (!empty($request->origin_link)) {
                $products->where('origin_link', $request->origin_link);
            }
            if (!empty($request->aff_link)) {
                $products->where('aff_link', $request->aff_link);
            }
            if (!empty($request->short_link)) {
                $products->where('short_link', $request->short_link);
            }
            if (!empty($request->origin)) {
                $products->where('origin', 'like', '%' . $request->origin . '%');
            }
            if (!empty($request->name)) {
                $products->where('name', 'like', '%' . $request->name . '%');
            }
            if (!empty($request->sort)) {
                $products->orderBy('created_at', $request->sort);
            }
            if (!empty($request->limit)) {
                $products->limit($request->limit);
            }
            if (!empty($request->page)) {
                $products->offset($request->page * $request->limit);
            }
            $products = $products->get();

            $json->data = $products;
            $json->readme = $readmeContent;
            $json->success = true;
            $json->message = 'Lấy sản phẩm thành công';

            return Response::json($json);
        } catch (\Exception $e) {
            return $this->responseError('Lỗi không xác định', $e->getMessage());
        }
    }
}
