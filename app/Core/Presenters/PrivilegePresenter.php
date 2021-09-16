<?php
namespace App\Core\Presenters;

use App\Core\Base\Presenters\BaseViewPresenter;
use App\Core\Components\RoleStructure;
use Permission;

class PrivilegePresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = __('core::module.menu.privilege_management');
		$this->role_structure = new RoleStructure();
		$this->view = 'core::pages.privilege.index';
		$this->permission = Permission::lists();
		$this->control_buttons = [
			[
				'url' => '#',
				'label' => 'Create New Privilege',
				'type' => 'light',
				'icon' => "user",
				'attr' => [
					'data-action' => 'add',
					'data-target' => route('admin.privilege.create')
				]
			]
		];
	}

	public function setSelectedMenuName(){
		return 'privilege';
	}

}