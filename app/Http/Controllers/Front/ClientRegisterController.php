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

        if (Auth::guard('client')->attempt(['account_name' => $request->account_name, 'password' => $request->password, 'status' => 1, 'type' => 10], $remember)) {
            // Đăng nhập thành công
            $token = JWTAuth::attempt(['account_name' => $request->account_name, 'password' => $request->password, 'status' => 1, 'type' => 10]);

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
			'email' => 'required|email|unique:users',
			'account_name' => 'required|unique:users',
			'password' => 'required|min:6|regex:/^[a-zA-Z0-9\@\$\!\%\*\#\?\&]+$/',
            'phone_number' => 'nullable|regex:/^(0)[0-9]{9,11}$/',
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
            'phone_number' => 'required|regex:/^(0)[0-9]{9,11}$/',
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
            ->editColumn('code_client', function ($object) {
                return '<a href = "javascript:void(0)" title = "Xem chi tiết" class="show-order-detail" data-href="'.route('front.show-order-detail', $object->id).'">' . $object->code . '</a>';
            })
            ->editColumn('created_at', function ($object) {
                return formatDate($object->created_at);
            })
            ->addColumn('action_client', function ($object) {
                $result = '<div class="btn-group btn-action">';
                $result = $result . ' <a href="javascript:void(0)" data-href="'.route('front.show-order-detail', $object->id).'" title="xem chi tiết" class="btn btn-info show-order-detail"><i class="fa fa-eye"></i></a>';
                if ($object->canCancel()) {
                    $result = $result . ' <a href="javascript:void(0)" title="Hủy đơn hàng" class="btn btn-danger cancel-order" data-href="'.route('front.cancel-order', $object->id).'"><i class="fa fa-trash"></i></a>';
                }
                $result = $result . '</div>';
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['action_client', 'code_client'])
            ->make(true);
    }

    public function userRevenue() {
        $user = Auth::guard('client')->user();
        $revenue_amount = OrderRevenueDetail::where('user_id', $user->id)->whereNotIn('status', [OrderRevenueDetail::STATUS_CANCEL])->sum('revenue_amount');
        $quyet_toan_amount = OrderRevenueDetail::where('user_id', $user->id)->where('status', OrderRevenueDetail::STATUS_QUYET_TOAN)
        ->orWhere(function($query) {
            $query->where('status', OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN)
            ->where('settlement_amount', '>', 0);
        })
        ->sum('settlement_amount');
        $waiting_quyet_toan_amount = OrderRevenueDetail::where('user_id', $user->id)->where('status', OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN)
        ->orWhere(function($query) {
            $query->where('status', OrderRevenueDetail::STATUS_QUYET_TOAN)
            ->where('settlement_amount', '>', 0);
        })->sum('revenue_amount') - $quyet_toan_amount;
        return view('site.admin.user_revenue', compact('user', 'revenue_amount', 'quyet_toan_amount', 'waiting_quyet_toan_amount'));
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
        // Mail::to('nguyentienvu4897@gmail.com')->send(new NewOrder($order, $config, 'admin'));


        if($users->count()) {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new WithdrawMoney($currentUser, $request->all()));
            }
        }
        return $this->responseSuccess('Đã gửi thông tin rút tiền, vui lòng chờ xác nhận');
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
