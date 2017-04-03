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
    return view('welcome');
});
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['namespace'=>'App\Api\Controllers'], function ($api) {
        $api->post('user/login','AuthController@authenticate');
        $api->post('user/register','AuthController@register');
        $api->get('getProvinces','SchoolController@getProvinces');
        $api->get('getSchool/{province_id}','SchoolController@getSchool');
        $api->group(['middleware'=>'jwt.auth'],function ($api){
            $api->post('user/info','UserController@info');
        });
    });
});