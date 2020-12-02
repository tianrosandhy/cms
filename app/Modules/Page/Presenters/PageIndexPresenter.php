<?php
namespace App\Modules\Page\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Page\Http\Skeleton\PageSkeleton;
use Permission;

class PageIndexPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = __('page::module.index');
		$this->view = 'core::master.index';
		#if you want to override this index view, you can use below view instead
		// $this->view = 'page::index';

		$this->batch_delete_url = route('admin.page.delete');
		$this->skeleton = new PageSkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);
		$this->control_buttons = [];
		if(!config('module-setting.page.hide_back_to_homepage_button')){
			$this->control_buttons[] = [
				'url' => admin_url('/'),
				'label' => __('core::module.global.back_to_homepage'),
				'icon' => 'home'
			];
		}
		if(!config('module-setting.page.hide_add_button')){
			if(Permission::has('admin.page.create')){
				$this->control_buttons[] = [
					'url' => route('admin.page.create'),
					'label' => __('core::module.form.add_data'),
					'type' => 'success',
					'icon' => 'plus'
				];
			}
		}
		if(!config('module-setting.page.hide_filter')){
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
		return 'page';
	}
}