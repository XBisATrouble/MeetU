<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/26
 * Time: 23:44
 */

namespace App\Api\Controllers;


use App\Model\School;
use App\Model\UserMin;

class SearchController extends BaseController
{
    public function searchUsers()
    {
        $q= isset($_GET['q'])?trim($_GET['q']):null;
        $start= isset($_GET['start'])?trim($_GET['start']):0;
        $count= isset($_GET['count'])?trim($_GET['count']):20;
        if($q==null)
        {
            return $this->return_response_user('4003','请求参数出错');
        }
        $users=UserMin::select('id','nickname','age','character_value','gender','grade','description','school_id')->nickname($q,$start,$count);
        $total=$users->count();
        if ($users->isEmpty()){
            return $this->return_response_user('4004','未找到相关信息');
        }else{
            return $this->return_response_user('2000','success',$users,$total);
        }
    }

    public function searchSchools()
    {
        $q= isset($_GET['q'])?trim($_GET['q']):null;
        $start= isset($_GET['start'])?trim($_GET['start']):0;
        $count= isset($_GET['count'])?trim($_GET['count']):20;
        if($q==null)
        {
            return $this->return_response_user('4003','请求参数出错');
        }
        $school=School::name($q,$start,$count);
        $total=$school->count();
        if ($school->isEmpty()){
            return $this->return_response_user('4004','未找到相关信息');
        }else{
            return $this->return_response_user('2000','success',$school,$total);
        }
    }
}