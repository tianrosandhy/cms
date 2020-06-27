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
				->setLabel('Posts')
				->setIcon('paperclip')
				->setSortNo(5)
				->setActiveKey(['post', 'post_category']),

			SidebarItem::setName('ADMIN.POST.INDEX')
				->setLabel('Post')
				->setRoute('admin.post.index')
				->setSortNo(1)
				->setActiveKey('post')
				->setParent('ADMIN.POST'),
			SidebarItem::setName('ADMIN.POST_CATEGORY.INDEX')
				->setLabel('Post Category')
				->setRoute('admin.post_category.index')
				->setSortNo(1)
				->setActiveKey('post_category')
				->setParent('ADMIN.POST'),

		]);
	}
}