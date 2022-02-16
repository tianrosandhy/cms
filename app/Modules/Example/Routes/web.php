<?php
Route::group([
	'prefix' => 'example',
  'controller' => ExampleController::class,
], function(){
	Route::get('/', 'index')->name('admin.example.index');
	Route::get('/create', 'create')->name('admin.example.create');
	Route::get('/edit/{id}', 'edit')->name('admin.example.edit');
	Route::post('/create', 'store')->name('admin.example.store');
	Route::post('/edit/{id}', 'update')->name('admin.example.update');
	Route::post('/delete/{id?}', 'delete')->name('admin.example.delete');

	// ajax route
	Route::match(['get', 'post'], '/datatable/post', 'dataTable')->name('admin.example.datatable');
	Route::post('/switch/{id}', 'switch')->name('admin.example.switch');

	// import/export route
	Route::get('/export', 'export')->name('admin.example.export');
	Route::post('/import', 'import')->name('admin.example.import');
});
