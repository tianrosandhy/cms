<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Core\Http\Skeleton\LanguageSkeleton;

class LanguagePresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Language Setting';
		$this->view = 'core::components.language';
		$this->skeleton = new LanguageSkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);
	}

	public function setSelectedMenuName(){
		return 'language';
	}
}