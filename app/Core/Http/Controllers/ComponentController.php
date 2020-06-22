<?php
namespace App\Core\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Core\Presenters\BaseViewPresenter;
use App\Core\Exceptions\MediaException;
use Media;
use DB;

class ComponentController extends BaseController
{

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

	public function getImageUrl(){
		$this->request->validate([
			'id' => 'required',
			'thumb' => 'required'
		]);

		$img_instance = Media::getById($this->request->id);
		if($img_instance){
			$img_url = $img_instance->url($this->request->thumb);
			return '<img src="'.$img_url.'" class="media-image">';
		}
	}


	public function removeMedia($id){
		Media::removeById($id);
		return response()->json([
			'type' => 'success',
			'message' => 'Image has been removed'
		]);
	}


	public function switcherMaster(){
		$this->request->validate([
			'id' => 'required',
			'pk' => 'required',
			'table' => 'required',
			'field' => 'required'
		]);

		try{
			$tb = DB::table($this->request->table)->where($this->request->pk, $this->request->id)->update([
				$this->request->field => intval($this->request->value) 
			]);
			return response()->json([
				'type' => 'success'
			]);
		}catch(\Exception $e){
			return abort(403);
		}

	}

}