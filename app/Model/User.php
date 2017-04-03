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
        'name', 'email', 'password','phone','school_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','updated_at','created_at',
    ];
    public function getGenderAttribute($value)
    {
        $gender = ['1'=>'男','0'=>'女'];
        return $gender[$value];
    }
}