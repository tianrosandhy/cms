<?php
Route::post('media-upload', 'ComponentController@mediaUpload')->name('admin.media');
Route::post('file-manager', 'ComponentController@filemanager')->name('admin.filemanager');