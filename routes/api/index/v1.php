<?php

Route::group(['prefix' => 'register'], function () {
    Route::post('/', 'RegisterController@create');
});

Route::group(['prefix' => 'notify'], function () {
    Route::post('/', 'NotificationController@send');
});
