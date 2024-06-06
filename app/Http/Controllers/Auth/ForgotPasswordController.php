<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    
    public function sendResetLinkEmail(Request $request)
{
    // dd("ohkk");
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
        // Toastr::success('Password reset link has been sent to your email', 'Success', ["positionClass" => "toast-top-right"]);
        notify('We have emailed your password reset link.',"Success","success");
        return back()->with(['status' => __($status)]);
    }

    // Toastr::error(__($status), 'Error', ["positionClass" => "toast-top-right"]);
    // notify('Something went wrong.',"Error","error");
    return back()->withErrors(['email' => __($status)]);
}
}
