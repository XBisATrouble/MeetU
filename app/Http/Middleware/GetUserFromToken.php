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
                    'status_code'=>'4004',
                    'info' => '未找到相关用户',
                    'data'=>'',
                ], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json([
                'status_code'=>'4011',
                'info' => 'token已过期',
                'data'=>'',
            ], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json([
                'status_code'=>'4012',
                'info' => 'token无效',
                'data'=>'',
            ], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json([
                'status_code'=>'4013',
                'info' => '缺少token',
                'data'=>'',
            ], $e->getStatusCode());

        }
        return $next($request);
    }
}
