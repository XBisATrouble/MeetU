<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 16:50
 */

namespace App\Api\Controllers;
use App\Model\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class AuthController extends BaseController
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('phone', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                        'status_code'=>'4001',
                        'info'=>'账号或者密码错误!',
                        'token'=>'',
                        ]
                );
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                    'status_code'=>'5000',
                    'info'=>'服务器出错!',
                    'token'=>'',
                    ]
            );
        }
        // all good so return the token
        return response()->json([
            'status_code'=>'2000',
            'info'=>'success',
            'token'=>$token,
        ]);
    }

    /*
     * 更新用户token
     */
    public function upToken()
    {
        try {
            $token = JWTAuth::getToken();
            $newToken = JWTAuth::refresh($token);
            JWTAuth::invalidate($token);
        } catch (TokenExpiredException $e) {
            return $this->response->array([
                'status_code'=>'40011',
                'info'=>'token已过期',
                'token'=>'',
            ]);
        } catch (JWTException $e) {
            return $this->response->array([
                'status_code'=>'4012',
                'info'=>'token无效',
                'token'=>'',
            ]);
        }

        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'token'=>$newToken,
        ]);
    }

    public function register()
    {
        //验证规则
        $rules = [
            'phone' => ['required', 'between:11,11', 'unique:users'],
            'password' => ['required', 'min:6'],
            'nickname' => ['required'],
            'gender'=>['required','boolean'],
            'name' => ['unique:users'],
            'idcard'=>['unique:users','between:18,18'],
        ];

        $error_message=[
            'phone.required'=>'手机号不能为空!',
            'phone.between'=>'手机号必须为11位',
            'phone.unique'=>'该手机已被注册!',
            'password.required'=>'密码不能为空!',
            'password.min'=>'密码必须大于6位!',
            'nickname.required'=>'昵称不能为空!',
            'gender.required'=>'性别不能为空!',
            'name.unique'=>'该姓名已被注册!',
            'idcard.unique'=>'该身份证已被注册!',
            'idcard.between'=>'身份证必须为18位',
        ];

        $payload = app('request')->only('phone','password','nickname','gender','description','name','idcard','school_id','student_id','QQ','WeChat','WeiBo','FaceBook','Instagram','Twitter');
        // 验证格式
        $validator = app('validator')->make($payload, $rules,$error_message);
        if ($validator->fails()) {
            return $this->response->array([
                'status_code'=>'4002',
                'info' => $validator->errors(),
                'token'=>'',
            ]);
        }

        $newUser=[
            'phone' => $payload['phone'],
            'password' => bcrypt($payload['password']),
            'nickname'=>$payload['nickname'],
            'gender'=>$payload['gender'],
            'description'=>$payload['description'],
            'name' => $payload['name'],
            'idcard'=>$payload['idcard'],
            'school_id'=>$payload['school_id'],
            'student_id'=>$payload['student_id'],
            'QQ'=>$payload['QQ'],
            'WeChat'=>$payload['WeChat'],
            'WeiBo'=>$payload['WeiBo'],
            'FaceBook'=>$payload['FaceBook'],
            'Instagram'=>$payload['Instagram'],
            'Twitter'=>$payload['Twitter'],
        ];


        $res = User::create($newUser);
        // 创建用户成功
        if ($res) {
            $credentials = ['phone'=>$payload['phone'],'password'=>$payload['password']];

            $token = JWTAuth::attempt($credentials);

            return $this->response->array([
                'info'=>'success',
                'status_code'=>'2001',
                'token'=>$token,
            ]);
        } else {
            return $this->response->array([
                'info'=>'服务器出错!',
                'status_code'=>'5000',
                'token'=>'',
            ]);
        }
    }
}