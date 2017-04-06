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
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends BaseController
{
    public function info()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }

        $user_array=$user->toArray(); //将结果集转化为数组
        $school=new School();
        $user_array=$school->getName($user_array,$user['school_id']);
        return $this->response->array([
            'success'=>'true',
            'status_code'=>'200',
            'data'=>$user_array
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
                'success'=>'false',
                'status_code'=>'400',
                'msg' => $validator->errors()
            ]);
        }

        $newPwd=$payload['newPassword'];
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        $User=User::where('id',$user_id)->first();
        $User->password=bcrypt($newPwd);
        if($User->save())
            return $this->response->array([
                'success'=>'true',
                'status_code'=>'200',
                'msg'=>'修改成功',
            ]);
        else{
            return $this->response->array([
                'success'=>'false',
                'status_code'=>'400',
                'msg' => '修改失败',
            ]);
        }
    }
}