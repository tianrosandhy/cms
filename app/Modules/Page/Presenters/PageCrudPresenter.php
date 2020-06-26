<?php
namespace App\Modules\Page\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Page\Http\Skeleton\PageSkeleton;

class PageCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if(isset($instance->id)){
			$this->title = __('page::module.edit');
		}
		else{
			$this->title = __('page::module.add');
		}
		$this->data = $instance;
		$this->back_url = route('admin.page.index');
		$this->view = 'core::master.crud';
		#if you want to override this crud view, you can use below view instead
		// $this->view = 'page::crud';
		$this->skeleton = new PageSkeleton;
		$this->config = config('module-setting.page');
	}

	public function setSelectedMenuName(){
		return 'page';
	}
}