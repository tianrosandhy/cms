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

Route::group([
	'prefix' => 'post_category'
], function(){
	Route::get('/', 'PostCategoryController@index')->name('admin.post_category.index');
	Route::get('create', 'PostCategoryController@create')->name('admin.post_category.create');
	Route::get('edit/{id}', 'PostCategoryController@edit')->name('admin.post_category.edit');
	Route::post('create', 'PostCategoryController@store')->name('admin.post_category.store');
	Route::post('edit/{id}', 'PostCategoryController@update')->name('admin.post_category.update');
	Route::post('switch/{id}', 'PostCategoryController@switch')->name('admin.post_category.switch');
	Route::post('delete/{id?}', 'PostCategoryController@delete')->name('admin.post_category.delete');

	// ajax route
	Route::match(['get', 'post'], 'datatable/post', 'PostCategoryController@dataTable')->name('admin.post_category.datatable');
});

