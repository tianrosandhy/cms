<?php
namespace App\Core\Components\Setting;

use App\Core\Exceptions\SettingException;
use Str;

// class instance utk single setting item
class SettingItem
{
	private 
		$name, 
		$title,
		$type,
		$config = [],
		$value;

	public function __construct($name, $title, $type='text', $config=[], $default_value = null){
		$this->name = $name;
		$this->title = $title;
		$this->setType($type, $config);
		$this->value = $default_value;
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

	public function setType($type='text', $config=[]){
		$available_type = ['text', 'textarea', 'number', 'email', 'tel', 'select_static', 'select_data', 'color', 'yesno', 'image', 'file'];
		$type = strtolower($type);
		if(!in_array($type, $available_type)){
			throw new SettingException('Undefined "'.$type.'" setting item type.');
		}

		$this->type = $type;
		$this->setConfig($config);
		return $this;
	}

	public function setConfig($config=[]){
		$this->config = array_merge($this->config, $config);
		if($this->type == 'select_static' && !isset($this->config['source'])){
			throw new SettingException('You need to define the setting "source" config for input type select_static');
		}
		if($this->type == 'select_data' && !isset($this->config['data_source'])){
			throw new SettingException('You need to define the setting "data_source" config for input type select_data');
		}

		return $this;
	}


}