<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resources([
        'auth/users' => UserController::class,
        'blog'       => BlogController::class,
        'tags'       => TagController::class,
        'links'      => LinkController::class,
        'about'      => AboutController::class,
        'carousels'  => CarouselController::class,
        'travels'    => TravelController::class,
        'users'      => FrontUserController::class,
        'whispers'   => WhisperController::class,
    ]);

    $router->get('auth/login', 'AuthController@getLogin');
    $router->post('auth/login', 'AuthController@postLogin');
    $router->get('auth/logout', 'AuthController@getLogout');
    $router->get('auth/setting', 'AuthController@getSetting');
    $router->put('auth/setting', 'AuthController@putSetting');


    $router->get('reply/{id}', 'CommentController@replyForm')->name('replyForm');
    $router->post('reply/{id}', 'CommentController@replySave')->name('replySave');
    $router->get('comment/{articleId?}', 'CommentController@index')->name('showComments');
    $router->get('comment/{id}/edit', 'CommentController@edit')->name('editComment');
    $router->match(['PUT', 'PATCH'], 'comment/{id}', 'CommentController@update')->name('updateComment');
    $router->delete('comment/{id}', 'CommentController@destroy')->name('deleteComment');

    $router->get('photos/{travelId}', 'PhotoController@index')->name('showPhotos');
    $router->get('photos/{id}/edit', 'PhotoController@edit')->name('editPhoto');
    $router->post('photos/upload', 'PhotoController@upload')->name('uploadPhotos');
    $router->match(['PUT', 'PATCH'], 'photos/{id}', 'PhotoController@update')->name('updatePhoto');
    $router->delete('photos/{id}', 'PhotoController@destroy')->name('deletePhoto');
});
