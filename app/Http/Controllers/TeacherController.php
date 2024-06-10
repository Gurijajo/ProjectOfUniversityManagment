<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use App\Models\ClassModel;
use Str;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    public function list()
    {
        $data["getRecord"] = User::getTeacher();
        $data['header_title'] = "Teacher List";
        Log::info('Teacher list viewed.');
        return view("admin.teacher.list", $data);
    }

    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data["header_title"] = "Add new Teacher";
        Log::info('Teacher add form viewed.');
        return view("admin.teacher.add", $data);
    }

    public function insert(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users',
            'mobile_number' =>'max:15|min:8',
            'admission_number' =>'max:50',
            'roll_number' =>'max:50',
        ]);

        $Teacher = new User;
        $Teacher->name = trim($request->name);
        $Teacher->lastname = trim($request->lastname);
        $Teacher->class_id = trim($request->class_id);
        $Teacher->gender = trim($request->gender);
        if (!empty($request->date_of_birth)) {
            $Teacher->date_of_birth = trim($request->date_of_birth);
        }
        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile/', $filename);
            $Teacher->profile_pic = $filename;
        }

        $Teacher->mobile_number = trim($request->mobile_number);

        if (!empty($request->admission_date)) {
            $Teacher->admission_date = trim($request->admission_date);
        }
        $Teacher->status = trim($request->status);
        $Teacher->email = trim($request->email);
        $Teacher->password = Hash::make($request->password);
        $Teacher->user_type = 2;
        $Teacher->save();

        Log::info('Teacher {id} created successfully.', ['id' => $Teacher->id]);
        return redirect("admin/teacher/list")->with("success", "Teacher successfully created");
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = "Edit Teacher";
            Log::info('Teacher {id} edit form viewed.', ['id' => $id]);
            return view('admin.teacher.edit', $data);
        } else {
            Log::warning('Teacher {id} not found for edit.', ['id' => $id]);
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'email' =>'required|email|unique:users,email,'.$id,
            'mobile_number' =>'max:15|min:8',
            'admission_number' =>'max:50',
            'roll_number' =>'max:50',
        ]);

        $Teacher = User::getSingle($id);
        $Teacher->name = trim($request->name);
        $Teacher->lastname = trim($request->lastname);
        $Teacher->class_id = trim($request->class_id);
        $Teacher->gender = trim($request->gender);
        if (!empty($request->date_of_birth)) {
            $Teacher->date_of_birth = trim($request->date_of_birth);
        }
        if (!empty($request->file('profile_pic'))) {
            if (!empty($Teacher->getProfile())) {
                unlink('upload/profile/' . $Teacher->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile/', $filename);
            $Teacher->profile_pic = $filename;
        }

        $Teacher->mobile_number = trim($request->mobile_number);

        if (!empty($request->admission_date)) {
            $Teacher->admission_date = trim($request->admission_date);
        }
        $Teacher->status = trim($request->status);
        $Teacher->email = trim($request->email);
        if (!empty($request->password)) {
            $Teacher->password = Hash::make($request->password);
        }
        $Teacher->user_type = 3;
        $Teacher->save();

        Log::info('Teacher {id} updated successfully.', ['id' => $id]);
        return redirect("admin/teacher/list")->with("success", "Teacher successfully updated");
    }
    
    public function delete($id) 
	{
		$getRecord = User::getSingle($id); 
		if(!empty($getRecord)) 
		{
			$getRecord->is_delete = 1;
			$getRecord->save();
			Log::info('Teacher {id} deleted successfully.', ['id' => $id]);
			return redirect()->back()->with('success', "Teacher Successfully Deleted");
		
		}
		else
		{
        Log::warning('Teacher {id} not found for deletion.', ['id' => $id]);
		abort(404);
		}
	}


}
