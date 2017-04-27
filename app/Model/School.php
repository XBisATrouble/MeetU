<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    //
    protected $table='schools';

    protected $primaryKey='school_id';

    protected $hidden = [
        'school_pro_id','school_schooltype_id',
    ];

    public function location()
    {
        return $this->belongsTo('App\Model\Province');
    }

    public function getName($array,$school_id)
    {
        if ($school_id!=""){
            $school_name=$this->find($school_id)->school_name;
            $array['school_name']=$school_name;
        }else{
            $array['school_name']="";
        }
        return $array;
    }

    public function scopeName($query,$keywords,$start,$count)
    {
        return $query->where('school_name','like', '%'.$keywords.'%')->offset($start)->limit($count)->get();
    }
}