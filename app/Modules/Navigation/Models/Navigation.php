<?php
namespace App\Modules\Navigation\Models;

use App\Core\Models\BaseModel;

class Navigation extends BaseModel
{
	public function lists(){
		return $this->hasMany('App\Modules\Navigation\Models\NavigationItem', 'group_id');
	}
}
