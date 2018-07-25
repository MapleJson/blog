<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| 小程序路由
|--------------------------------------------------------------------------
*/
Route::get('/app-loadBlog', "Applets\AppletsController@loadBlog");
Route::get('/app-travels', "Applets\AppletsController@travels");
Route::get('/app-loadPhoto', "Applets\AppletsController@loadPhoto");
Route::get('/app-whisper', "Applets\AppletsController@whisper");
Route::get('/app-about', "Applets\AppletsController@about");
