<?php
namespace App\Core\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Core\Presenters\BaseViewPresenter;
use App\Core\Exceptions\MediaException;
use Media;

class ComponentController extends BaseController
{
	// tests methods
	public function testFilemanager(){
		return view('core::components.media.test');
	}

	public function testFileManagerPost(){
		dd($this->request->all());
	}




	public function mediaUpload(){
		try{
			$uploader = Media::upload($this->request->file);
		}catch(MediaException $e){
			return response()->json([
				'type' => 'error',
				'message' => $e->getMessage()
			], 403);
		}

		return response()->json([
			'type' => 'success',
			'message' => $uploader->id
		]);
	}

	public function filemanager(){
		$data = Media::getByRequest();
		if($data->count() == 0){
			if($this->request->keyword){
				return view('core::components.media.partials.blank', ['filtered' => true]);
			}
			return view('core::components.media.partials.blank');
		}

		return view('core::components.media.partials.inner-media', compact(
			'data'
		));
	}

}