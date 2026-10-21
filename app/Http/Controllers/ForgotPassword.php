<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Controller
{

    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    //  $output = new ConsoleOutput();
    //$output->writeln($request);

    $response = Password::broker()->sendResetLink(
        $request->only('email')
    );

    return $response == Password::RESET_LINK_SENT
                ? response()->json(['status' => 'success', 'message' => 'Reset link sent to your email.'], 200)
                : response()->json(['status' => 'error', 'message' => 'Unable to send reset link'], 200);
}



public function reset(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $response = Password::broker()->reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        }
    );

    return $response == Password::PASSWORD_RESET
                ? response()->json(['status' => 'success', 'message' => 'Password has been reset.'], 200)
                : response()->json(['status' => 'error', 'message' => 'Failed to reset password'], 500);
}
}
