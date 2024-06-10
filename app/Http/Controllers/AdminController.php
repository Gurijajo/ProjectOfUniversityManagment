<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Hash;

class AdminController extends Controller
{
    public function list()
    {
        $data["getRecord"] = User::getAdmin();
        $data['header_title'] = "Admin List";
        Log::info('Admin list viewed.');
        return view("admin.admin.list", $data);
    }

    public function add()
    {
        $data["header_title"] = "Add new Admin";
        Log::info('Admin add form viewed.');
        return view("admin.admin.add", $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();

        Log::info('Admin {id} created successfully.', ['id' => $user->id]);
        return redirect("admin/admin/list")->with("success", "Admin successfully created");
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data["header_title"] = "Edit Admin";
            Log::info('Admin {id} edit form viewed.', ['id' => $id]);
            return view("admin.admin.edit", $data);
        } else {
            Log::warning('Admin {id} not found for editing.', ['id' => $id]);
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        $user = User::getSingle($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        Log::info('Admin {id} updated successfully.', ['id' => $id]);
        return redirect("admin/admin/list")->with("success", "Admin successfully Updated");
    }

    public function delete($id)
    {
        $user = User::getSingle($id);
        if ($user) {
            $user->delete();
            Log::info('Admin {id} deleted successfully.', ['id' => $id]);
            return redirect("admin/admin/list")->with("success", "Admin successfully Deleted");
        } else {
            Log::warning('Admin {id} not found for deletion.', ['id' => $id]);
            return redirect("admin/admin/list")->with("error", "User not Found");
        }
    }
}
