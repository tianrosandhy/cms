<?php
namespace App\Core\Components\Sidebar;

use App\Core\Exceptions\SidebarException;
use Str;

// class instance utk single sidebar item
class SidebarItem
{
	private 
		$name,
		$url,
		$label,
		$icon,
		$sort_no = 999,
		$privilege = [],
		$parent,
		$children,
		$active_key = [];

	// dynamic property set
	public function __call($name, $arguments){
		$method = substr($name, 0, 3);
		if(in_array($method, ['get', 'set'])){
			$prop = substr($name, 3);
			$prop = Str::snake($prop);

			if($method == 'get' && property_exists($this, $prop)){
				return $this->{$prop};
			}
			if($method == 'set' && isset($arguments[0])){
				$this->{$prop} = $arguments[0];
			}
			if($method == 'has'){
				$cond = isset($this->{$prop});
				if($cond){
					return !empty($cond);
				}
				return false;
			}
		}
		return $this;
	}

	public function __construct($name=null, $config=[]){
		$this->setName($name);
		foreach($config as $key => $value){
			if(property_exists($this, $key)){
				$this->{$key} = $value;
			}
		}
	}

	public function addChildren($keyname, SidebarItem $item){
		$this->children[$keyname] = $item;
		return $this;
	}

	public function setActiveKey($var){
		if(!is_array($var)){
			$var = [$var];
		}
		$this->active_key = $var;
		return $this;
	}




	public function url(){
		if($this->url){
			return url($this->url);
		}
		return '#';
	}
}