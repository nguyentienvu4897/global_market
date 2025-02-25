<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;
use App\Http\Traits\ResponseTrait;
class OtpService
{
    use ResponseTrait;
    protected $maxAttempts = 5; // Số lần nhập sai tối đa
    protected $resendCooldown = 60; // Giới hạn gửi lại OTP (giây)

    public function sendOtp($user)
    {
        // Kiểm tra thời gian chặn gửi lại OTP
        $lastSent = Cache::get("otp_sent_at_{$user->id}");
        if ($lastSent && Carbon::now()->diffInSeconds($lastSent) < $this->resendCooldown) {
            $errors = [
                'otp' => 'Vui lòng đợi trước khi gửi lại OTP.'
            ];
            return $this->responseErrors('Vui lòng đợi trước khi gửi lại OTP.', $errors);
        }

        // Tạo OTP ngẫu nhiên
        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(5);

        // Lưu OTP vào Redis
        Cache::put("otp_{$user->id}", $otp, $expiresAt);
        Cache::put("otp_sent_at_{$user->id}", Carbon::now(), $expiresAt);
        Cache::put("otp_attempts_{$user->id}", 0, $expiresAt);

        // Gửi email OTP
        Mail::to($user->email)->send(new OtpMail($otp));
        // Mail::to('nguyentienvu4897@gmail.com')->send(new OtpMail($otp));

        return $this->responseSuccess('OTP đã được gửi qua email!');
    }

    public function verifyOtp($user, $inputOtp)
    {
        $storedOtp = Cache::get("otp_{$user->id}");
        $attempts = Cache::get("otp_attempts_{$user->id}", 0);

        if (!$storedOtp) {
            $errors = [
                'otp' => 'OTP đã hết hạn hoặc không tồn tại.'
            ];
            return $this->responseErrors('OTP đã hết hạn hoặc không tồn tại.', $errors);
        }

        if ($attempts >= $this->maxAttempts) {
            $errors = [
                'otp' => 'Bạn đã nhập sai OTP quá số lần cho phép.'
            ];
            return $this->responseErrors('Bạn đã nhập sai OTP quá số lần cho phép.', $errors);
        }

        if ($storedOtp != $inputOtp) {
            Cache::increment("otp_attempts_{$user->id}");
            $errors = [
                'otp' => 'OTP không chính xác.'
            ];
            return $this->responseErrors('OTP không chính xác.', $errors);
        }

        // Xóa OTP sau khi xác thực thành công
        Cache::forget("otp_{$user->id}");
        Cache::forget("otp_attempts_{$user->id}");
        Cache::forget("otp_sent_at_{$user->id}");

        return $this->responseSuccess('Xác thực thành công.');
    }
}
