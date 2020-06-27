<?php
namespace App\Modules\Post\Extenders;

use App\Core\Components\Sidebar\SidebarRegistration;
use SidebarItem;

class SidebarGenerator extends SidebarRegistration
{
	public function handle(){
		// generate sidebar for core menus
		$this->registerSidebars([
			SidebarItem::setName('ADMIN.POST')
				->setLabel('Post')
				->setRoute('admin.post.index')
				->setIcon('paperclip')
				->setSortNo(5)
				->setActiveKey('post'),
		]);
	}
}