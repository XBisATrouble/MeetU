<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 16:49
 */

namespace App\Api\Controllers;


use App\Model\Province;

class SchoolController extends BaseController
{
    public function getProvinces()
    {
        $provinces=Province::all();
        if (!empty($provinces))
        {
            return $this->response->array([
                'success'=>'true',
                'status_code'=>'200',
                'data'=>$provinces->toArray()
            ]);
        }
        else
        {
            return $this->response->errorNotFound_Me('操作失败');
        }
    }

    public function getSchool($province_id)
    {
        $province = Province::find($province_id);

        if (!empty($province))
        {
            $schools=$province->schools;
            return $this->response->array([
                'success'=>'true',
                'status_code'=>'200',
                'data'=>$schools
            ]);
        }
        else
        {
            return $this->response->errorNotFound_Me('未找到相关信息');
        }
    }
}