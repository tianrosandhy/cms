<?php
namespace App\Modules\Notification\Extenders;

use App\Core\Components\Setting\SettingRegistration;
use App\Core\Components\Setting\SettingItem;

class SettingGenerator extends SettingRegistration
{
	public function handle(){
		// $this->addSettingGroup('general', [
		// 	new SettingItem('per_page', 'Data Per Page', 'number'),
		// ], 1);
	}

}