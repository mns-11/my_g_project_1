<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);
        if (Auth::attempt($credentials)) {
            return redirect()->route('redirection.dashboard');
        }
        return back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function sendPasswordLink(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users'
        ];

        $attributes = [
            'email' => __('main.email')
        ];


        $validator = Validator::make(data: $request->all(), rules: $rules, attributes: $attributes);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'forgotPasswordErrors')->withInput();
        }

        $email = $request->input('email', null);


        try {
            Password::sendResetLink(['email' => $email]);
            return redirect('/login')->with(['message' => ucwords(__('main.sent'))]);
        } catch (\Exception $e) {
            Log::error("Failed to send reset password email to: {$email}. Error: {$e->getMessage()}");
        }
    }

    public function resetPassword(Request $request, string $token)
    {
        $email = $request->query('email');
        return view('auth.reset-password', compact(['token', 'email']));

    }

    public function updatePassword(Request $request)
    {
     $rules = [
         'token' => 'required',
         'email' => 'required|email|exists:users,email',
         'password' => 'required|min:8|confirmed'
     ];

        $attributes = [
            'email' => __('main.email'),
            'password' => __('main.password'),
            'token' => __('main.token')
        ];
        $validator = Validator::make(data: $request->all(), rules: $rules, attributes: $attributes);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'forgotPasswordErrors')->withInput();
        }

        $email = $request->input('email', null);
        $password = $request->input('password', null);
        $token = $request->input('token', null);

        $status = Password::reset(
            ['email' => $email, 'password' => $password, 'token' => $token],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        return redirect('/login')->with(['message' => $status === 'passwords.reset' ? ucwords(__('main.successfully_edited')) : ucwords(__('main.edit_process_failed'))]);


    }
}
