<?php
namespace App\Core\Extenders;

use App\Core\Components\Sidebar\SidebarRegistration;
use SidebarItem;

class SidebarGenerator extends SidebarRegistration
{
	public function handle(){
		// generate sidebar for core menus
		$this->registerSidebars([
			SidebarItem::setName('ADMIN.DASHBOARD')
				->setLabel('Dashboard')
				->setUrl(admin_url('/'))
				->setIcon('home')
				->setSortNo(0)
				->setActiveKey('homepage'),

			SidebarItem::setName('ADMIN.MANAGEMENT')
				->setLabel('Managements')
				->setPrivilege(['admin.user.index', 'admin.privilege.index', 'admin.language.index'])
				->setIcon('settings')
				->setSortNo(100)
				->setActiveKey(['user', 'privilege']),

				SidebarItem::setName('ADMIN.LANGUAGE')
					->setLabel('Language Setting')
					->setPrivilege('admin.language.index')
					->setRoute('admin.language.index')
					->setParent('ADMIN.MANAGEMENT')
					->setActiveKey('language'),

				SidebarItem::setName('ADMIN.PRIVILEGE')
					->setLabel('Privilege Management')
					->setPrivilege('admin.privilege.index')
					->setRoute('admin.privilege.index')
					->setParent('ADMIN.MANAGEMENT')
					->setSortNo(1)
					->setActiveKey('privilege'),

				SidebarItem::setName('ADMIN.USER')
					->setLabel('User Lists')
					->setPrivilege('admin.user.index')
					->setRoute('admin.user.index')
					->setParent('ADMIN.MANAGEMENT')
					->setSortNo(1)
					->setActiveKey('user'),

				SidebarItem::setName('ADMIN.LOG')
					->setLabel('Log Management')
					->setPrivilege('admin.log.index')
					->setRoute('admin.log.index')
					->setParent('ADMIN.MANAGEMENT')
					->setActiveKey('log')
		]);
	}

}