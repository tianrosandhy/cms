<?php
namespace App\Modules\Post\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Post\Http\Skeleton\PostSkeleton;
use Permission;

class PostIndexPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = __('post::module.post.index');
		$this->view = 'core::master.index';
		#if you want to override this index view, you can use below view instead
		//$this->view = 'post::index';

		$this->batch_delete_url = route('admin.post.delete');
		$this->custom_css = admin_asset('css/custom-post.css');
		$this->skeleton = new PostSkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);
		$this->control_buttons = [];
		if(!config('module-setting.post.hide_back_to_homepage_button')){
			$this->control_buttons[] = [
				'url' => admin_url('/'),
				'label' => 'Back to Homepage',
				'icon' => 'home'
			];
		}
		if(!config('module-setting.post.hide_add_button')){
			if(Permission::has('admin.post.create')){
				$this->control_buttons[] = [
					'url' => route('admin.post.create'),
					'label' => 'Add Data',
					'type' => 'success',
					'icon' => 'plus'
				];
			}
		}
		if(!config('module-setting.post.hide_filter')){
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
		return 'post';
	}
}