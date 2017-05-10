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
    protected $hidden = [
        'password', 'remember_token','updated_at','created_at','idcard','pivot','phone','marital_status','verify_photo_2','verify_photo','name','verify','student_id','school_id',
    ];

    protected $casts = [
        'age' => 'integer',
        'character_value'=>'integer',
        'followers_count'=>'integer',
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

    public function scopeSince($query,$since)
    {
        return $query->where('id','>=',$since);
    }

    public function scopeNickname($query,$nickname,$start,$count)
    {
        return $query->where('nickname','like', '%'.$nickname.'%')->offset($start)->limit($count)->get();
    }


    //获取所有我关注的人
    public function followings()
    {
        return $this->belongsToMany(self::Class, 'followers', 'user_id', 'follower_id')->withTimestamps()->select('users.id','nickname','avatar','age','character_value','gender','description','school_name');
    }

    //获取所有关注我的人
    public function followers()
    {
        return $this->belongsToMany(self::Class, 'followers', 'follower_id', 'user_id')->withTimestamps()->select('users.id','nickname','avatar','age','character_value','gender','description','school_name');
    }

    //关注用户
    public function follow($user_id)
    {
        $this->followings()->attach($user_id);
    }

    //取消关注
    public function unfollow($user_id)
    {
        $this->followings()->detach($user_id);
    }

    //我是否关注了某个用户
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }

    public function isFollowed($user_id)
    {
        return $this->followers->contains($user_id);
    }

    public function isFollowEachOther($user_id)
    {
        return $this->isFollowing($user_id) && $this->isFollowed($user_id);
    }
}