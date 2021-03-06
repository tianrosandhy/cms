<?php
namespace App\Modules\Example\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Example\Models\Example;
use App\Modules\Example\Presenters\ExampleIndexPresenter;
use App\Modules\Example\Presenters\ExampleCrudPresenter;
use App\Modules\Example\Http\Process\ExampleDatatableProcess;
use App\Modules\Example\Http\Process\ExampleCrudProcess;
use App\Modules\Example\Http\Process\ExampleDeleteProcess;

class ExampleController extends BaseController
{
	public function index(){
		return (new ExampleIndexPresenter)->render();
	}

	public function datatable(){
		return (new ExampleDatatableProcess)
			->type('datatable')
			->handle();
	}

	public function create(){
		$data = new Example;
		return (new ExampleCrudPresenter($data))->render();
	}

	public function store(){
		return (new ExampleCrudProcess(new Example))
			->setSuccessRedirectTarget(route('admin.example.index'))
			->type('http')
			->handle();
	}

	public function edit($id){
		$data = Example::findOrFail($id);
		return (new ExampleCrudPresenter($data))->render();
	}

	public function update($id){
		$data = Example::findOrFail($id);
		return (new ExampleCrudProcess($data))
			->setSuccessRedirectTarget(route('admin.example.index'))
			->type('http')
			->handle();
	}
	
	public function delete($id=null){
		return (new ExampleDeleteProcess)
			->setModel(new Example)
			->setId($id)
			->type('ajax')
			->handle();
	}

}