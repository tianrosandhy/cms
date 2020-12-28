<?php
namespace App\Modules\Example\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Example\Http\Skeleton\ExampleSkeleton;
use Permission;

class ExampleIndexPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = __('example::module.index');
		$this->view = 'core::master.index';
		#if you want to override this index view, you can use below view instead
		//$this->view = 'example::index';

		$this->batch_delete_url = route('admin.example.delete');
		$this->skeleton = new ExampleSkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);
		$this->control_buttons = [];
		if(!config('module-setting.example.hide_back_to_homepage_button')){
			$this->control_buttons[] = [
				'url' => admin_url('/'),
				'label' => __('core::module.global.back_to_homepage'),
				'icon' => 'home'
			];
		}
		if(!config('module-setting.example.hide_add_button')){
			if(Permission::has('admin.example.create')){
				$this->control_buttons[] = [
					'url' => route('admin.example.create'),
					'label' => __('core::module.form.add_data'),
					'type' => 'success',
					'icon' => 'plus'
				];
			}
		}
		if(!config('module-setting.example.hide_filter')){
			$this->control_buttons[] = [
				'label' => 'Filter',
				'icon' => 'filter',
				'type' => 'primary',
				'attr' => [
					'data-toggle' => 'collapse',
					'data-target' => '#searchBox-' . $this->skeleton->name()
				]
			];
		}
	}

	public function setSelectedMenuName(){
		return 'example';
	}
}