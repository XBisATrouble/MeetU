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
        $api->post('auth','AuthController@store');
        //更新token
        $api->put('auth','AuthController@update');
        //users相关操作
        $api->resource('users','UsersController',array('only'=>array('index','show','store')));
        //user相关操作
        $api->get('search/user','UserController@serach');

        //注册时获取地区学校
        $api->get('getProvinces','SchoolController@getProvinces');
        $api->get('getSchools/{province_id}','SchoolController@getSchools');
        $api->get('findSchool/{keywords}', 'SchoolController@findSchool');


        //需要token的私有接口
        $api->group(['middleware'=>'jwt.api.auth'],function ($api){
            //退出操作
            $api->delete('auth','AuthController@destroy');
            //授权用户操作
            $api->get('user','UserController@index');
            $api->put('user','UserController@update');
            $api->post('user/changePwd','UserController@changePwd');

            //参与活动操作
            $api->get('activity/user_participated/{id}','ActivityParticipantsController@participated');
            $api->get('activity/user_created/{id}','ActivityParticipantsController@created');
            $api->delete('activity/{id}/participants','ActivityParticipantsController@destroy');
            $api->resource('activity.participants','ActivityParticipantsController',array('only' => array('index','store')));

            //活动操作
            //创建活动所需的信息
            $api->get('activity/create','ActivityController@create');
            $api->get('activity/{activity}/edit','ActivityController@edit');
            $api->resource('activity','ActivityController');
        });
    });
});