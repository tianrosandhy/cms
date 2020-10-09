<?php
generateAdminRoute('navigation', 'NavigationController');
Route::get('navigation-refresh/{id}', 'NavigationItemController@refresh');
Route::get('navigation/manage/{id}', 'NavigationItemController@manage')->name('admin.navigation_item.manage');
Route::post('navigation/manage/{id}', 'NavigationItemController@storeManaged')->name('admin.navigation_item.store');
Route::get('navigation-form/{id}', 'NavigationItemController@getEditForm')->name('admin.navigation_item.edit');
Route::post('navigation-item/delete/{id}', 'NavigationItemController@deleteItem')->name('admin.navigation_item.delete');
Route::post('navigation-item/reorder/{id}', 'NavigationItemController@reorder')->name('admin.navigation_item.reorder');