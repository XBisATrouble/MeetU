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
}
