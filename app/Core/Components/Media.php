<?php
namespace App\Core\Components;

class Media
{
	use Media\Uploader;
	use Media\MediaRequestProcessor;

	public function __construct(){
		$this->request = request();
	}

	public function assets(){
		return view('core::components.media.assets');
	}

	public function single($name, $value=null, $config=[]){
		return view('core::components.media.single', [
			'name' => $name,
			'config' => $config
		]);
	}

	public function multiple($name, $value=null, $config=[]){
		return view('core::components.media.assets', [
			'name' => $name,
			'config' => $config
		]);
	}

}