<?php
namespace App\Modules\Page\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Page\Models\Page;

class PageController extends BaseController
{
	public function index(){
		return (new \App\Modules\Page\Presenters\PageIndexPresenter)->render();		
	}

	public function datatable(){
		return (new \App\Modules\Page\Http\Process\PageDatatableProcess)
			->type('datatable')
			->handle();
	}

	public function create(){
		return (new \App\Modules\Page\Presenters\PageCrudPresenter())->render();
	}

	public function store(){
		return (new \App\Modules\Page\Http\Process\PageCrudProcess)
			->type('http')
			->handle();
	}

	public function edit($id){
		$data = Page::findOrFail($id);
		return (new \App\Modules\Page\Presenters\PageCrudPresenter($data))->render();
	}

	public function update($id){
		$data = Page::findOrFail($id);
		return (new \App\Modules\Page\Http\Process\PageCrudProcess($data))
			->type('http')
			->handle();
	}
	
}