<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 19:21
 */

namespace App\Api\Controllers;
use App\Model\User;
use App\Model\UserMin;
use JWTAuth;

class UserController extends BaseController
{
    public function serach()
    {
        $q= isset($_GET['q'])?trim($_GET['q']):null;
        $start= isset($_GET['start'])?trim($_GET['start']):0;
        $count= isset($_GET['count'])?trim($_GET['count']):20;
        if($q==null)
        {
            return $this->return_response_user('4003','请求参数出错');
        }
        $users=UserMin::nickname($q,$start,$count);
        return $this->return_response_user('2000','success',$users);
    }

    public function index()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return $this->return_response_user('4004','未找到相关信息');
        }
        $user = collect($user)->map(function ($item) {
            if ($item==null) {
                $item = "";
            }
            return $item;
        });
        $user_array=$user->toArray(); //将结果集转化为数组
        return $this->return_response_user('2000','success',$user_array);
    }

    public function update()
    {
        $user=$this->getUser();
        //验证规则
        $rules = [
            'nickname' => ['required'],
            'gender'=>['boolean'],
        ];

        $error_message=[
            'nickname.required'=>'昵称不能为空!',
        ];

        $payload = app('request')->only('nickname','gender','description','school_id','student_id','QQ','WeChat','WeiBo','FaceBook','Instagram','Twitter','photo','photo2');

        // 验证格式
        $validator = app('validator')->make($payload, $rules,$error_message);
        $validator_array=$validator->errors()->toArray();

        if ($validator->fails()) {
            return $this->return_response_user('4003','请求参数出错');
        }

        $newUser=[
            'nickname'=>$payload['nickname'],
            'gender'=>$payload['gender'],
            'description'=>$payload['description'],
            'school_id'=>$payload['school_id'],
            'student_id'=>$payload['student_id'],
            'QQ'=>$payload['QQ'],
            'WeChat'=>$payload['WeChat'],
            'WeiBo'=>$payload['WeiBo'],
            'FaceBook'=>$payload['FaceBook'],
            'Instagram'=>$payload['Instagram'],
            'Twitter'=>$payload['Twitter'],
            'verify_photo'=>$payload['photo'],
            'verify_photo_2'=>$payload['photo2'],
        ];

        $user->update($newUser);

        if ($user->save()) {
            return $this->return_response_user('2001','更新成功',$user);
        } else {
            return $this->return_response_user('5000','服务器出错!');
        }
    }

    public function changePwd()
    {
        //验证规则
        $rules = [
            'newPassword' => ['required', 'min:6'],
        ];
        $payload = app('request')->only('newPassword');
        // 验证格式
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            return $this->response->array([
                'status_code'=>'4003',
                'info' => $validator->errors()
            ]);
        }

        $newPwd=$payload['newPassword'];
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        $User=User::where('id',$user_id)->first();
        $User->password=bcrypt($newPwd);
        if($User->save())
            return $this->response->array([
                'status_code'=>'2002',
                'info'=>'修改成功',
            ]);
        else{
            return $this->response->array([
                'status_code'=>'5000',
                'info' => '服务器出错',
            ]);
        }
    }
}