<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ThrottlePerUser extends ThrottleRequests
{

    protected function resolveRequestSignature($request)
    {
        // Nếu email tồn tại trong request thì dùng nó làm key
        if ($email = $request->input('email')) {
            return sha1($email); // mã hóa email làm key throttle
        }

        // fallback: dùng IP như mặc định
        return $request->ip();
    }

    protected function buildResponse($key, $maxAttempts, $retryAfter)
    {
        $message = "Bạn đã gửi yêu cầu quá nhiều lần. Vui lòng thử lại sau {$retryAfter} giây.";

        if (request()->expectsJson()) {
            return response()->json([
                'message' => $message
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        // Web (non-AJAX): redirect với session error
        return redirect()
            ->back()
            ->withErrors(['email' => $message])
            ->withInput();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
    }
}
