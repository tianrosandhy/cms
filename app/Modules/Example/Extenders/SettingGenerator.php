<?php
namespace App\Modules\Example\Extenders;

use App\Core\Components\Setting\SettingRegistration;
use App\Core\Components\Setting\SettingItem;

class SettingGenerator extends SettingRegistration
{
    public function handle()
    {
        // $this->addSettingGroup('general', [
        //     new SettingItem('per_page', 'Data Per Page', 'number'),
        // ], 1);
    }

}