<?php
namespace App\Modules\Navigation\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Modules\Navigation\Models\Navigation;
use NavigationInstance;

class NavigationManagePresenter extends BaseViewPresenter
{
	public function __construct(Navigation $data){
		$this->title = 'Manage Navigation';
		$this->data = $data;
		$this->id = $data->id;
		$this->structure = NavigationInstance::setData($data)->generateStructure();
		$this->view = 'navigation::manage';

	}

	public function setSelectedMenuName(){
		return 'navigation';
	}

}