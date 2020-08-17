<?php

Route::group(['prefix' => 'me'], function () {
    Route::get('/', 'MeController@profile');
    Route::put('/', 'MeController@update');
    Route::post('/logout' ,'MeController@logout');
});

Route::group(['prefix' => 'child', 'namespace' => 'Child'], function () {
    Route::post('/', 'IndexController@create');
});

Route::group(['prefix' => 'parent', 'namespace' => 'Parent'], function () {
    Route::post('/', 'IndexController@create');

    Route::group(['prefix' => 'child'], function () {
        Route::get('/', 'ChildController@index');
        Route::get('/{id}', 'ChildController@get');
        Route::post('/{id}/connect', 'ChildController@connect');
    });
});

Route::group(['prefix' => 'children'], function () {
    Route::get('/', 'ChildController@index');
    Route::get('/{id}', 'ChildController@get');
});

Route::group(['prefix' => 'fcm'], function() {
    Route::post('/token/register', 'FCMController@register');
    Route::post('/token/unregister', 'FCMController@unregister');
});

Route::group(['prefix' => 'chats'], function () {
    Route::get('/messages', 'ChatController@messages');
    Route::post('/message/send', 'ChatController@sendMessage');
});
