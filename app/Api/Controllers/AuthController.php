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
    public function store(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('phone', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->return_response('4001','账号或者密码错误!');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->return_response('5000','服务器出错!');
        }
        // all good so return the token
        return $this->return_response('2000','登录成功',$token);
    }

    /*
     * 更新用户token
     */
    public function update()
    {
        try {
            $old_token = JWTAuth::getToken();
            $token = JWTAuth::refresh($old_token);
            //JWTAuth::invalidate($old_token);
        } catch (TokenExpiredException $e) {
            return $this->return_response('4011','token已过期');
        } catch (JWTException $e) {
            return $this->return_response('4012','token无效');
        }
        return $this->return_response('2000','更新成功',$token);
    }

    public function destroy()
    {
        try {
            $old_token = JWTAuth::getToken();
            JWTAuth::invalidate($old_token);
        } catch (TokenExpiredException $e) {
            return $this->return_response('4011','token已过期');
        } catch (JWTException $e) {
            return $this->return_response('4012','token无效');
        }
        return $this->return_response('2000','退出成功',$_GET['token']);
    }
}