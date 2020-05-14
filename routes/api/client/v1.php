<?php

Route::group(['prefix' => 'me'], function () {
    Route::get('/', 'MeController@profile');
    Route::post('/logout' ,'MeController@logout');
});

Route::group(['prefix' => 'child', 'namespace' => 'Child'], function () {
    Route::post('/', 'IndexController@create');
});

Route::group(['prefix' => 'parent', 'namespace' => 'Parent'], function () {
    Route::post('/', 'IndexController@create');

    Route::group(['prefix' => 'child'], function () {
        Route::post('/{id}/connect', 'ChildController@connect');
    });
});

Route::group(['prefix' => 'children'], function () {
    Route::get('/', 'ChildController@index');
    Route::get('/{id}', 'ChildController@get');
});
