<?php

Route::group(['prefix' => 'me'], function () {
    Route::get('/', 'MeController@profile');
    Route::post('/logout' ,'MeController@logout');
});
