<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class GetUserFromToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * 解决jwt返回码自定义
     */
    public function handle($request, Closure $next)
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'success' => 'false',
                    'status_code'=>'404',
                    'msg' => '未找到相关用户'
                ], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json([
                'success' => 'false',
                'status_code'=>'401',
                'msg' => 'token已过期'
            ], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json([
                'success' => 'false',
                'status_code'=>'403',
                'msg' => 'token无效'
            ], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json([
                'success' => 'false',
                'status_code'=>'402',
                'msg' => '缺少token'
            ], $e->getStatusCode());

        }
        return $next($request);
    }
}
