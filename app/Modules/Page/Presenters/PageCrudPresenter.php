<?php
namespace App\Modules\Page\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Page\Http\Skeleton\PageSkeleton;

class PageCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if($instance){
			$this->title = __('page::module.edit');
		}
		else{
			$this->title = __('page::module.add');
		}
		$this->data = $instance;
		$this->view = 'page::crud';
		$this->skeleton = new PageSkeleton;
		$this->config = config('module-setting.page');
	}

	public function setSelectedMenuName(){
		return 'page';
	}
}