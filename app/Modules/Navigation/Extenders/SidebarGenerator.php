<?php
namespace App\Modules\Navigation\Extenders;

use App\Core\Components\Sidebar\SidebarRegistration;
use SidebarItem;

class SidebarGenerator extends SidebarRegistration
{
	public function handle(){
		// generate sidebar for core menus
		$this->registerSidebars([
			SidebarItem::setName('ADMIN.Navigation')
				->setLabel(__('navigation::module.menu.navigation'))
				->setRoute('admin.navigation.index')
				->setIcon('menu')
				->setSortNo(3)
				->setActiveKey('navigation'),
		]);
	}
}