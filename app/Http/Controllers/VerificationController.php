<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request) {
      /*   if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        } */
    
        $user = User::findOrFail($user_id);
      //  return $user;
    
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    
        return response()->json(["massage" => "Your Email verified successfully"], 401);

    }
    
    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }
    
        auth()->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
