<?php
Route::get('/', 'CoreController@index')->name('admin.splash');
Route::get('login', 'CoreController@login')->name('admin.login');
Route::post('login', 'CoreController@storeLogin')->name('admin.login.process');
Route::get('register', 'CoreController@register')->name('admin.register');
