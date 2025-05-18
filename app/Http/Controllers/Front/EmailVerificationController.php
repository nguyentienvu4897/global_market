<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\EmailVerificationLinkMail;
use App\Http\Traits\ResponseTrait;
use App\Model\Common\User as AppUser;

class EmailVerificationController extends Controller
{
    use ResponseTrait;
    public function showRequestForm()
    {
        return view('site.mail-verify.request-verify');
    }

    public function sendVerificationLink(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.exists' => 'Email không tồn tại',
                'email.email' => 'Email không đúng định dạng',
                'email.required' => 'Vui lòng nhập email',
            ]
        );

        if ($validate->fails()) {
            return $this->responseErrors("Thao tác thất bại", $validate->errors());
        }

        $user = AppUser::where('email', $request->email)->first();
        if (!$user) {
            return $this->responseErrors("Thao tác thất bại", ['email' => 'Email không tồn tại']);
        }

        if ($user->email_verified_at) {
            return $this->responseSuccess("Email đã được xác minh", ['email' => 'Email đã được xác minh']);
        }

        $token = Str::random(64);
        $hashedToken = Hash::make($token);

        $user->email_verification_token = $hashedToken;
        $user->email_verification_sent_at = now();
        $user->save();

        // Gửi bản plain trong URL
        $link = route('email.verify.token', ['token' => $token]);
        Mail::to($user->email)->send(new EmailVerificationLinkMail($link));

        return $this->responseSuccess("Đã gửi liên kết xác minh email thành công");
    }

    public function verifyViaToken(Request $request)
    {
        $user = AppUser::whereNotNull('email_verification_token')
            ->whereNull('email_verified_at')
            ->get()
            ->first(function ($user) use ($request) {
                return Hash::check($request->token, $user->email_verification_token);
            });

        if (!$user) {
            $title = 'Xác minh email thất bại!';
            $content = 'Liên kết xác minh không hợp lệ hoặc đã hết hạn.';
            $status = 'failed';
            return view('site.mail-verify.verified-notice', compact('title', 'content', 'status'));
        }

        // Kiểm tra thời hạn 10 phút
        $expired = now()->diffInMinutes($user->email_verification_sent_at) > 10;

        if ($expired) {
            $title = 'Xác minh email thất bại!';
            $content = 'Liên kết xác minh đã hết hạn. Vui lòng gửi lại yêu cầu.';
            $status = 'failed';
            return view('site.mail-verify.verified-notice', compact('title', 'content', 'status'));
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->email_verification_sent_at = null;
        $user->save();

        $title = 'Xác minh email thành công!';
        $content = 'Bạn đã xác minh tài khoản thành công. Cảm ơn bạn đã đồng hành cùng chúng tôi.';
        $status = 'success';
        return view('site.mail-verify.verified-notice', compact('title', 'content', 'status'));
    }
}
