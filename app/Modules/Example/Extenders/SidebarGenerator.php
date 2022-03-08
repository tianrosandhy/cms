<?php
namespace App\Modules\Example\Extenders;

use App\Core\Components\Sidebar\SidebarRegistration;
use SidebarItem;

class SidebarGenerator extends SidebarRegistration
{
    public function handle()
    {
        // generate sidebar for core menus
        $this->registerSidebars([
            SidebarItem::setName('ADMIN.Example')
                ->setLabel(__('example::module.example.menu'))
                ->setRoute('admin.example.index')
                ->setIcon('uim:paperclip')
                ->setSortNo(5)
                ->setActiveKey('example'),
        ]);
    }
}