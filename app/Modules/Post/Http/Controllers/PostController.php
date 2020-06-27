<?php
namespace App\Modules\Post\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Post\Models\Post;
use App\Modules\Post\Presenters\PostIndexPresenter;
use App\Modules\Post\Presenters\PostCrudPresenter;
use App\Modules\Post\Http\Process\PostDatatableProcess;
use App\Modules\Post\Http\Process\PostCrudProcess;
use App\Modules\Post\Http\Process\PostDeleteProcess;

class PostController extends BaseController
{
	public function index(){
		return (new PostIndexPresenter)->render();
	}

	public function datatable(){
		return (new PostDatatableProcess)
			->type('datatable')
			->handle();
	}

	public function create(){
		$data = new Post;
		return (new PostCrudPresenter($data))->render();
	}

	public function store(){
		return (new PostCrudProcess)
			->type('http')
			->handle();
	}

	public function edit($id){
		$data = Post::findOrFail($id);
		return (new PostCrudPresenter($data))->render();
	}

	public function update($id){
		$data = Post::findOrFail($id);
		return (new PostCrudProcess($data))
			->type('http')
			->handle();
	}
	
	public function delete($id=null){
		return (new PostDeleteProcess)
			->setModel(new Page)
			->setId($id)
			->type('ajax')
			->handle();
	}

}