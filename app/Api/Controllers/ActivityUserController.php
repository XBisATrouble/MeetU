<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/12
 * Time: 21:42
 */

namespace App\Api\Controllers;

use App\Model\Activity;

class ActivityUserController extends BaseController
{
    public function index($id)
    {
        $users=Activity::find($id)->users()->get();
        $total=$users->count();
        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'total'=>$total,
            'users'=>$users,
        ]);
    }
}