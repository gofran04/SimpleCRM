<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\ResetPasswordRequest;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendEmail(ResetPasswordRequest $request)
    {
        $validated = $request->validated();
        $status = Password::sendResetLink(['email' => $validated['email']]);
        return $status == Password::RESET_LINK_SENT
                    ? response()->json(['message' => __('We Sent You An Email with Reset Link, Follow Instructions To Reset Your Password')])
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
