<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function list(){
        $data['getRecord'] = ClassModel::getRecord();

        $data['header_title'] = "Class List";
        return view("admin.class.list", $data);
    }

    public function add(){
        
        $data["header_title"] = "Add new Class";
        return view("admin.class.add", $data);
    }
    public function insert(Request $request){

        $user = new ClassModel;
        $user->name = $request->name;
        $user->status = $request->status;
        $user->created_by = Auth::user()->id;
        $user->save();

        return redirect("admin/class/list")->with("success","Class successfully created");
    }

    public function edit($id){
        $data['getRecord'] = ClassModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data["header_title"] = "Edit Class";
            return view("admin.class.edit", $data);
        }
        else{
            abort(404);
        }

    }


    
    public function update(Request $request, $id){

        $user = ClassModel::getSingle($id);
        $user->name = $request->name;
        $user->status = $request->status;
        $user->save();
        return redirect("admin/class/list")->with("success","Class successfully Updated");
    }

    public function delete($id){
        $user = ClassModel::getSingle($id);
        $user->is_delete = 1;
        $user->save();

        return redirect("admin/class/list")->with("success","Class successfully Deleted");
    }
}