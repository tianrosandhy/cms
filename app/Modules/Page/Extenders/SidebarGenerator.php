<?php
namespace App\Modules\page\Extenders;

use App\Core\Components\Sidebar\SidebarRegistration;
use SidebarItem;

class SidebarGenerator extends SidebarRegistration
{
	public function handle(){
		// generate sidebar for core menus
		$this->registerSidebars([
			SidebarItem::setName('ADMIN.PAGE')
				->setLabel('Page')
				->setRoute('admin.page.index')
				->setIcon('paperclip')
				->setSortNo(5)
				->setActiveKey('page'),
		]);
	}

}