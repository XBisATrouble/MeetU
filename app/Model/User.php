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
        'phone','avatar','password','nickname','gender','description','name','idcard','school_id','school_name','student_id','QQ','WeChat','WeiBo','BaiduPostBar','FaceBook','Instagram','Twitter','verify_photo','verify_photo_2'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','updated_at','created_at','idcard','pivot','school_id','student_id',
    ];

    protected $casts = [
        'age' => 'integer',
        'character_value'=>'integer',
    ];

    public function getGenderAttribute($value)
    {
        $gender = ['1'=>'男','0'=>'女',''=>null];
        return $gender[$value];
    }

    public function belongsToSchool()
    {
        return $this->belongsTo('App\Model\School', 'school_id');
    }

    public function activity()
    {
        return $this->belongsToMany('App\Model\Activity');
    }

    public function create_activity()
    {
        return $this->hasMany('App\Model\Activity','creator');
    }
}