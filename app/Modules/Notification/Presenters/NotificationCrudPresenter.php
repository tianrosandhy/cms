<?php
namespace App\Modules\Notification\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Notification\Http\Skeleton\NotificationSkeleton;

class NotificationCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if(isset($instance->id)){
			$this->title = __('notification::module.edit');
		}
		else{
			$this->title = __('notification::module.add');
		}
		$this->data = $instance;
		$this->back_url = route('admin.notification.index');
		$this->view = 'core::master.crud';
		#if you want to override this crud view, you can use below view instead
		// $this->view = 'notification::crud';

		$this->skeleton = new NotificationSkeleton;
		$this->config = config('module-setting.notification');
	}

	public function setSelectedMenuName(){
		return 'notification';
	}
}