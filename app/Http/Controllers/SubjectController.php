<?php

namespace App\Http\Controllers;

use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    public function list()
    {
        $data['getRecord'] = SubjectModel::getRecord();
        $data['header_title'] = "Subject List";
        Log::info('Subject list viewed.');
        return view("admin.subject.list", $data);
    }

    public function add()
    {
        $data["header_title"] = "Add Subject Class";
        Log::info('Subject add form viewed.');
        return view("admin.subject.add", $data);
    }

    public function insert(Request $request)
    {
        $user = new SubjectModel;
        $user->name = trim($request->name);
        $user->type = trim($request->type);
        $user->status = trim($request->status);
        $user->created_by = Auth::user()->id;
        $user->save();

        Log::info('Subject {id} created successfully.', ['id' => $user->id]);
        return redirect("admin/subject/list")->with("success", "Subject successfully created");
    }

    public function edit($id)
    {
        $data['getRecord'] = SubjectModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data["header_title"] = "Edit Subject";
            Log::info('Subject {id} edit form viewed.', ['id' => $id]);
            return view("admin.subject.edit", $data);
        } else {
            Log::warning('Subject {id} not found for edit.', ['id' => $id]);
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $user = SubjectModel::getSingle($id);
        $user->name = trim($request->name);
        $user->type = trim($request->type);
        $user->status = trim($request->status);
        $user->save();

        Log::info('Subject {id} updated successfully.', ['id' => $id]);
        return redirect("admin/subject/list")->with("success", "Subject successfully Updated");
    }

    public function delete($id)
    {
        $user = SubjectModel::getSingle($id);
        $user->is_delete = 1;
        $user->save();

        Log::info('Subject {id} deleted successfully.', ['id' => $id]);
        return redirect("admin/subject/list")->with("success", "Subject successfully Deleted");
    }
}
