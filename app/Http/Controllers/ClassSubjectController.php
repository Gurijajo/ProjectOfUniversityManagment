<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\SubjectModel;
use App\Models\ClassSubjectModel;
use App\Models\ClassModel;

class ClassSubjectController extends Controller
{
    public function list(Request $request){
        $data['getRecord'] = ClassSubjectModel::getRecord();

        $data['header_title'] = "Subject Assign List";
        return view("admin.assign_subject.list", $data);
    }

    public function add(){
        
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['header_title'] = "Subject Assign add";
        return view("admin.assign_subject.add", $data);;
    }


    public function insert(Request $request){   
        if(!empty ($request->subject_id)){
            foreach($request->subject_id as $subject_id){
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
                if(!empty($getAlreadyFirst)){
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }else{  
                $save = new ClassSubjectModel();
                $save->class_id = $request->class_id;
                $save->subject_id = $subject_id;
                $save->status = $request->status;
                $save->created_by = Auth::user()->id;
                $save->save();
                }
            }

            return redirect('admin/assign_subject/list')->with("success","Subject Successfully Assign to Class");

        }else{

            return redirect("")->back()->with("error","There is Some Error, Try Again!");

        }
    }

    public function edit($id){
        $getRecord = ClassSubjectModel::getSingle($id);
        if(!empty($getRecord)){
            $data['getRecord'] = $getRecord;
            $data['getAssignSubjectID'] = ClassSubjectModel::getAssignSubjectID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = "Subject Assign Edit";
            return view("admin.assign_subject.edit", $data);;
        }else{
            abort(404);
        }
    }

    public function update(Request $request){
        ClassSubjectModel::deleteSubject($request->class_id);

        if(!empty ($request->subject_id)){
            foreach($request->subject_id as $subject_id){
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
                if(!empty($getAlreadyFirst)){
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }else{  
                $save = new ClassSubjectModel();
                $save->class_id = $request->class_id;
                $save->subject_id = $subject_id;
                $save->status = $request->status;
                $save->created_by = Auth::user()->id;
                $save->save();
                }
            }

        }
        return redirect('admin/assign_subject/list')->with("success","Subject Assign to Class Successfully Updated");
    }

    public function delete($id){
        $user = ClassSubjectModel::getSingle($id);
        $user->is_delete = 1;
        $user->save();

        return redirect("admin/assign_subject/list")->with("success","Successfully Deleted");
    }

    public function edit_single($id)
	{
		$getRecord = ClassSubjectModel::getSingle($id);
		if(!empty($getRecord))
		{
			$data['getRecord'] = $getRecord;
			$data['getClass'] = ClassModel::getClass();
			$data['getSubject'] = SubjectModel::getSubject();
			$data['header_title'] = "Edit Assign Subject";
			return view('admin.assign_subject.edit_single', $data);
			}
			else
			{
				abort(404);
			}
	}

    public function update_single($id, Request $request)
        {
            $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $request->subject_id);
            if(!empty($getAlreadyFirst))
            {
                $getAlreadyFirst->status = $request->status;
                $getAlreadyFirst->save();
                return redirect('admin/assign_subject/list')->with('success', "Status Sucessfully Updated");
            }
            else 
            {
                $save = ClassSubjectModel::getSingle($id);
                $save->class_id = $request->class_id;
                $save->subject_id = $request->subject_id;
                $save->status = $request->status; 
                $save->save();
                
                return redirect('admin/assign_subject/list')->with('success', "Subject Sucessfully Assign to Class");
            }
        }
    
    }
