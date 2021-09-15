<?php
namespace App\Core\Presenters;

use App\Core\Base\Presenters\BaseViewPresenter;
use App\Core\Http\Structure\UserStructure;
use DataTable;
use Permission;

class UserPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'User Management';
		$this->view = 'core::master.index';
		$this->batch_delete_url = route('admin.user.delete');
		$this->structure = new UserStructure;
		$this->datatable = DataTable::setStructure($this->structure);

		if(Permission::has('admin.user.create')){
			$this->control_buttons[] = [
				'url' => route('admin.user.create'),
				'label' => __('core::module.form.add_data'),
				'type' => 'success',
				'icon' => 'plus'
			];
		}
	}

	public function setSelectedMenuName(){
		return 'user';
	}
}