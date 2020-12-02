<?php
namespace App\Modules\Notification\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Notification\Http\Skeleton\NotificationSkeleton;
use Permission;

class NotificationIndexPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = __('notification::module.index');
		$this->view = 'core::master.index';
		#if you want to override this index view, you can use below view instead
		//$this->view = 'notification::index';

		$this->batch_delete_url = route('admin.notification.delete');
		$this->skeleton = new NotificationSkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);
		$this->control_buttons = [];
		if(!config('module-setting.notification.hide_back_to_homepage_button')){
			$this->control_buttons[] = [
				'url' => admin_url('/'),
				'label' => __('core::module.global.back_to_homepage'),
				'icon' => 'home'
			];
		}
		if(!config('module-setting.notification.hide_add_button')){
			if(Permission::has('admin.notification.create')){
				$this->control_buttons[] = [
					'url' => route('admin.notification.create'),
					'label' => __('core::module.form.add_data'),
					'type' => 'success',
					'icon' => 'plus'
				];
			}
		}
		if(!config('module-setting.notification.hide_filter')){
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
		return 'notification';
	}
}