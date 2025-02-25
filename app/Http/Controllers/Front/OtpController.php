<?php

namespace App\Http\Controllers\Front;

use App\Model\Common\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    use ResponseTrait;

    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendOtp(Request $request)
    {
        $rule = [
			'withdrawAmount' => 'required|numeric|min:100000|max:'.$request->waitingQuyetToanAmount,
		];

		$validate = Validator::make(
			$request->all(),
			$rule,
            [
                'withdrawAmount.required' => 'Số tiền cần rút không được để trống',
                'withdrawAmount.numeric' => 'Số tiền cần rút không được để trống',
                'withdrawAmount.min' => 'Số tiền rút tối thiểu là 100.000 VNĐ',
            ]
		);

		if ($validate->fails()) {
			return $this->responseErrors("Thao tác thất bại", $validate->errors());
		}

        $user = Auth::guard('client')->user();
        if(!$user) {
            return $this->responseErrors("Email không tồn tại.");
        }
        return $this->otpService->sendOtp($user);
    }

    public function verifyOtp(Request $request)
    {
        $user = Auth::guard('client')->user();
        if(!$user) {
            $errors = [
                'otp' => 'Email không tồn tại.'
            ];
            return $this->responseErrors("Email không tồn tại.", $errors);
        }
        return $this->otpService->verifyOtp($user, $request->otp);
    }
}
