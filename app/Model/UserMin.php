<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserMin extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="users";
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $appends = ['school'];

    protected $hidden = [
        'password', 'remember_token','updated_at','created_at','idcard','pivot','QQ','WeChat','phone','WeiBo','FaceBook','marital_status','verify_photo_2','verify_photo','name','verify','Twitter','Instagram','student_id','school_id'
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

    public function school()
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

    public function getSchoolAttribute()
    {
        $school=School::find($this->school_id);
        return $school['school_name'];
    }

    public function scopeSince($query,$since)
    {
        return $query->where('id','>=',$since);
    }

    public function scopeNickname($query,$nickname,$start,$count)
    {
        return $query->where('nickname','like', '%'.$nickname.'%')->offset($start)->limit($count)->get();
    }
}