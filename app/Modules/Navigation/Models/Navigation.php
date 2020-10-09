<?php
namespace App\Modules\Navigation\Models;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
	public function lists(){
		return $this->hasMany('App\Modules\Navigation\Models\NavigationItem', 'group_id');
	}
}
