<?php
namespace App\Core\Components\Setting;

use App\Core\Components\Setting\SettingItem;
use Str;

// class instance utk group setting item
class SettingGroup
{
	private $title;
	private $order = 1000;
	private $items;

	public function __construct($title=null, $item=null){
		$this->setTitle($title);
		if(is_array($item)){
			$this->addItems($item);
		}
		else if($item instanceof SettingItem){
			$this->addItem($item);
		}
	}

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
				return $this;
			}
		}
	}

	public function setTitle($title=null){
		$this->title = strtolower($title);
		return $this;
	}

	public function setOrder($order=1){
		$this->order = $order;
		return $this;
	}

	public function addItem(SettingItem $instance){
		$this->items[] = $instance;
		return $this;
	}

	public function addItems($arr=[]){
		foreach($arr as $item){
			$this->addItem($item);
		}
		return $this;
	}
}