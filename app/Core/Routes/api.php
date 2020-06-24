<?php
Route::post('media-upload', 'ComponentController@mediaUpload')->name('admin.media');
Route::post('file-manager', 'ComponentController@filemanager')->name('admin.filemanager');
Route::post('remove-media/{id}', 'ComponentController@removeMedia')->name('admin.media.remove');
Route::match(['get', 'post'], 'media/get-image-url', 'ComponentController@getImageUrl')->name('admin.media.get-image-url');
Route::post('switcher-master', 'ComponentController@switcherMaster')->name('admin.switcher');
Route::post('post-document', 'ComponentController@postDocument')->name('admin.post-document');
Route::post('delete-document', 'ComponentController@deleteDocument')->name('admin.delete-document');