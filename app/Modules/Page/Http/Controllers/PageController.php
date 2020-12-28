<?php
namespace App\Modules\Page\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Page\Models\Page;
use App\Modules\Page\Presenters\PageIndexPresenter;
use App\Modules\Page\Presenters\PageCrudPresenter;
use App\Modules\Page\Http\Process\PageDatatableProcess;
use App\Modules\Page\Http\Process\PageCrudProcess;
use App\Modules\Page\Http\Process\PageDeleteProcess;

class PageController extends BaseController
{
	public function index(){
		return (new PageIndexPresenter)->render();		
	}

	public function datatable(){
		return (new PageDatatableProcess)
			->type('datatable')
			->handle();
	}

	public function create(){
		$instance = new Page;
		return (new PageCrudPresenter($instance))->render();
	}

	public function store(){
		return (new PageCrudProcess(new Page))
			->setSuccessRedirectTarget(route('admin.page.index'))
			->type('http')
			->handle();
	}

	public function edit($id){
		$data = Page::findOrFail($id);
		return (new PageCrudPresenter($data))->render();
	}

	public function update($id){
		$data = Page::findOrFail($id);
		return (new PageCrudProcess($data))
			->setSuccessRedirectTarget(route('admin.page.index'))
			->type('http')
			->handle();
	}
	
	public function delete($id=null){
		return (new PageDeleteProcess)
			->setModel(new Page)
			->setId($id)
			->type('ajax')
			->handle();
	}

}