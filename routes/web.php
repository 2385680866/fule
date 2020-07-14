<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   return view('welcome');
});
//************************************************************************************************************//
Route::prefix('backstage')->group(function () {
    //首页
    Route::get('/', "Backstage\\IndexController@index");
    //权限管理 power
    Route::prefix('power')->group(function () {
        Route::any('/create', "Backstage\\PowerController@create");//权限添加
        Route::get('/index', "Backstage\\PowerController@index");//权限列表
        Route::any('/edit/{id}', "Backstage\\PowerController@edit");//权限修改
        Route::get('/destroy/{id}', "Backstage\\PowerController@destroy");//权限删除
        Route::get('/powerName', "Backstage\\PowerController@powerName");//权限唯一
    });
});