<?php
namespace App\Modules\Page\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Page\Http\Skeleton\PageSkeleton;

class PageIndexPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Pages Data';
		$this->view = 'page::index';
		$this->batch_delete_url = route('admin.page.delete');
		$this->skeleton = new PageSkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);
	}

	public function setSelectedMenuName(){
		return 'page';
	}
}