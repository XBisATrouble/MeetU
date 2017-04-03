<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $table='provinces';

    protected $primaryKey='province_id';

    public function schools()
    {
        return $this->hasMany('App\Model\School','school_pro_id');
    }
}
