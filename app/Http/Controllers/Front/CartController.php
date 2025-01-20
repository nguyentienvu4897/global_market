<?php

namespace App\Http\Controllers\Front;

use App\Mail\NewOrder;
use App\Model\Admin\Config;
use App\Model\Admin\Order;
use App\Model\Admin\OrderDetail;
use App\Model\Admin\Product;
use App\Model\Common\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Category;
use App\Model\Admin\OrderRevenueDetail;
use App\Model\Admin\Voucher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Kjmtrue\VietnamZone\Models\Province;
use Vanthao03596\HCVN\Models\District;
use Vanthao03596\HCVN\Models\Province as Vanthao03596Province;
use Vanthao03596\HCVN\Models\Ward;

class CartController extends Controller
{
    // trang giỏ hàng
    public function index()
    {
        $cartCollection = \Cart::getContent();
        $total_price = \Cart::getTotal();
        $total_qty = \Cart::getContent()->sum('quantity');

        $categories = Category::query()->where('show_home_page', 1)->orderBy('sort_order')->get();

        return view('site.orders.cart', compact('cartCollection', 'total_price', 'total_qty', 'categories'));
    }

    public function addItem(Request $request, $productId)
    {
        $product = Product::query()->find($productId);
        $arr_index = [];
        if(isset($request['attributes'])) {
            foreach ($request['attributes'] as $attribute) {
                $arr_index[] = [
                    'index' => intval($attribute['index']),
                    'value' => $attribute['value']
                ];
            }
            sort($arr_index);
        }
        $uniqueId = isset($arr_index) ? $product->id . '-' . json_encode($arr_index) : $product->id;

        \Cart::add([
            'id' => $uniqueId,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->qty ? (int)$request->qty : 1,
            'attributes' => [
                'image' => $product->image->path ?? '',
                'slug' => $product->slug,
                'base_price' => $product->base_price,
                'attributes' => $request['attributes']
            ]
        ]);

        $noti_product = [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_image' => $product->image->path ?? '',
            'product_price' => $product->price,
            'product_qty' => $request->qty ? (int)$request->qty : 1,
        ];

        return \Response::json(['success' => true, 'items' => \Cart::getContent(), 'total' => \Cart::getTotal(),
            'count' => \Cart::getContent()->sum('quantity'), 'noti_product' => $noti_product]);
    }

    public function updateItem(Request $request)
    {
        \Cart::update($request->product_id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->qty
            ),
        ));

        return \Response::json(['success' => true, 'items' => \Cart::getContent(), 'total' => \Cart::getTotal(),
            'count' => \Cart::getContent()->sum('quantity')]);

    }

    public function removeItem(Request $request)
    {
        \Cart::remove($request->product_id);

        return \Response::json(['success' => true, 'items' => \Cart::getContent(), 'total' => \Cart::getTotal(),
            'count' => \Cart::getContent()->sum('quantity')]);
    }

    // trang thanh toán
    public function checkout(Request $request) {
        $cartCollection = \Cart::getContent();
        $total = \Cart::getTotal();
        $vouchers = Voucher::query()->where('status', 1)->where('quantity', '>', 0)->where('to_date', '>=', now())->orderBy('created_at', 'desc')->get();
        $provinces = Vanthao03596Province::all();
        $districts = District::all();
        $wards = Ward::all();

        return view('site.orders.checkout', compact('cartCollection', 'total', 'vouchers', 'provinces', 'districts', 'wards'));
    }

    // áp dụng mã giảm giá (boolean)
    public function applyVoucher(Request $request) {
        $voucher = Voucher::query()->where('code', $request->code)->first();
        if(isset($voucher) && (($request->total >= $voucher->limit_bill_value && $voucher->limit_bill_value > 0) || ($voucher->limit_product_qty > 0 && $request->qty >= $voucher->limit_product_qty))) {
            return Response::json(['success' => true, 'voucher' => $voucher, 'message' => 'Áp dụng mã giảm giá thành công']);
        }
        return Response::json(['success' => false, 'message' => 'Không đủ điều kiện áp mã giảm giá']);
    }

    // submit đặt hàng
    public function checkoutSubmit(Request $request)
    {
        DB::beginTransaction();
        try {
            $translate = [
                'customer_name.required' => 'Vui lòng nhập họ tên',
                'customer_phone.required' => 'Vui lòng nhập số điện thoại',
                'customer_phone.regex' => 'Số điện thoại không đúng định dạng',
                'customer_address.required' => 'Vui lòng nhập địa chỉ',
                'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
                'customer_email.required' => 'Vui lòng nhập email',
            ];

            $validate = Validator::make(
                $request->all(),
                [
                    'customer_name' => 'required',
                    'customer_phone' => 'required|regex:/^(0)[0-9]{9,11}$/',
                    'customer_address' => 'required',
                    'customer_email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'customer_province' => 'required',
                    'customer_district' => 'required',
                    'customer_ward' => 'required',
                    'discount_code' => 'nullable',
                    'discount_value' => 'nullable',
                ],
                $translate
            );

            $json = new \stdClass();

            if ($validate->fails()) {
                $json->success = false;
                $json->errors = $validate->errors();
                $json->message = "Thao tác thất bại!";
                return Response::json($json);
            }

            $ward = Ward::query()->find($request->customer_ward);

            $customer_address = $request->customer_address . ', ' . $ward->path_with_type;

            $lastId = Order::query()->latest('id')->first()->id ?? 1;
            $total_price = $request->total;

            $order = Order::query()->create([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address' => $customer_address,
                'customer_required' => $request->customer_required,
                'discount_code' => $request->discount_code,
                'discount_value' => $request->discount_value,
                'total_before_discount' => $total_price,
                'total_after_discount' => $total_price - $request->discount_value,
                'code' => 'ORDER' . date('Ymd') . '-' . $lastId
            ]);

            $revenue_amount_level_1 = 0;
            $revenue_amount_level_2 = 0;
            $revenue_amount_level_3 = 0;
            $revenue_amount_level_4 = 0;
            $revenue_amount_level_5 = 0;
            // $config = \App\Model\Admin\Config::where('id',1)->select('revenue_percent_1', 'revenue_percent_2', 'revenue_percent_3', 'revenue_percent_4', 'revenue_percent_5')->first();
            foreach ($request->items as $item) {
                $product = Product::query()->where('slug', $item['attributes']['slug'])->first();
                $detail = new OrderDetail();
                $detail->order_id = $order->id;
                $detail->product_id = $product->id;
                $detail->qty = $item['quantity'];
                $detail->price = $item['price'];
                $detail->attributes = isset($item['attributes']['attributes']) ? json_encode($item['attributes']['attributes']) : null;
                $detail->save();
                $revenue_amount_level_1 += $product->revenue_price * $product->revenue_percent_1 / 100;
                $revenue_amount_level_2 += $product->revenue_price * $product->revenue_percent_2 / 100;
                $revenue_amount_level_3 += $product->revenue_price * $product->revenue_percent_3 / 100;
                $revenue_amount_level_4 += $product->revenue_price * $product->revenue_percent_4 / 100;
                $revenue_amount_level_5 += $product->revenue_price * $product->revenue_percent_5 / 100;

                \Cart::remove($item['id']);
            }

            $current_user = User::query()->with([
                'parent' => function($q) {
                    $q->with([
                        'parent' => function($q) {
                            $q->with([
                                'parent' => function($q) {
                                    $q->with([
                                        'parent' => function($q) {
                                            $q->where('status', 1)->where('type', 10);
                                        }
                                    ])->where('status', 1)->where('type', 10);
                                }
                            ])->where('status', 1)->where('type', 10);
                        }
                    ])->where('status', 1)->where('type', 10);
                }
            ])->where('id', auth()->guard('client')->user()->id)->where('email', $request->customer_email)->where('status', 1)->where('type', 10)->first();

            if($current_user) {
                $order_revenue_detail = new OrderRevenueDetail();
                $order_revenue_detail->order_id = $order->id;
                $order_revenue_detail->order_code = $order->code;
                $order_revenue_detail->user_id = $current_user->id;
                $order_revenue_detail->user_email = $current_user->email;
                $order_revenue_detail->user_level = 5;
                $order_revenue_detail->status = 0;
                // $order_revenue_detail->revenue_percent = $config->revenue_percent_5;
                $order_revenue_detail->revenue_amount = $revenue_amount_level_5;
                $order_revenue_detail->save();
            }

            if(isset($current_user->parent)) {
                $order_revenue_detail = new OrderRevenueDetail();
                $order_revenue_detail->order_id = $order->id;
                $order_revenue_detail->order_code = $order->code;
                $order_revenue_detail->user_id = $current_user->parent->id;
                $order_revenue_detail->user_email = $current_user->parent->email;
                $order_revenue_detail->user_level = 4;
                $order_revenue_detail->status = 0;
                // $order_revenue_detail->revenue_percent = $config->revenue_percent_4;
                $order_revenue_detail->revenue_amount = $revenue_amount_level_4;
                $order_revenue_detail->save();
            }

            if(isset($current_user->parent) && isset($current_user->parent->parent)) {
                $order_revenue_detail = new OrderRevenueDetail();
                $order_revenue_detail->order_id = $order->id;
                $order_revenue_detail->order_code = $order->code;
                $order_revenue_detail->user_id = $current_user->parent->parent->id;
                $order_revenue_detail->user_email = $current_user->parent->parent->email;
                $order_revenue_detail->user_level = 3;
                $order_revenue_detail->status = 0;
                // $order_revenue_detail->revenue_percent = $config->revenue_percent_3;
                $order_revenue_detail->revenue_amount = $revenue_amount_level_3;
                $order_revenue_detail->save();
            }

            if(isset($current_user->parent) && isset($current_user->parent->parent) && isset($current_user->parent->parent->parent)) {
                $order_revenue_detail = new OrderRevenueDetail();
                $order_revenue_detail->order_id = $order->id;
                $order_revenue_detail->order_code = $order->code;
                $order_revenue_detail->user_id = $current_user->parent->parent->parent->id;
                $order_revenue_detail->user_email = $current_user->parent->parent->parent->email;
                $order_revenue_detail->user_level = 2;
                $order_revenue_detail->status = 0;
                // $order_revenue_detail->revenue_percent = $config->revenue_percent_2;
                $order_revenue_detail->revenue_amount = $revenue_amount_level_2;
                $order_revenue_detail->save();
            }

            if(isset($current_user->parent) && isset($current_user->parent->parent) && isset($current_user->parent->parent->parent) && isset($current_user->parent->parent->parent->parent)) {
                $order_revenue_detail = new OrderRevenueDetail();
                $order_revenue_detail->order_id = $order->id;
                $order_revenue_detail->order_code = $order->code;
                $order_revenue_detail->user_id = $current_user->parent->parent->parent->parent->id;
                $order_revenue_detail->user_email = $current_user->parent->parent->parent->parent->email;
                $order_revenue_detail->user_level = 1;
                $order_revenue_detail->status = 0;
                // $order_revenue_detail->revenue_percent = $config->revenue_percent_1;
                $order_revenue_detail->revenue_amount = $revenue_amount_level_1;
                $order_revenue_detail->save();
            }

            if(\Cart::getContent()->sum('quantity') == 0) {
                \Cart::clear();
            }

            $voucher = Voucher::query()->where('code', $request->discount_code)->first();
            if ($voucher) {
                $voucher->quantity -= 1;
                $voucher->save();
            }

            session(['order_id' => $order->id]);

            $config = Config::query()->first();

            // gửi mail thông báo có đơn hàng mới cho admin
            $users = User::query()->where('type', 1)->where('status', 1)->get();
            // Mail::to('nguyentienvu4897@gmail.com')->send(new NewOrder($order, $config, 'admin'));


            if($users->count()) {
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new NewOrder($order, $config, 'admin'));
                }
            }

            DB::commit();
            return Response::json(['success' => true, 'order_code' => $order->code, 'message' => 'Đặt hàng thành công']);
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }

    }

    // trả về trang đặt hàng thành công
    public function checkoutSuccess(Request $request)
    {
        if (!session()->has('order_id')) {
            return redirect()->route('front.home-page');
        }

        $orderId = session('order_id');
        $order = Order::query()->with('details', 'details.product', 'details.product.image')->find($orderId);

        session()->forget('order_id');
        return view('site.orders.checkout_success', compact('order'));
    }

}
