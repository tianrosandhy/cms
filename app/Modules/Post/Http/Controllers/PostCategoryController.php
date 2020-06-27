<?php
namespace App\Modules\Post\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Post\Models\PostCategory;
use App\Modules\Post\Presenters\PostCategoryIndexPresenter;
use App\Modules\Post\Presenters\PostCategoryCrudPresenter;
use App\Modules\Post\Http\Process\PostCategoryDatatableProcess;
use App\Modules\Post\Http\Process\PostCategoryCrudProcess;
use App\Modules\Post\Http\Process\PostCategoryDeleteProcess;

class PostCategoryController extends BaseController
{
	public function index(){
		return (new PostCategoryIndexPresenter)->render();
	}

	public function datatable(){
		return (new PostCategoryDatatableProcess)
			->type('datatable')
			->handle();
	}

	public function create(){
		$data = new PostCategory;
		return (new PostCategoryCrudPresenter($data))->render();
	}

	public function store(){
		return (new PostCategoryCrudProcess)
			->type('http')
			->handle();
	}

	public function edit($id){
		$data = PostCategory::findOrFail($id);
		return (new PostCategoryCrudPresenter($data))->render();
	}

	public function update($id){
		$data = PostCategory::findOrFail($id);
		return (new PostCategoryCrudProcess($data))
			->type('http')
			->handle();
	}
	
	public function delete($id=null){
		return (new PostCategoryDeleteProcess)
			->setModel(new PageCategory)
			->setId($id)
			->type('ajax')
			->handle();
	}

}