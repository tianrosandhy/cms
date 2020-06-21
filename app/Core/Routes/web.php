<?php
Route::get('/', 'CoreController@index')->name('admin.splash');
Route::get('my-profile', 'CoreController@myProfile')->name('admin.my-profile');
Route::post('my-profile', 'CoreController@storeMyProfile')->name('admin.my-profile.store');
Route::post('store-setting', 'CoreController@storeSetting')->name('admin.setting.store');

Route::get('language', 'CoreController@language')->name('admin.language');
Route::match(['get', 'post'], 'datatable/language', 'CoreController@languageDataTable')->name('admin.language.datatable');


Route::match(['get', 'post'], 'logout', 'CoreController@logout')->name('admin.logout');



// guest only route
Route::group([
	'middleware' => 'backend_guest'
], function(){
	Route::get('login', 'CoreController@login')->name('admin.login');
	Route::post('login', 'CoreController@storeLogin')->name('admin.login.process');
	Route::get('register', 'CoreController@register')->name('admin.register');
});
