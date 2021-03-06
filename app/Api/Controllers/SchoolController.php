<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 16:49
 */

namespace App\Api\Controllers;


use App\Model\Province;
use App\Model\School;

class SchoolController extends BaseController
{
    public function getProvinces()
    {
        $provinces=Province::all();
        if (!empty($provinces))
        {
            return $this->response->array([
                'status_code'=>'2000',
                'info'=>'success',
                'data'=>$provinces->toArray(),
            ]);
        }
        else
        {
            return $this->errorNotFound_Me('操作失败');
        }
    }

    public function getSchools($province_id)
    {
        $province = Province::find($province_id);

        if (!empty($province))
        {
            $schools=$province->schools;
            return $this->response->array([
                'status_code'=>'2000',
                'info'=>'success',
                'data'=>$schools,
            ]);
        }
        else
        {
            return $this->errorNotFound_Me('未找到相关信息');
        }
    }
}