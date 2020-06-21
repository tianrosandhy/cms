<?php
namespace App\Modules\Page\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Page\Http\Skeleton\PageSkeleton;

class PageCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if($instance){
			$this->title = 'Edit Pages Data';
		}
		else{
			$this->title = 'Create New Pages';
		}
		$this->data = $instance;
		$this->view = 'page::crud';
		$this->skeleton = new PageSkeleton;
	}

	public function setSelectedMenuName(){
		return 'page';
	}
}