<?php
namespace App\Modules\Navigation\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Navigation\Http\Skeleton\NavigationSkeleton;
use Permission;

class NavigationIndexPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = __('navigation::module.index');
		$this->view = 'core::master.index';
		#if you want to override this index view, you can use below view instead
		//$this->view = 'navigation::index';

		$this->batch_delete_url = route('admin.navigation.delete');
		$this->skeleton = new NavigationSkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);
		$this->control_buttons = [];
		if(!config('module-setting.navigation.hide_back_to_homepage_button')){
			$this->control_buttons[] = [
				'url' => admin_url('/'),
				'label' => 'Back to Homepage',
				'icon' => 'home'
			];
		}
		if(!config('module-setting.navigation.hide_add_button')){
			if(Permission::has('admin.navigation.create')){
				$this->control_buttons[] = [
					'url' => route('admin.navigation.create'),
					'label' => 'Add Data',
					'type' => 'success',
					'icon' => 'plus'
				];
			}
		}
		if(!config('module-setting.navigation.hide_filter')){
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
		return 'navigation';
	}
}