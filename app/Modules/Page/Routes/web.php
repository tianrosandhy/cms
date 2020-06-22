<?php
Route::group([
	'prefix' => 'page'
], function(){
	Route::get('/', 'PageController@index')->name('admin.page.index');
	Route::get('create', 'PageController@create')->name('admin.page.create');
	Route::get('edit/{id}', 'PageController@edit')->name('admin.page.edit');
	Route::post('create', 'PageController@store')->name('admin.page.store');
	Route::post('edit/{id}', 'PageController@update')->name('admin.page.update');
	Route::post('switch/{id}', 'PageController@switch')->name('admin.page.switch');
	Route::post('delete/{id?}', 'PageController@delete')->name('admin.page.delete');

	// ajax route
	Route::match(['get', 'post'], 'datatable/page', 'PageController@dataTable')->name('admin.page.datatable');
});