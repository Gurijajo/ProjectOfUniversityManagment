<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function list()
    {
        $data['getRecord'] = ClassModel::getRecord();
        $data['header_title'] = "Class List";
        Log::info('Class list viewed by user {id}.', ['id' => Auth::id()]);
        return view("admin.class.list", $data);
    }

    public function add()
    {
        $data["header_title"] = "Add new Class";
        Log::info('Class add form viewed by user {id}.', ['id' => Auth::id()]);
        return view("admin.class.add", $data);
    }

    public function insert(Request $request)
    {
        $user = new ClassModel;
        $user->name = $request->name;
        $user->status = $request->status;
        $user->created_by = Auth::user()->id;
        $user->save();

        Log::info('Class {id} created successfully by user {user_id}.', ['id' => $user->id, 'user_id' => Auth::id()]);
        return redirect("admin/class/list")->with("success", "Class successfully created");
    }

    public function edit($id)
    {
        $data['getRecord'] = ClassModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data["header_title"] = "Edit Class";
            Log::info('Class {id} edit form viewed by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
            return view("admin.class.edit", $data);
        } else {
            Log::warning('Class {id} not found for editing by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $user = ClassModel::getSingle($id);
        $user->name = $request->name;
        $user->status = $request->status;
        $user->save();

        Log::info('Class {id} updated successfully by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
        return redirect("admin/class/list")->with("success", "Class successfully Updated");
    }

    public function delete($id)
    {
        $user = ClassModel::getSingle($id);
        $user->is_delete = 1;
        $user->save();

        Log::info('Class {id} marked as deleted by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
        return redirect("admin/class/list")->with("success", "Class successfully Deleted");
    }
}
