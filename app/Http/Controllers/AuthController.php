<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Mail;
use Str;
use Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (!empty(Auth::check())) {
            if (Auth::user()->user_type == 1) {
                Log::info('Admin user {id} logged in.', ['id' => Auth::id()]);
                return redirect('admin/dashboard');
            } elseif (Auth::user()->user_type == 2) {
                Log::info('Teacher user {id} logged in.', ['id' => Auth::id()]);
                return redirect('teacher/dashboard');
            } elseif (Auth::user()->user_type == 3) {
                Log::info('Student user {id} logged in.', ['id' => Auth::id()]);
                return redirect('student/dashboard');
            } elseif (Auth::user()->user_type == 4) {
                Log::info('Parent user {id} logged in.', ['id' => Auth::id()]);
                return redirect('parent/dashboard');
            }
        }
        return view('auth.login');
    }

    public function AuthLogin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            if (Auth::user()->user_type == 1) {
                Log::info('Admin user {id} logged in.', ['id' => Auth::id()]);
                return redirect('admin/dashboard');
            } elseif (Auth::user()->user_type == 2) {
                Log::info('Teacher user {id} logged in.', ['id' => Auth::id()]);
                return redirect('teacher/dashboard');
            } elseif (Auth::user()->user_type == 3) {
                Log::info('Student user {id} logged in.', ['id' => Auth::id()]);
                return redirect('student/dashboard');
            } elseif (Auth::user()->user_type == 4) {
                Log::info('Parent user {id} logged in.', ['id' => Auth::id()]);
                return redirect('parent/dashboard');
            }
        } else {
            Log::warning('User login attempt failed.', ['email' => $request->email]);
            return redirect()->back()->with('error', 'Please Enter current Email and Password');
        }
    }

    public function PostForgotPassword(Request $request)
    {
        $user = User::getEmailsingle($request->email);
        if (!empty($user)) {
            $user->remember_token = Str::random(30);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            Log::info('Forgot password email sent to user {id}.', ['id' => $user->id]);
            return redirect()->back()->with('success', 'Please check your email and reset your password');
        } else {
            Log::warning('Forgot password attempt failed. Email not found.', ['email' => $request->email]);
            return redirect()->back()->with('error', 'Email not Found');
        }
    }

    public function reset($remember_token)
    {
        $user = User::getTokensingle($remember_token);
        if (!empty($user)) {
            $data['user'] = $user;
            Log::info('User {id} is attempting to reset password.', ['id' => $user->id]);
            return view('auth.reset', $data);
        } else {
            Log::error('Invalid token for password reset.', ['token' => $remember_token]);
            abort(404);
        }
    }

    public function Postreset($token, Request $request)
    {
        if ($request->password == $request->cpassword) {
            $user = User::getTokensingle($token);
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();
            
            Log::info('User {id} has reset password successfully.', ['id' => $user->id]);
            return redirect(url(''))->with('success', 'Password reset successfully');
        } else {
            Log::warning('Password reset attempt failed. Passwords do not match.', ['token' => $token]);
            return redirect()->back()->with('error', 'Password and Confirm Password does not match');
        }
    }

    public function forgotpassword()
    {
        return view('auth.forgot');
    }

    public function logout()
    {
        Log::info('User {id} logged out.', ['id' => Auth::id()]);
        Auth::logout();
        return redirect(url(''));
    }
}
