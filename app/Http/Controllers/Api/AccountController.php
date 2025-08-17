<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SyncUserAccountJob;
use App\Model\Common\User;
use Illuminate\Support\Str;
use App\Mail\EmailVerificationLinkMail;
use Exception;
use Response;
use App\Model\Admin\OrderRevenueDetail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    use ResponseTrait;

    // API Logout
    public function apiLogout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return Response::json([
            'success' => true,
            'message' => 'Đăng xuất thành công',
            'code' => 200
        ]);
    }

    // API Đăng ký
    public function apiRegister(Request $request)
    {
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
            return Response::json([
                'success' => false,
                'message' => "Thao tác thất bại",
                'errors' => $validate->errors(),
                'code' => 400
            ]);
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

            // Xác minh email
            $token = Str::random(64);
            $hashedToken = Hash::make($token);
            $object->email_verification_token = $hashedToken;
            $object->email_verification_sent_at = now();
            $object->save();
            // Gửi bản plain trong URL
            $link = route('email.verify.token', ['token' => $token]);
            Mail::to($object->email)->send(new EmailVerificationLinkMail($link));

            // $syncUserAccountService = new SyncUserAccountService();
            // $syncUserAccountService->sendSyncUserAccount($object);

            SyncUserAccountJob::dispatch($object);

            DB::commit();
            $data = [
                'account_name' => $request->account_name,
                'password' => $request->password,
            ];
            return Response::json([
                'success' => true,
                'message' => "Đăng ký thành công!",
                'data' => $data,
                'code' => 200
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'success' => false,
                'message' => "Đăng ký thất bại!",
                'errors' => $e->getMessage(),
                'code' => 400
            ]);
        }
    }

    // API Đăng nhập
    public function apiLogin(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'account_name' => 'required',
                'password' => 'required',
            ]
        );

        if ($validate->fails()) {
            return Response::json([
                'success' => false,
                'message' => "Thông tin đăng nhập chưa đủ!",
                'errors' => $validate->errors(),
                'code' => 400
            ]);
        }

        $remember = true;

        // Xác định trường nào sẽ dùng để đăng nhập (email hoặc account_name)
        $field = filter_var($request->account_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'account_name';

        // Thay đổi mảng điều kiện xác thực
        $loginConditions = [
            $field    => $request->account_name,
            'password' => $request->password,
            'status'   => 1,
            'type'     => [10, 20, 30]
        ];

        if (!$token = JWTAuth::attempt($loginConditions)) {
            return Response::json([
                'success' => false,
                'message' => 'Tài khoản hoặc mật khẩu không chính xác',
                'code' => 401
            ]);
        }

        $user = JWTAuth::user();
        // $user = Auth::guard('api')->user();

        return Response::json([
            'success' => true,
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'data' => $user,
            'code' => 200
        ]);
    }

    // API Lấy thông tin tài khoản
    public function apiInfo()
    {
        $user = Auth::guard('api')->user();
        return Response::json([
            'success' => true,
            'message' => 'Lấy thông tin tài khoản thành công',
            'data' => $user,
            'code' => 200
        ]);
    }

    // API Lấy số tiền chờ quyết toán
    public function apiWaitingRevenueAmount()
    {
        $user = Auth::guard('api')->user();
        if ($user) {
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
        } else {
            $waiting_quyet_toan_amount = 0;
        }
        return Response::json([
            'success' => true,
            'message' => 'Lấy số tiền chờ quyết toán thành công',
            'data' => $waiting_quyet_toan_amount,
            'code' => 200
        ]);
    }
}
