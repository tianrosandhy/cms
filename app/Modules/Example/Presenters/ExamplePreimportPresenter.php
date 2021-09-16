<?php
namespace App\Modules\Example\Presenters;

use App\Core\Base\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Example\Http\Structure\ExampleStructure;

class ExamplePreimportPresenter extends BaseViewPresenter
{
	public function __construct($data=[]){
        $this->data = $data;
        $this->title = __('example::module.preimport');
		$this->back_url = route('admin.example.index');
		$this->view = 'core::master.preimport';
	}

	public function setSelectedMenuName(){
		return 'example';
	}
}