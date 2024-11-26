<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
     // Ipakita ang forgot password form
     public function showLinkRequestForm()
     {
         return view('auth.forgotPass');
     }

     // I-send ang reset link
     public function sendResetLink(Request $request)
     {
         $request->validate(['email' => 'required|email']);

         $status = Password::sendResetLink(
             $request->only('email')
         );

         return $status === Password::RESET_LINK_SENT
             ? back()->with(['status' => __($status)])
             : back()->withErrors(['email' => __($status)]);
     }

     // Ipakita ang reset password form
     public function showResetForm($token)
     {
         return view('auth.resetpass', ['token' => $token]);
     }

     // I-reset ang password
     public function reset(Request $request)
     {
         $request->validate([
             'token' => 'required',
             'email' => 'required|email|exists:users,email',
             'password' => 'required|min:6|confirmed',
         ]);

         $status = Password::reset(
             $request->only('email', 'password', 'password_confirmation', 'token'),
             function ($user, $password) {
                 $user->forceFill([
                     'password' => bcrypt($password),
                 ])->save();

                 $user->setRememberToken(Str::random(60));
             }
         );

         if ($status === Password::PASSWORD_RESET) {
             return redirect()->route('password.reset.success');
         }

         return back()->withErrors(['email' => [__($status)]]);
     }
     function resetSuccess() {
        return view('auth.reset-success');
    }

}
