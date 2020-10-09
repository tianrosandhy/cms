<?php
namespace App\Modules\Navigation\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Navigation\Models\Navigation;
use App\Modules\Navigation\Presenters\NavigationIndexPresenter;
use App\Modules\Navigation\Presenters\NavigationCrudPresenter;
use App\Modules\Navigation\Http\Process\NavigationDatatableProcess;
use App\Modules\Navigation\Http\Process\NavigationCrudProcess;
use App\Modules\Navigation\Http\Process\NavigationDeleteProcess;

class NavigationController extends BaseController
{
	public function index(){
		return (new NavigationIndexPresenter)->render();
	}

	public function datatable(){
		return (new NavigationDatatableProcess)
			->type('datatable')
			->handle();
	}

	public function create(){
		$data = new Navigation;
		return (new NavigationCrudPresenter($data))->render();
	}

	public function store(){
		return (new NavigationCrudProcess)
			->type('http')
			->handle();
	}

	public function edit($id){
		$data = Navigation::findOrFail($id);
		return (new NavigationCrudPresenter($data))->render();
	}

	public function update($id){
		$data = Navigation::findOrFail($id);
		return (new NavigationCrudProcess($data))
			->type('http')
			->handle();
	}
	
	public function delete($id=null){
		return (new NavigationDeleteProcess)
			->setModel(new Navigation)
			->setId($id)
			->type('ajax')
			->handle();
	}

}