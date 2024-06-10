<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class UserController extends Controller
{
    public function change_password()
    {
        $data['header_title'] = "Change Password";
        return view('profile.change_password', $data);
    }

    public function update_change_password(Request $request)
    {
        $user = User::getSingle(Auth::user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            Log::info('User {id} changed password.', ['id' => Auth::user()->id]);
            return redirect()->back()->with('success', "Password successfully updated");
        } else {
            Log::warning('User {id} attempted to change password with incorrect old password.', ['id' => Auth::user()->id]);
            return redirect()->back()->with('error', "Old Password is not Correct");
        }
    }

    public function contact_support()
    {
        $data["header_title"] = "Contact Support";
        return view('profile.contact_support', $data);
    }
}
