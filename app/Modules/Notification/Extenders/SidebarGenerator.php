<?php
namespace App\Modules\Notification\Extenders;

use App\Core\Components\Sidebar\SidebarRegistration;
use SidebarItem;

class SidebarGenerator extends SidebarRegistration
{
	public function handle(){
		// generate sidebar for core menus
		if(canSendPushNotif()){
			$this->registerSidebars([
				SidebarItem::setName('ADMIN.Notification')
					->setLabel('Blast Notification')
					->setRoute('admin.notification.index')
					->setIcon('bell')
					->setSortNo(80)
					->setActiveKey('notification'),
			]);
		}
	}
}