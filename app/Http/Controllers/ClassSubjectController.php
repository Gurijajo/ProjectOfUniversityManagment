<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SubjectModel;
use App\Models\ClassSubjectModel;
use App\Models\ClassModel;

class ClassSubjectController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecord'] = ClassSubjectModel::getRecord();
        $data['header_title'] = "Subject Assign List";
        Log::info('Subject assignment list viewed by user {id}.', ['id' => Auth::id()]);
        return view("admin.assign_subject.list", $data);
    }

    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['header_title'] = "Subject Assign Add";
        Log::info('Subject assignment add form viewed by user {id}.', ['id' => Auth::id()]);
        return view("admin.assign_subject.add", $data);
    }

    public function insert(Request $request)
    {
        if (!empty($request->subject_id)) {
            foreach ($request->subject_id as $subject_id) {
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else {
                    $save = new ClassSubjectModel();
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            Log::info('Subjects successfully assigned to class {class_id} by user {id}.', ['class_id' => $request->class_id, 'id' => Auth::id()]);
            return redirect('admin/assign_subject/list')->with("success", "Subject Successfully Assigned to Class");
        } else {
            Log::error('Subject assignment failed due to missing subject IDs for class {class_id} by user {id}.', ['class_id' => $request->class_id, 'id' => Auth::id()]);
            return redirect()->back()->with("error", "There is Some Error, Try Again!");
        }
    }

    public function edit($id)
    {
        $getRecord = ClassSubjectModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getAssignSubjectID'] = ClassSubjectModel::getAssignSubjectID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = "Subject Assign Edit";
            Log::info('Subject assignment edit form viewed for assignment {id} by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
            return view("admin.assign_subject.edit", $data);
        } else {
            Log::warning('Subject assignment {id} not found for editing by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
            abort(404);
        }
    }

    public function update(Request $request)
    {
        ClassSubjectModel::deleteSubject($request->class_id);

        if (!empty($request->subject_id)) {
            foreach ($request->subject_id as $subject_id) {
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else {
                    $save = new ClassSubjectModel();
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
        }
        Log::info('Subjects for class {class_id} updated successfully by user {id}.', ['class_id' => $request->class_id, 'id' => Auth::id()]);
        return redirect('admin/assign_subject/list')->with("success", "Subject Assign to Class Successfully Updated");
    }

    public function delete($id)
    {
        $user = ClassSubjectModel::getSingle($id);
        if ($user) {
            $user->is_delete = 1;
            $user->save();
            Log::info('Subject assignment {id} marked as deleted by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
            return redirect("admin/assign_subject/list")->with("success", "Successfully Deleted");
        } else {
            Log::warning('Subject assignment {id} not found for deletion by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
            return redirect("admin/assign_subject/list")->with("error", "Record not Found");
        }
    }

    public function edit_single($id)
    {
        $getRecord = ClassSubjectModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = "Edit Assign Subject";
            Log::info('Single subject assignment edit form viewed for assignment {id} by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
            return view('admin.assign_subject.edit_single', $data);
        } else {
            Log::warning('Single subject assignment {id} not found for editing by user {user_id}.', ['id' => $id, 'user_id' => Auth::id()]);
            abort(404);
        }
    }

    public function update_single($id, Request $request)
    {
        $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $request->subject_id);
        if (!empty($getAlreadyFirst)) {
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->save();
            Log::info('Single subject assignment status updated for class {class_id}, subject {subject_id} by user {id}.', ['class_id' => $request->class_id, 'subject_id' => $request->subject_id, 'id' => Auth::id()]);
            return redirect('admin/assign_subject/list')->with('success', "Status Successfully Updated");
        } else {
            $save = ClassSubjectModel::getSingle($id);
            $save->class_id = $request->class_id;
            $save->subject_id = $request->subject_id;
            $save->status = $request->status;
            $save->save();
            Log::info('Single subject assignment updated for class {class_id}, subject {subject_id} by user {id}.', ['class_id' => $request->class_id, 'subject_id' => $request->subject_id, 'id' => Auth::id()]);
            return redirect('admin/assign_subject/list')->with('success', "Subject Successfully Assigned to Class");
        }
    }
}
