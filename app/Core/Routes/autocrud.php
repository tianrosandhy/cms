<?php
//will be used in every Auto CRUD routes
Route::group([
	'prefix' => $bs_url,
	'controller' => $bs_controller
], function() use($bs_route){
	Route::get('/', 'index')->name('admin.'.$bs_route.'.index');
	Route::get('create', 'create')->name('admin.'.$bs_route.'.create');
	Route::get('edit/{id}', 'edit')->name('admin.'.$bs_route.'.edit');
	Route::post('create', 'store')->name('admin.'.$bs_route.'.store');
	Route::post('edit/{id}', 'update')->name('admin.'.$bs_route.'.update');
	Route::post('switch/{id}', 'switch')->name('admin.'.$bs_route.'.switch');
	Route::post('delete/{id?}', 'delete')->name('admin.'.$bs_route.'.delete');

	// ajax route
	Route::match(['get', 'post'], 'datatable/post', 'dataTable')->name('admin.'.$bs_route.'.datatable');

	// import/export route
	Route::get('export', 'export')->name('admin.'.$bs_route.'.export');
	Route::post('import', 'import')->name('admin.'.$bs_route.'.import');
});
