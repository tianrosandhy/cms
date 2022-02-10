<?php
namespace App\Modules\Example\Presenters;

use App\Core\Base\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Example\Http\Structure\ExampleStructure;
use Permission;

class ExampleIndexPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = __('example::module.index');
		$this->view = 'core::master.index';
		#if you want to override this index view, you can use below view instead
		//$this->view = 'example::index';

		$this->batch_delete_url = route('admin.example.delete');
		$this->structure = new ExampleStructure;
		$this->datatable = DataTable::setStructure($this->structure);
		$this->control_buttons = [];
		if(Permission::has('admin.example.create')){
			$this->control_buttons[] = [
				'url' => route('admin.example.create'),
				'label' => __('core::module.form.add_data'),
				'type' => 'success',
				'icon' => 'plus',
				'attr' => [
					'data-popup-lg' => '1'
				]
			];
		}
	}

	public function setSelectedMenuName(){
		return 'example';
	}
}