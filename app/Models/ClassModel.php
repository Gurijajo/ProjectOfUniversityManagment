<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
class ClassModel extends Model
{
    use HasFactory;

    protected $table = "class";

    static public function getSingle($id){
        return self::find($id); 
    }

    static public function getRecord(){
        $return = ClassModel::select('class.*', 'users.name as created_by_name')
                                    ->join('users','users.id','=','created_by');
                                    if(!empty(Request::get('name'))){
                                        $return = $return->where('class.name','LIKE','%'.Request::get('name').'%');
                                    }
                                $return = $return->where('class.is_delete', '=', 0)
                                    ->orderBy('class.id','desc')
                                    ->paginate(20);

        return $return;
    }
}
