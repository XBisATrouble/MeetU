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
    $api->group(['namespace'=>'App\Api\Controllers','middleware'=>'throttle:120'], function ($api) {
        $api->post('auth','AuthController@store');                                              //登陆模块
        $api->put('auth','AuthController@update');                                              //更新token
        $api->resource('users','UsersController',array('only'=>array('index','show','store'))); //users相关操作

        $api->get('provinces','SchoolController@getProvinces');                                 //注册时获取地区学校
        $api->get('schools/{province_id}','SchoolController@getSchools');

        $api->get('users/{user_id}/followers','UsersController@followers');                     //获取某个用户的粉丝
        $api->get('users/{user_id}/following','UsersController@following');                     //获取某个用户关注的人

        $api->get('search/users','SearchController@searchUsers');
        $api->get('search/schools','SearchController@searchSchools');
        $api->get('search/activities','SearchController@searchActivities');

        $api->get('activity','ActivityController@index');
        $api->get('activity/{activity}','ActivityController@show');

        $api->get('activity/{activity}/participants','ActivityParticipantsController@index');                             //获取活动有哪些用户参加
        $api->get('activity/user_participated/{id}','ActivityParticipantsController@participated')->where('id','[0-9]+'); //查询某用户参与了那些活动
        $api->get('activity/user_created/{id}','ActivityParticipantsController@created')->where('id','[0-9]+');           //查询某用户创建了那些活动

        $api->get('search/tags','ActivityController@tags');                                                               //标签搜索


        //需要token的私有接口
        $api->group(['middleware'=>'jwt.api.auth'],function ($api){
            $api->delete('auth','AuthController@destroy');                                      //退出操作

            $api->get('user','UserController@index');                                           //授权用户获取自己信息
            $api->get('user/{id}','UserController@show')->where('id','[0-9]+');                 //授权用户查看别人信息
            $api->put('user','UserController@update');                                          //授权用户更新自己信息
            $api->post('user/changePwd','UserController@changePwd');                            //授权用户更新自己密码

            $api->get('user/followers','UserController@followers');                             //获取授权用户关注的人
            $api->get('user/following','UserController@following');                             //获取授权用户关注的人
            $api->post('user/following/{user_id}','UserController@follow');                     //授权用户关注他人
            $api->delete('user/following/{user_id}','UserController@unfollow');                 //授权用户取关他人

            $api->delete('activity/{id}/participants','ActivityParticipantsController@destroy');        //退出某个活动
            $api->post('activity/{activity}/participants','ActivityParticipantsController@store');      //参加某个活动

            $api->get('activity/create','ActivityController@create');                                   //创建活动时需要的信息
            $api->get('activity/{activity}/edit','ActivityController@edit');                            //编辑前获取所有的信息
            $api->resource('activity','ActivityController',array('only' => array('store','update','destroy')));
        });
    });
});