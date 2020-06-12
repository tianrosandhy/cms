<?php
namespace App\Core\Components;

use App\Core\Models\Media as Model;

class Media
{
	use Media\Uploader;
	use Media\MediaRequestProcessor;

	public function __construct(){
		$this->request = request();
	}

	public function getById($id){
		return Model::find($id);
	}

	public function getByJson($json){
		$decode = json_decode($json, true);
		if($decode){
			return Model::find($decode['id']);
		}
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
		return view('core::components.media.multiple', [
			'name' => $name,
			'config' => $config
		]);
	}

}