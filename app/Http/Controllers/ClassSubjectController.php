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
}
