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
				->setLabel(__('core::module.menu.dashboard'))
				->setUrl(admin_url('/'))
				->setIcon('home')
				->setSortNo(0)
				->setActiveKey('homepage'),

			SidebarItem::setName('ADMIN.MANAGEMENT')
				->setLabel(__('core::module.menu.management'))
				->setPrivilege(['admin.user.index', 'admin.privilege.index', 'admin.language.index'])
				->setIcon('settings')
				->setSortNo(100)
				->setActiveKey(['user', 'privilege']),

				SidebarItem::setName('ADMIN.LANGUAGE')
					->setLabel(__('core::module.menu.language_management'))
					->setPrivilege('admin.language.index')
					->setRoute('admin.language.index')
					->setParent('ADMIN.MANAGEMENT')
					->setActiveKey('language'),

				SidebarItem::setName('ADMIN.PRIVILEGE')
					->setLabel(__('core::module.menu.privilege_management'))
					->setPrivilege('admin.privilege.index')
					->setRoute('admin.privilege.index')
					->setParent('ADMIN.MANAGEMENT')
					->setSortNo(1)
					->setActiveKey('privilege'),

				SidebarItem::setName('ADMIN.USER')
					->setLabel(__('core::module.menu.user_list'))
					->setPrivilege('admin.user.index')
					->setRoute('admin.user.index')
					->setParent('ADMIN.MANAGEMENT')
					->setSortNo(1)
					->setActiveKey('user'),

				SidebarItem::setName('ADMIN.LOG')
					->setLabel(__('core::module.menu.log_management'))
					->setPrivilege('admin.log.index')
					->setRoute('admin.log.index')
					->setParent('ADMIN.MANAGEMENT')
					->setActiveKey('log'),
				
		]);

		//only show push notif menu if can
		if(canSendPushNotif()){
			$this->registerSidebars([
				SidebarItem::setName('ADMIN.PUSHTOKEN')
					->setLabel(__('core::module.menu.push_token'))
					->setPrivilege('admin.push-notif.index')
					->setRoute('admin.push-notif.index')
					->setParent('ADMIN.MANAGEMENT')
					->setActiveKey('push-notif'),
			]);
		}
	}

}