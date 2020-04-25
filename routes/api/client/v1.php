<?php

Route::group(['prefix' => 'me'], function () {
    Route::get('/', 'MeController@profile');
    Route::post('/logout' ,'MeController@logout');
});

Route::group(['prefix' => 'child', 'namespace' => 'Child'], function () {
    Route::post('/', 'IndexController@create');
});
