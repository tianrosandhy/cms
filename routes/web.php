<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	$installed = true;
	try{
	    $check = \DB::table('cms_installs')->get();
	}catch(\Exception $e){
	    $installed = false;
	}

	if(!$installed){
		if(env('APP_ENV') == 'local'){
			return redirect()->route('cms.install');		
		}
		else{
			return 'Website is still not installed';
		}
	}
    return view('welcome');
});




