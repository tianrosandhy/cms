<?php
namespace App\Core\Presenters;

use App\Core\Base\Presenters\BaseViewPresenter;
use App\Core\Http\Structure\UserStructure;

class UserCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if(isset($instance->id)){
			$this->title = 'Edit User Data';
		}
		else{
			$this->title = 'Create New User Data';
		}
		$this->data = $instance;
		$this->back_url = route('admin.user.index');
		$this->view = 'core::master.crud';
		$this->structure = new UserStructure;
		$this->config = config('module-setting.user');
	}

	public function setSelectedMenuName(){
		return 'user';
	}
}