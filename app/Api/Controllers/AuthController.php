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
                        'success'=>'false',
                        'status_code'=>'400',
                        'msg' => '用户名或密码错误']
                );
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                    'success'=>'false',
                    'status_code'=>'500',
                    'msg' => '创建token失败']
            );
        }

        // all good so return the token
        return response()->json([
            'success'=>'true',
            'status_code'=>'200',
            'token'=>$token,
        ]);
    }

    /*
     * 更新用户token
     */
    public function upToken()
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);

        return $this->response->array([
            'success'=>'true',
            'status_code'=>'200',
            'token'=>$newToken,
        ]);
    }

    public function register()
    {
        //验证规则
        $rules = [
            'phone' => ['required', 'min:11', 'max:11', 'unique:users'],
            'password' => ['required', 'min:6'],
            'nickname' => ['required','unique:users'],
            'gender'=>['required','boolean'],
            'name' => ['unique:users'],
            'idcard'=>['unique:users','min:18','max:18'],
        ];
        $payload = app('request')->only('phone','password','nickname','gender','description','name','idcard','school_id','student_id','QQ','WeChat','WeiBo','BaiduPostBar','FaceBook','Instagram','Twitter');
        // 验证格式
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            return $this->response->array([
                'success'=>'false',
                'status_code'=>'400',
                'msg' => $validator->errors()
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
            'BaiduPostBar'=>$payload['BaiduPostBar'],
            'FaceBook'=>$payload['FaceBook'],
            'Instagram'=>$payload['Instagram'],
            'Twitter'=>$payload['Twitter'],
        ];


        $res = User::create($newUser);

        // 创建用户成功
        if ($res) {
            return $this->response->array([
                'success'=>'true',
                'status_code'=>'200',
                'msg' => '创建用户成功',
            ]);
        } else {
            return $this->response->array([
                'success'=>'false',
                'status_code'=>'500',
                'msg' => '创建用户失败',
            ]);
        }
    }
}