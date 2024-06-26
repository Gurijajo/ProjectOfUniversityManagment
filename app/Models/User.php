<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function getSingle($id){
        return self::find($id); 
    }


    static public function getAdmin()
    {
        $return = self::select('users.*')->where('user_type', '=',1);
                    if(!empty(Request::get('name'))){
                        $return = $return->where('name','LIKE','%'.Request::get('name').'%');
                    }

                    if(!empty(Request::get('email'))){
                        $return = $return->where('email','LIKE','%'.Request::get('email').'%');
                    }
                    // if(!empty(Request::get('date'))){
                    //     $return = $return->whereDate('created_at','=',Request::get('created_at'));
                    // }

        $return = $return->orderBy('id','desc')->paginate(10);

        return $return;
    }

    static public function getEmailsingle($email){
        return User::where('email', '=', $email)->first();
    }

        static public function getTokensingle($remember_token){
        return User::where('remember_token', '=', $remember_token)->first();
    }
    static public function getStudent()
    {
        $return = self::select('users.*', 'class.name as class_name')->join('class', 'class.id', '=', 'users.class_id', 'left')->where('users.user_type', '=',3)->where('users.is_delete', '=', 0);
        if(!empty(Request::get('name')))
        {
         $return = $return->where('users.name', 'like', '%' .Request::get('name').'%');
        }
        
        if(!empty(Request::get('lastname')))
        {
        $return = $return->where('users.lastname', 'like', '%' .Request::get('lastname').'%');
        }
        if(!empty(Request::get('email')))
        {
          $return = $return->where('users.email', 'like', '%' .Request::get('email').'%');
        }       
        if(!empty(Request::get('class')))
        {
         $return = $return->where('class.name', 'like', '%' .Request::get('class').'%');
         }
         if(!empty(Request::get('status')))
         {
          $status = (Request::get('status') == 0) ? 0 : 1;
          $return = $return->whereDate('users.status', '=', $status);
          }
        $return = $return->orderBy('users.id','desc')->paginate(10);

        return $return;
    }

    public function getProfile()
    {
        if (!empty($this->profile_pic) && file_exists('upload/profile/' . $this->profile_pic)) {
            return url('upload/profile/' . $this->profile_pic);
        } else {
            return "";
        }
    }

    static public function getParent()
    {
        $return = self::select('users.*')->where('users.user_type', '=',4)->where('users.is_delete', '=', 0);
        if(!empty(Request::get('name')))
        {
         $return = $return->where('users.name', 'like', '%' .Request::get('name').'%');
        }
        
        if(!empty(Request::get('lastname')))
        {
        $return = $return->where('users.lastname', 'like', '%' .Request::get('lastname').'%');
        }
        if(!empty(Request::get('email')))
        {
          $return = $return->where('users.email', 'like', '%' .Request::get('email').'%');
        }       
         if(!empty(Request::get('status')))
         {
          $status = (Request::get('status') == 0) ? 0 : 1;
          $return = $return->whereDate('users.status', '=', $status);
          }
        $return = $return->orderBy('users.id','desc')->paginate(10);

        return $return;
    }

    static public function getSearchStudent(){
        if(!empty(Request::get('id')) || !empty(Request::get('name')) || !empty(Request::get('lastname')) || !empty(Request::get('email'))){
            $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
            ->join('users as parent', 'parent.id', '=','users.parent_id', 'left')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=',3)
            ->where('users.is_delete', '=', 0);

            if(!empty(Request::get('id')))
            {
             $return = $return->where('users.id', 'like', '%' .Request::get('id').'%');
            }
            
            if(!empty(Request::get('lastname')))
            {
            $return = $return->where('users.lastname', 'like', '%' .Request::get('lastname').'%');
            }
            if(!empty(Request::get('email')))
            {
              $return = $return->where('users.email', 'like', '%' .Request::get('email').'%');
            }       
            if(!empty(Request::get('name')))
            {
             $return = $return->where('users.name', 'like', '%' .Request::get('name').'%');
             }
            $return = $return->orderBy('users.id','desc')->limit(10)->paginate();
    
            return $return;
        }
    }
    
    // static public function getMyStudent($parent_id){
    //     $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
    //         ->join('users as parent', 'parent.id', '=','users.parent_id', 'left')
    //         ->join('class', 'class.id', '=', 'users.class_id', 'left')
    //         ->where('users.user_type', '=',3)
    //         ->where('users.parent_id', '=',$parent_id)
    //         ->where('users.is_delete', '=', 0)
    //         ->orderBy('users.id','desc')
    //         ->limit(10)->paginate();
    
    //         return $return;
    // }

    static public function getTeacher(){
        $return = self::select('users.*', 'class.name as class_name')->join('class', 'class.id', '=', 'users.class_id', 'left')->where('users.user_type', '=',2)->where('users.is_delete', '=', 0);
        if(!empty(Request::get('name')))
        {
         $return = $return->where('users.name', 'like', '%' .Request::get('name').'%');
        }
        
        if(!empty(Request::get('lastname')))
        {
        $return = $return->where('users.lastname', 'like', '%' .Request::get('lastname').'%');
        }
        if(!empty(Request::get('email')))
        {
          $return = $return->where('users.email', 'like', '%' .Request::get('email').'%');
        }       
        if(!empty(Request::get('class')))
        {
         $return = $return->where('class.name', 'like', '%' .Request::get('class').'%');
         }
         if(!empty(Request::get('status')))
         {
          $status = (Request::get('status') == 0) ? 0 : 1;
          $return = $return->whereDate('users.status', '=', $status);
          }
        $return = $return->orderBy('users.id','desc')->paginate(10);

        return $return;
    }
}
