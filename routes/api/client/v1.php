<?php

Route::group(['prefix' => 'me'], function () {
    Route::get('/', 'MeController@profile');
});
