<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';
        $user = Auth::user();

        if ($user) {
            switch ($user->user_type) {
                case 1:
                    Log::info('Admin dashboard viewed by user {id}.', ['id' => $user->id]);
                    return view('admin.dashboard', $data);
                case 2:
                    Log::info('Teacher dashboard viewed by user {id}.', ['id' => $user->id]);
                    return view('teacher.dashboard', $data);
                case 3:
                    Log::info('Student dashboard viewed by user {id}.', ['id' => $user->id]);
                    return view('student.dashboard', $data);
                case 4:
                    Log::info('Parent dashboard viewed by user {id}.', ['id' => $user->id]);
                    return view('parent.dashboard', $data);
                default:
                    Log::warning('Invalid user type {user_type} for user {id}.', ['user_type' => $user->user_type, 'id' => $user->id]);
                    abort(403, 'Unauthorized action.');
            }
        } else {
            Log::error('Unauthenticated access attempt to dashboard.');
            abort(401, 'Unauthorized');
        }
    }
}
