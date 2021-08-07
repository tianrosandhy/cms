<?php
if(config('app.env') == 'local'){
	Route::get('/', 'InstallController@index')->name('cms.install');
	Route::post('/', 'InstallController@process');
}
