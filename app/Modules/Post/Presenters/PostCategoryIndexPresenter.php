<?php
namespace App\Modules\Post\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Post\Http\Skeleton\PostCategorySkeleton;
use Permission;

class PostCategoryIndexPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = __('post::module.post_category.index');
		$this->view = 'core::master.index';
		#if you want to override this index view, you can use below view instead
		//$this->view = 'post_category::index';

		$this->batch_delete_url = route('admin.post_category.delete');
		$this->skeleton = new PostCategorySkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);
		$this->control_buttons = [];
		if(!config('module-setting.post_category.hide_back_to_homepage_button')){
			$this->control_buttons[] = [
				'url' => admin_url('/'),
				'label' => __('core::module.global.back_to_homepage'),
				'icon' => 'home'
			];
		}
		if(!config('module-setting.post_category.hide_add_button')){
			if(Permission::has('admin.post_category.create')){
				$this->control_buttons[] = [
					'url' => route('admin.post_category.create'),
					'label' => __('core::module.form.add_data'),
					'type' => 'success',
					'icon' => 'plus'
				];
			}
		}
		if(!config('module-setting.post_category.hide_filter')){
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
		return 'post_category';
	}
}