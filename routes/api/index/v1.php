<?php

Route::group(['prefix' => 'register'], function () {
    Route::post('/', 'RegisterController@create');
});
