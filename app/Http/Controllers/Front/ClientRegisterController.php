<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Validator;
use Response;
use DB;
use App\Model\Common\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ResponseTrait;
use App\Model\Admin\OrderRevenueDetail;
use JWTAuth;
use App\Helpers\FileHelper;
use App\Mail\RecoverPassword;
use App\Mail\WithdrawMoney;
use App\Model\Admin\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ClientRegisterController extends Controller
{
    use ResponseTrait;
    public function loginClient() {
        return view('site.login_client');
    }

    public function loginClientSubmit(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'account_name' => 'required',
                'password' => 'required',
            ]
        );

        if ($validate->fails()) {
            $message = array(
                "message" => "Thông tin đăng nhập chưa đủ!",
                "alert-type" => "warning"
            );
            return back()
                ->withErrors($validate)
                ->with($message)
                ->withInput();
        }

        $remember = true;

        // Xác định trường nào sẽ dùng để đăng nhập (email hoặc account_name)
        $field = filter_var($request->account_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'account_name';

        // Thay đổi mảng điều kiện xác thực
        $loginConditions = [
            $field    => $request->account_name,
            'password' => $request->password,
            'status'   => 1,
            'type'     => 10
        ];

        if (Auth::guard('client')->attempt($loginConditions, $remember)) {
            // Đăng nhập thành công
            $token = JWTAuth::attempt($loginConditions);

            $data = array(
                "token" => $token
            );
            return $this->responseSuccess('Đăng nhập thành công!', $data);
        } else {
            // Đăng nhập thất bại, trả về thông báo lỗi.
            return $this->responseErrors('Đăng nhập thất bại, vui lòng thử lại!');
        }
    }

    public function registerClientSubmit(Request $request) {
        $rule = [
			'name' => 'required',
			'email' => 'required|email|unique:users,email',
			'account_name' => 'required|unique:users,account_name',
			'password' => 'required|min:6|regex:/^[a-zA-Z0-9\@\$\!\%\*\#\?\&]+$/',
            'phone_number' => 'nullable|regex:/^(0)[0-9]{9,11}$/|unique:users,phone_number',
            'invite_code' => 'nullable|exists:users,invite_code',
		];

		$validate = Validator::make(
			$request->all(),
			$rule,
            [
                'invite_code.exists' => 'Mã giới thiệu không tồn tại',
                'phone_number.regex' => 'Số điện thoại không đúng định dạng',
                'password.regex' => 'Mật khẩu không đúng định dạng',
                'email.unique' => 'Email đã được sử dụng',
                'account_name.unique' => 'Tên đăng nhập đã được sử dụng',
                'phone_number.unique' => 'Số điện thoại đã được sử dụng',
            ]
		);

		if ($validate->fails()) {
			return $this->responseErrors("Thao tác thất bại", $validate->errors());
		}

        DB::beginTransaction();
		try {
			$object = new User();
			$object->name = $request->name;
			$object->email = $request->email;
            $object->account_name = $request->account_name;
            $object->password = bcrypt($request->password);
			$object->phone_number = $request->phone_number;
			$object->status = 1;
			$object->type = 10;
            $object->parent_id = $request->invite_code ? User::where('invite_code', $request->invite_code)->first()->id : null;
			$object->save();

			DB::commit();
            $data = [
                'account_name' => $request->account_name,
                'password' => $request->password,
            ];
			return $this->responseSuccess('Đăng ký thành công!', $data);
		} catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function logoutClient() {
        Auth::guard('client')->logout();
        $message = array(
            "logout" => "logout"
        );
        return redirect()->route('front.login-client')->with($message);
    }

    public function account() {
        $user = User::with('image')->where('id', Auth::guard('client')->user()->id)->first();
        return view('site.admin.account', compact('user'));
    }

    public function updateAccount(Request $request, $id)
	{
		$object = User::findOrFail($id);

		$rule = [
			'name' => 'required',
			'email' => 'required|email|unique:users,email,'.$id,
            'account_name' => 'required||unique:users,account_name,'.$id,
			'status' => 'required|in:0,1',
            'phone_number' => 'required|regex:/^(0)[0-9]{9,11}$/|unique:users,phone_number,'.$id,
            'bank_name' => 'required',
            'bank_account_number' => 'required',
            'bank_account_name' => 'required',
            'address' => 'nullable',
		];

		$validate = Validator::make(
			$request->all(),
			$rule,
			[
                'email.unique' => 'Email đã được sử dụng',
                'account_name.unique' => 'Tên đăng nhập đã được sử dụng',
                'phone_number.unique' => 'Số điện thoại đã được sử dụng',
            ]
		);

		if ($validate->fails()) {
			return $this->responseErrors("", $validate->errors());
		}

		DB::beginTransaction();
		try {
			$object->name = $request->name;
			$object->email = $request->email;
			$object->account_name = $request->account_name;
			$object->phone_number = $request->phone_number;
			$object->bank_name = $request->bank_name;
			$object->bank_account_number = $request->bank_account_number;
			$object->bank_account_name = $request->bank_account_name;
			$object->address = $request->address;
			$object->save();

			if($request->image) {
                if ($object->image) {
                    FileHelper::forceDeleteFiles($object->image->id, $object->id, User::class, 'image');
                }
				FileHelper::uploadFile($request->image, 'users', $object->id, User::class, 'image');
			}

			DB::commit();
			return $this->responseSuccess('Cập nhật thành công');
		} catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
	}

    public function changePassword(Request $request, $id) {
        $user = User::findOrFail($id);
        $rule = [
			'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Mật khẩu cũ không đúng');
                    }
                },
            ],
			'new_password' => 'required|min:6|regex:/^[a-zA-Z0-9\@\$\!\%\*\#\?\&]+$/|different:current_password',
			'confirm_password' => 'required|same:new_password',
		];

		$validate = Validator::make(
			$request->all(),
			$rule,
            [
                'current_password.required' => 'Mật khẩu cũ không được để trống',
                'new_password.required' => 'Mật khẩu mới không được để trống',
                'confirm_password.required' => 'Mật khẩu mới không được để trống',
                'confirm_password.same' => 'Mật khẩu mới không khớp',
                'new_password.regex' => 'Mật khẩu không đúng định dạng',
                'new_password.different' => 'Mật khẩu mới không được giống mật khẩu cũ',
            ]
		);

		if ($validate->fails()) {
			return $this->responseErrors("Thao tác thất bại", $validate->errors());
		}
        DB::beginTransaction();
		try {
            $user->password = bcrypt($request->new_password);
            $user->save();
            DB::commit();
            return $this->responseSuccess('Đổi mật khẩu thành công');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function recoverPassword(Request $request) {
        $rule = [
			'recover_email' => 'required|email|exists:users,email',
		];

		$validate = Validator::make(
			$request->all(),
			$rule,
			[
                'recover_email.exists' => 'Email không tồn tại',
            ]
		);

		if ($validate->fails()) {
			return $this->responseErrors("Thao tác thất bại", $validate->errors());
		}

        // gửi mail thông báo lấy lại mật khẩu cho user
        $user = User::query()->where('type', 10)->where('status', 1)->where('email', $request->recover_email)->first();
        if (!$user) {
            return $this->responseErrors("Thao tác thất bại", ['recover_email' => ['Email không tồn tại']]);
        }
        $new_password = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 8)), 0, 8);
        $user->password = bcrypt($new_password);
        $user->save();

        Mail::to($user->email)->send(new RecoverPassword($user, $new_password));
        // Mail::to('nguyentienvu4897@gmail.com')->send(new RecoverPassword($user, $new_password));

        return $this->responseSuccess('Đã gửi thông tin lấy lại mật khẩu, vui lòng kiểm tra email');
    }

    public function updateInviteCode(Request $request) {
        $user = User::findOrFail($request->user_id);
        do {
            $inviteCode = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 8)), 0, 8);
        } while (User::where('invite_code', $inviteCode)->exists());

        $user->invite_code = $inviteCode;
        $user->save();
        return $this->responseSuccess('Đã tạo lại mã giới thiệu', ['invite_code' => $user->invite_code]);
    }

    public function userOrder() {
        return view('site.admin.user_order');
    }

    public function showOrderDetail($id) {
        $order = Order::query()->with(['details.product'])->find($id);
        return $this->responseSuccess('Đã lấy thông tin đơn hàng', $order);
    }

    public function cancelOrder(Request $request, $id) {
        $order = Order::findOrFail($id);
        $order->status = Order::HUY;
        $order->comment = $request->reason;
        $order->save();
        $order_revenue_details = OrderRevenueDetail::where('order_id', $order->id)->get();
        foreach ($order_revenue_details as $detail) {
            $detail->status = OrderRevenueDetail::STATUS_CANCEL;
            $detail->save();
        }
        return $this->responseSuccess('Đã hủy đơn hàng');
    }

    public function userOrderSearchData(Request $request) {
        $objects = Order::searchByFilter($request);
        return Datatables::of($objects)
            ->addColumn('total_price', function ($object) {
                return number_format($object->total_price);
            })
            ->editColumn('type', function ($object) {
                return $object->type == 0 ? 'Đơn hàng thường' : 'Đơn hàng affiliate';
            })
            ->editColumn('code_client', function ($object) {
                return '<a href = "javascript:void(0)" title = "Xem chi tiết" class="show-order-detail" data-href="'.route('front.show-order-detail', $object->id).'">' . $object->code . '</a>';
            })
            ->editColumn('created_at', function ($object) {
                return $object->type == 0 ? formatDate($object->created_at) : formatDate($object->aff_order_at);
            })
            ->addColumn('action_client', function ($object) {
                $result = '<div class="btn-group btn-action">';
                if ($object->type == 0) {
                    $result = $result . ' <a href="javascript:void(0)" data-href="'.route('front.show-order-detail', $object->id).'" title="xem chi tiết" class="btn btn-info show-order-detail"><i class="fa fa-eye"></i></a>';
                    if ($object->canCancel()) {
                        $result = $result . ' <a href="javascript:void(0)" title="Hủy đơn hàng" class="btn btn-danger cancel-order" data-href="'.route('front.cancel-order', $object->id).'"><i class="fa fa-trash"></i></a>';
                    }
                }
                $result = $result . '</div>';
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['action_client', 'code_client'])
            ->make(true);
    }

    public function userRevenue(Request $request) {
        $user = Auth::guard('client')->user();
        $request_user = User::where('email', $request->mail)->first();
        $request_user_id = $request_user ? $request_user->id : $user->id;
        // dd($request_user_id);
        $revenue_amount = OrderRevenueDetail::where('user_id', $user->id)->whereNotIn('status', [OrderRevenueDetail::STATUS_CANCEL])->sum('revenue_amount');
        $quyet_toan_amount = OrderRevenueDetail::where('user_id', $user->id)->where(function($q) {
            $q->where('status', OrderRevenueDetail::STATUS_QUYET_TOAN)
            ->orWhere(function($query) {
                $query->where('status', OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN)
                ->where('settlement_amount', '>', 0);
            });
        })->sum('settlement_amount');
        $waiting_quyet_toan_amount = OrderRevenueDetail::where('user_id', $user->id)->where(function($q) {
            $q->where('status', OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN)
            ->orWhere(function($query) {
                $query->where('status', OrderRevenueDetail::STATUS_QUYET_TOAN)
                ->where('settlement_amount', '>', 0);
            });
        })->sum('revenue_amount') - $quyet_toan_amount;
        return view('site.admin.user_revenue', compact('user', 'revenue_amount', 'quyet_toan_amount', 'waiting_quyet_toan_amount', 'request_user_id'));
    }

    public function userRevenueSearchData(Request $request) {
        $objects = OrderRevenueDetail::searchByFilter($request);
        return Datatables::of($objects)
            ->addColumn('revenue_amount', function ($object) {
                return number_format($object->revenue_amount);
            })
            ->addColumn('settlement_amount', function ($object) {
                return number_format($object->settlement_amount);
            })
            ->addColumn('remaining_amount', function ($object) {
                return number_format($object->revenue_amount - $object->settlement_amount);
            })
            ->addColumn('order_employee', function ($object) {
                return '<b>' . $object->order->customer_name . '</b><br>' . $object->order->customer_email;
            })
            ->editColumn('created_at', function ($object) {
                return date('d/m/Y H:i', strtotime($object->created_at));
            })
            ->editColumn('settlement_date', function ($object) {
                return (empty($object->settlement_date)) ? '-' : date('d/m/Y H:i', strtotime($object->settlement_date));
            })
            ->editColumn('status', function ($object) {
                return getStatus($object->status, OrderRevenueDetail::STATUSES);
            })
            ->addIndexColumn()
            ->rawColumns(['revenue_amount', 'created_at', 'status', 'settlement_date', 'order_employee'])
            ->make(true);
    }

    public function withdrawMoney(Request $request) {
        $rule = [
			'withdrawAmount' => 'required|numeric|min:100000|max:'.$request->waitingQuyetToanAmount,
		];

		$validate = Validator::make(
			$request->all(),
			$rule,
            [
                'withdrawAmount.required' => 'Số tiền cần rút không được để trống',
                'withdrawAmount.numeric' => 'Số tiền cần rút không được để trống',
                'withdrawAmount.min' => 'Số tiền cần rút không được nhỏ hơn 100.000',
            ]
		);

		if ($validate->fails()) {
			return $this->responseErrors("Thao tác thất bại", $validate->errors());
		}

        $currentUser = Auth::guard('client')->user();
        // gửi mail thông báo rút tiền cho admin
        $users = User::query()->where('type', 1)->where('status', 1)->get();
        // Mail::to('nguyentienvu4897@gmail.com')->send(new WithdrawMoney($currentUser, $request->all()));


        if($users->count()) {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new WithdrawMoney($currentUser, $request->all()));
            }
        }
        return $this->responseSuccess('Đã gửi thông tin rút tiền, vui lòng chờ xác nhận');
    }

    public function checkOrder(Request $request) {
        $rule = [
            'order_code' => 'required|exists:orders,code',
        ];

        $messages = [
            'order_code.required' => 'Mã đơn hàng không được để trống',
            'order_code.exists' => 'Chưa tìm thấy đơn hàng. Vui lòng kiểm tra lại mã đơn hoặc thử lại sau',
            'order_code.boolean' => 'Mã đơn hàng không hợp lệ',
        ];
        $order = Order::query()->where('type', Order::TYPE_AFFILIATE)->where('code', $request->order_code)->first();
        if(!isset($order)) {
            $rule['order_code'] = 'required|exists:orders,code|boolean';
        }
        if(isset($order) && (isset($order->customer_email) || $order->customer_email != '')) {
            $rule['order_code'] = 'required|exists:orders,code|boolean';
            $messages['order_code.boolean'] = 'Đơn hàng đã được đối soát';
        }

        $validate = Validator::make($request->all(), $rule, $messages);
        if ($validate->fails()) {
            return $this->responseErrors("Thao tác thất bại", $validate->errors());
        }

        $order = Order::query()->where('type', Order::TYPE_AFFILIATE)->whereNull('customer_email')->where('code', $request->order_code)->first();
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
        ])->where('id', auth()->guard('client')->user()->id)->where('status', 1)->where('type', 10)->first();
        $config = \App\Model\Admin\Config::where('id',1)->select('revenue_percent_1', 'revenue_percent_2', 'revenue_percent_3', 'revenue_percent_4', 'revenue_percent_5')->first();

        if($order) {
            $revenue_amount_level_1 = $order->total_after_discount * $config->revenue_percent_1 / 100;
            $revenue_amount_level_2 = $order->total_after_discount * $config->revenue_percent_2 / 100;
            $revenue_amount_level_3 = $order->total_after_discount * $config->revenue_percent_3 / 100;
            $revenue_amount_level_4 = $order->total_after_discount * $config->revenue_percent_4 / 100;
            $revenue_amount_level_5 = $order->total_after_discount * $config->revenue_percent_5 / 100;

            $status = 0;
            if($order->status == Order::MOI) {
                $status = OrderRevenueDetail::STATUS_PENDING;
            } else if($order->status == Order::DUYET) {
                $status = OrderRevenueDetail::STATUS_PAID;
            } else if($order->status == Order::THANH_CONG) {
                $status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
            } else if($order->status == Order::HUY) {
                $status = OrderRevenueDetail::STATUS_CANCEL;
            }
            if($current_user) {
                $order_revenue_detail = new OrderRevenueDetail();
                $order_revenue_detail->order_id = $order->id;
                $order_revenue_detail->order_code = $order->code;
                $order_revenue_detail->user_id = $current_user->id;
                $order_revenue_detail->user_email = $current_user->email;
                $order_revenue_detail->user_level = 5;
                $order_revenue_detail->status = $status;
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
                $order_revenue_detail->status = $status;
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
                $order_revenue_detail->status = $status;
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
                $order_revenue_detail->status = $status;
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
                $order_revenue_detail->status = $status;
                $order_revenue_detail->revenue_amount = $revenue_amount_level_1;
                $order_revenue_detail->save();
            }

            $order->customer_name = $current_user->name;
            $order->customer_email = $current_user->email;
            $order->customer_phone = $current_user->phone_number;
            $order->save();

            $order->revenue_amount = $revenue_amount_level_5;
            $order->status_text = getStatus($order->status, Order::STATUSES);
            return $this->responseSuccess('Đã tìm thấy đơn hàng', $order);
        }
        return $this->responseErrors("Thao tác thất bại", "Đơn hàng không tồn tại");
    }

    public function userLevel() {
        $user = Auth::guard('client')->user();
        $users = User::with([
            'childs' => function($query) {
                $query->with([
                    'childs' => function($query) {
                        $query->with([
                            'childs' => function($query) {
                                $query->where('status', 1);
                            }
                        ])->where('status', 1);
                    }
                ])->where('status', 1);
            }
        ])->where('parent_id', $user->id)->where('status', 1)->get();
        // dd($users);
        return view('site.admin.user_level', compact('users'));
    }
}
