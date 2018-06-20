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

Route::get('/', "Home\HomeController@index")->name('home');

/*
|--------------------------------------------------------------------------
| 相册
|--------------------------------------------------------------------------
*/
Route::get('/travels', "Travels\TravelController@travels")->name('travels');
Route::get('/travels/photo/{id}', "Travels\TravelController@photo")->where('id', '[0-9]+')->name('photo');
Route::get('/loadPhoto', "Travels\TravelController@loadPhoto")->name('loadPhoto');

/*
|--------------------------------------------------------------------------
| 博客
|--------------------------------------------------------------------------
*/
Route::get('/blog', "Blog\BlogController@blog")->name('blog');
Route::get('/loadBlog', "Blog\BlogController@loadBlog")->name('loadBlog');
Route::get('/blog/tag/{tag}', "Blog\BlogController@blogByTag")->name('tags');
Route::get('/blog/info/{id}', "Blog\BlogController@info")->where('id', '[0-9]+')->name('info');

/*
|--------------------------------------------------------------------------
| 关于我
|--------------------------------------------------------------------------
*/
Route::get('/about', "About\AboutController@about")->name('about');

/*
|--------------------------------------------------------------------------
| 友情链接
|--------------------------------------------------------------------------
*/
Route::get('/links', "Links\LinkController@links")->name('links');
Route::post('/links', "Links\LinkController@applyLink")->name('applyLink');

/*
|--------------------------------------------------------------------------
| 留言
|--------------------------------------------------------------------------
*/
Route::get('/message', "Message\MessageController@message")->name('message');
Route::post('/message', "Message\MessageController@addMessage")->name('addMessage')->middleware('auth');

/*
|--------------------------------------------------------------------------
| 搜索
|--------------------------------------------------------------------------
*/
Route::post('/search', "Search\SearchController@search")->name('search');

/*
|--------------------------------------------------------------------------
| 第三方登录
|--------------------------------------------------------------------------
*/
Route::get('/auth/{service}', 'Auth\SocialiteLoginController@redirectToProvider')->name('socialiteLoginForm');
Route::get('/logout', 'Auth\SocialiteLoginController@logout')->name('logout');
Route::get('/auth/{service}/callback', 'Auth\SocialiteLoginController@handleProviderCallback')->name('socialiteLogin');
