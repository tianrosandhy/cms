<?php
namespace App\Modules\Navigation\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Navigation\Http\Skeleton\NavigationSkeleton;

class NavigationCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if(isset($instance->id)){
			$this->title = __('navigation::module.edit');
		}
		else{
			$this->title = __('navigation::module.add');
		}
		$this->data = $instance;
		$this->back_url = route('admin.navigation.index');
		$this->view = 'core::master.crud';
		#if you want to override this crud view, you can use below view instead
		// $this->view = 'navigation::crud';

		$this->skeleton = new NavigationSkeleton;
		$this->config = config('module-setting.navigation');
	}

	public function setSelectedMenuName(){
		return 'navigation';
	}
}