<?php
Route::get('/', 'CoreController@index')->name('admin.splash');
Route::get('login', 'CoreController@login')->name('admin.login');
Route::get('register', 'CoreController@register')->name('admin.register');
