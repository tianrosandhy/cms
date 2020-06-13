<?php
namespace App\Core\Extenders;

use App\Core\Components\Sidebar\SidebarRegistration;
use SidebarItem;

class SidebarGenerator extends SidebarRegistration
{
	public function handle(){
		// generate sidebar for core menus
		$this->registerSidebars([
			SidebarItem::setName('admin.dashboard')
				->setLabel('Dashboard')
				->setUrl(admin_url('/'))
				->setIcon('home')
				->setSortNo(0)
				->setActiveKey('homepage'),

			SidebarItem::setName('admin.user')
				->setLabel('User Managements')
				->setPrivilege(['admin.user.index', 'admin.privilege.index'])
				->setIcon('users')
				->setSortNo(100)
				->setActiveKey(['user', 'privilege']),

				SidebarItem::setName('admin.user.privilege')
					->setLabel('Privilege Management')
					->setPrivilege('admin.privilege.index')
					->setUrl('#')
					->setParent('admin.user')
					->setSortNo(1)
					->setActiveKey('privilege'),

				SidebarItem::setName('admin.user.index')
					->setLabel('User Lists')
					->setPrivilege('admin.user.index')
					->setUrl('#')
					->setParent('admin.user')
					->setSortNo(1)
					->setActiveKey('user'),
		]);
	}

}