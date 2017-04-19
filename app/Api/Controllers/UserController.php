<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 19:21
 */

namespace App\Api\Controllers;
use App\Model\School;
use App\Model\User;
use JWTAuth;

class UserController extends BaseController
{
    public function info()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return $this->response->array([
                'status_code'=>'4004',
                'info'=>'未找到相关信息',
                'data'=>'',
            ]);
        }
        $user = collect($user)->map(function ($item) {
            if ($item==null) {
                $item = "";
            }
            return $item;
        });
        $user_array=$user->toArray(); //将结果集转化为数组
        $school=new School();
        $user_array=$school->getName($user_array,$user['school_id']);
        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'data'=>$user_array,
        ]);
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