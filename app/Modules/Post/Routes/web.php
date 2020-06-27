<?php
Route::group([
	'prefix' => 'post'
], function(){
	Route::get('/', 'PostController@index')->name('admin.post.index');
	Route::get('create', 'PostController@create')->name('admin.post.create');
	Route::get('edit/{id}', 'PostController@edit')->name('admin.post.edit');
	Route::post('create', 'PostController@store')->name('admin.post.store');
	Route::post('edit/{id}', 'PostController@update')->name('admin.post.update');
	Route::post('switch/{id}', 'PostController@switch')->name('admin.post.switch');
	Route::post('delete/{id?}', 'PostController@delete')->name('admin.post.delete');

	// ajax route
	Route::match(['get', 'post'], 'datatable/post', 'PostController@dataTable')->name('admin.post.datatable');
});