<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return 'Welcome to my api';
    //return view('welcome');
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['namespace'=>'App\Api\Controllers'], function ($api) {
        //注册登陆模块
        $api->post('user/login','AuthController@authenticate');
        $api->post('user/register','AuthController@register');


        //注册时获取地区学校
        $api->get('getProvinces','SchoolController@getProvinces');
        $api->get('getSchools/{province_id}','SchoolController@getSchools');

        //需要token的私有接口
        $api->group(['middleware'=>'jwt.api.auth'],function ($api){
            //获取用户信息
            $api->post('user/info','UserController@info');
            //修改密码
            $api->post('user/changePwd','UserController@changePwd');
        });
        //刷新token
        $api->post('user/upToken','AuthController@upToken');
    });
});