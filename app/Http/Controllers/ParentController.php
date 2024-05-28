<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Str;

class ParentController extends Controller
{
    public function list(){
        $data["getRecord"] = User::getParent();
        $data['header_title'] = "Parent List";
        return view("admin.parent.list", $data);
    }

    public function add(){

        $data["header_title"] = "Add new Parent";
        return view("admin.parent.add", $data);
    }


    public function insert(Request $request){

        request()->validate([
            'email' => 'required|email|unique:users',
            'mobile_number' =>'max:15|min:8'
        ]);

        $parent = new User;
        $parent->name = trim($request->name);
        $parent->lastname =trim($request->lastname);
        $parent->occupation =trim($request->occupation);
        $parent->address =trim($request->address);
        $parent->gender =trim($request->gender);
        if(!empty($request->file('profile_pic'))){
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $parent->profile_pic = $filename;
        }
        $parent->mobile_number =trim($request->mobile_number);
        $parent->status =trim($request->status);
        $parent->email = trim ($request->email);
        $parent->password = Hash::make($request->password);
        $parent->user_type = 4;
        $parent->save();

        return redirect("admin/parent/list")->with("success","Parent successfully created");
    }

    public function edit($id)
	{
		$data['getRecord'] = User::getSingle($id); 
		if(!empty($data['getRecord']))
		{
	
			$data['header_title'] = "Edit Parent"; 
			return view('admin.parent.edit', $data);
		}
		else
		{
			abort(404);
		}
	}
    public function update(Request $request, $id){

        request()->validate([
            'email' =>'required|email|unique:users,email,'.$id,
            'mobile_number' =>'max:15|min:8'
        ]);

        $parent = User::getSingle($id);
        $parent->name = trim($request->name);
        $parent->lastname =trim($request->lastname);
        $parent->occupation =trim($request->occupation);
        $parent->address =trim($request->address);
        $parent->gender =trim($request->gender);
        if(!empty($request->file('profile_pic'))){
            if(!empty($parent->getProfile()))
            {
                unlink('upload/profile/'.$parent->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $parent->profile_pic = $filename;
        }
        $parent->mobile_number =trim($request->mobile_number);
        $parent->status =trim($request->status);
        $parent->email = trim ($request->email);
        if(!empty($request->password))
        { 
            $parent->password = Hash::make($request->password);
        }
        $parent->user_type = 4;
        $parent->save();

        return redirect("admin/parent/list")->with("success","Parent successfully created");
    }	
    
    public function delete($id) 
	{
		$getRecord = User::getSingle($id); 
		if(!empty($getRecord)) 
		{
			$getRecord->is_delete = 1;
			$getRecord->save();
			
			return redirect()->back()->with('success', "Parent Successfully Deleted");
		
		}
		else
		{
		abort(404);
		}
	}
    public function myStudent($id){
        $data['parent_id'] = $id;   
        $data["getRecord"] = User::getParent();
        $data['header_title'] = "Parent Student List";
        return view("admin.parent.my_student", $data);
    }
}
