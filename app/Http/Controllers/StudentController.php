<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use App\Models\User;
use App\Models\ClassModel;

class StudentController extends Controller
{
    public function list()
    {
        $data["getRecord"] = User::getStudent();
        $data['header_title'] = "Student List";
        Log::info('Student list viewed.');
        return view("admin.student.list", $data);
    }

    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data["header_title"] = "Add new Student";
        Log::info('Student add form viewed.');
        return view("admin.student.add", $data);
    }

    public function insert(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users',
            'mobile_number' => 'max:15|min:8',
            'admission_number' => 'max:50',
            'roll_number' => 'max:50',
        ]);

        $student = new User;
        $student->name = trim($request->name);
        $student->lastname = trim($request->lastname);
        $student->admission_number = trim($request->admission_number);
        $student->roll_number = trim($request->roll_number);
        $student->class_id = trim($request->class_id);
        $student->gender = trim($request->gender);
        if (!empty($request->date_of_birth)) {
            $student->date_of_birth = trim($request->date_of_birth);
        }
        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile/', $filename);
            $student->profile_pic = $filename;
        }

        $student->mobile_number = trim($request->mobile_number);
        if (!empty($request->admission_date)) {
            $student->admission_date = trim($request->admission_date);
        }
        $student->status = trim($request->status);
        $student->email = trim($request->email);
        $student->password = Hash::make($request->password);
        $student->user_type = 3;
        $student->save();

        Log::info('Student {id} created successfully.', ['id' => $student->id]);
        return redirect("admin/student/list")->with("success", "Student successfully created");
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = "Edit Student";
            Log::info('Student {id} edit form viewed.', ['id' => $id]);
            return view('admin.student.edit', $data);
        } else {
            Log::warning('Student {id} not found for edit.', ['id' => $id]);
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'max:15|min:8',
            'admission_number' => 'max:50',
            'roll_number' => 'max:50',
        ]);

        $student = User::getSingle($id);
        $student->name = trim($request->name);
        $student->lastname = trim($request->lastname);
        $student->admission_number = trim($request->admission_number);
        $student->roll_number = trim($request->roll_number);
        $student->class_id = trim($request->class_id);
        $student->gender = trim($request->gender);
        if (!empty($request->date_of_birth)) {
            $student->date_of_birth = trim($request->date_of_birth);
        }
        if (!empty($request->file('profile_pic'))) {
            if (!empty($student->getProfile())) {
                unlink('upload/profile/' . $student->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile/', $filename);
            $student->profile_pic = $filename;
        }

        $student->mobile_number = trim($request->mobile_number);
        if (!empty($request->admission_date)) {
            $student->admission_date = trim($request->admission_date);
        }
        $student->status = trim($request->status);
        $student->email = trim($request->email);
        if (!empty($request->password)) {
            $student->password = Hash::make($request->password);
        }
        $student->user_type = 3;
        $student->save();

        Log::info('Student {id} updated successfully.', ['id' => $id]);
        return redirect("admin/student/list")->with("success", "Student successfully updated");
    }

    public function delete($id)
    {
        $getRecord = User::getSingle($id);
        if (!empty($getRecord)) {
            $getRecord->is_delete = 1;
            $getRecord->save();
            Log::info('Student {id} deleted successfully.', ['id' => $id]);
            return redirect()->back()->with('success', "Student successfully deleted");
        } else {
            Log::warning('Student {id} not found for deletion.', ['id' => $id]);
            abort(404);
        }
    }
}
