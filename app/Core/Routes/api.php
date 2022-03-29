<?php
Route::post('switcher-master', 'ComponentController@switcherMaster')->name('admin.switcher');
Route::get('analytic-dashboard', 'ComponentController@analyticDashboardReport')->name('admin.analytic.dashboard');
Route::match(['get', 'post'], 'switchlang', 'ComponentController@switchLang')->name('admin.lang.switch');