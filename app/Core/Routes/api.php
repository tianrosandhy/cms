<?php
Route::post('media-upload', 'ComponentController@mediaUpload')->name('admin.media');
Route::post('file-manager', 'ComponentController@filemanager')->name('admin.filemanager');
Route::post('remove-media/{id}', 'ComponentController@removeMedia')->name('admin.media.remove');
Route::match(['get', 'post'], 'media/get-image-url', 'ComponentController@getImageUrl')->name('admin.media.get-image-url');