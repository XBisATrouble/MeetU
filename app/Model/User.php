<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="users";

    protected $fillable = [
        'phone','password','nickname','gender','description','name','idcard','school_id','student_id','QQ','WeChat','WeiBo','BaiduPostBar','FaceBook','Instagram','Twitter','verify_photo','verify_photo_2'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','updated_at','created_at','school_id','idcard'
    ];
    public function getGenderAttribute($value)
    {
        $gender = ['1'=>'男','0'=>'女',''=>null];
        return $gender[$value];
    }
}