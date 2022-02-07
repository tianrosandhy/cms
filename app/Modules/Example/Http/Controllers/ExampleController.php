<?php
namespace App\Modules\Example\Http\Controllers;

use App\Core\Base\Controllers\BaseController;
use App\Modules\Example\Models\Example;
use App\Modules\Example\Presenters\ExampleIndexPresenter;
use App\Modules\Example\Presenters\ExampleCrudPresenter;
use App\Modules\Example\Presenters\ExamplePreimportPresenter;
use App\Modules\Example\Http\Process\ExampleDatatableProcess;
use App\Modules\Example\Http\Process\ExampleCrudProcess;
use App\Modules\Example\Http\Process\ExampleDeleteProcess;
use App\Modules\Example\Http\Process\ExampleExportProcess;
use App\Modules\Example\Http\Process\ExamplePreimportProcess;
use App\Modules\Example\Http\Process\ExampleImportProcess;

class ExampleController extends BaseController
{
	public function index(){
		return (new ExampleIndexPresenter)->render();
	}

	public function export(){
		return (new ExampleExportProcess)
			->type('http')
			->handle();
	}

	public function import(){
		if($this->request->import_id){
			// real import : handled via process
			return (new ExampleImportProcess($this->request->import_id))
				->setType('http')
				->setSuccessRedirectTarget(route('admin.example.index'))
				->setErrorRedirectTarget(route('admin.example.index'))
				->handle();
		}
		else if($this->request->pre_import_id){
			// preimport : handled via preview
			$preimport = (new ExamplePreimportProcess)
				->setType('raw')
				->handle();

			return (new ExamplePreimportPresenter($preimport))
				->render();			
		}
		else{
			abort(400);
		}
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
			->type($this->request->ajax() ? 'ajax' : 'http')
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
			->type($this->request->ajax() ? 'ajax' : 'http')
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