<?php
namespace App\Core\Components\Media;

use App\Core\Models\Media as Model;

trait MediaRequestProcessor
{
	public function getByRequest(){
		//page, sort_dir, keyword
		$data = new Model;
		$page = $this->request->page ?? 1;
		$per_page = 20;
		$sort_dir = $this->request->sort_dir ?? 'desc';
		$sort_dir = strtolower($sort_dir);
		if(!in_array($sort_dir, ['asc', 'desc'])){
			$sort_dir = 'desc';
		}
		
		if($this->request->keyword){
			$data = $data->where('filename', 'like', '%'.$this->request->keyword.'%');
		}

		return $data->orderBy('id', $sort_dir)->paginate($per_page, ['*'], 'page', $page);

	}
}