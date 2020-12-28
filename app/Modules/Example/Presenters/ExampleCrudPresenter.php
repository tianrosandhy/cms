<?php
namespace App\Modules\Example\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Example\Http\Skeleton\ExampleSkeleton;

class ExampleCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if(isset($instance->id)){
			$this->title = __('example::module.edit');
		}
		else{
			$this->title = __('example::module.add');
		}
		$this->data = $instance;
		$this->back_url = route('admin.example.index');
		$this->view = 'core::master.crud';
		#if you want to override this crud view, you can use below view instead
		// $this->view = 'example::crud';

		$this->skeleton = new ExampleSkeleton;
		$this->config = config('module-setting.example');
	}

	public function setSelectedMenuName(){
		return 'example';
	}
}