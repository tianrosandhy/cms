<?php
namespace App\Core\Components;

use App\Core\Exceptions\InputException;

use Str;

class Input
{
	public 
		$baseView = 'core::components.input.',
		$multiLanguage = false;

	public function __construct(){
		// all input component will be aliased like below
		$this->mapInput = [
			'Text' => \App\Core\ViewComponents\Input\Text::class,
			'Number' => \App\Core\ViewComponents\Input\Number::class,
			'Email' => \App\Core\ViewComponents\Input\Email::class,
			'Tags' => \App\Core\ViewComponents\Input\Tags::class,
			'Tel' => \App\Core\ViewComponents\Input\Tel::class,
			'Date' => \App\Core\ViewComponents\Input\Date::class,
			'DateRange' => \App\Core\ViewComponents\Input\DateRange::class,
			'DateTime' => \App\Core\ViewComponents\Input\DateTime::class,
			'Color' => \App\Core\ViewComponents\Input\Color::class,
			'Checkbox' => \App\Core\ViewComponents\Input\Checkbox::class,
			'Radio' => \App\Core\ViewComponents\Input\Radio::class,
			'Currency' => \App\Core\ViewComponents\Input\Currency::class,
			'File' => \App\Core\ViewComponents\Input\File::class,
			'FileMultiple' => \App\Core\ViewComponents\Input\FileMultiple::class,
			'Image' => \App\Core\ViewComponents\Input\Image::class,
			'ImageMultiple' => \App\Core\ViewComponents\Input\ImageMultiple::class,
			'ImageSimple' => \App\Core\ViewComponents\Input\ImageSimple::class,
			'Map' => \App\Core\ViewComponents\Input\Map::class,
			'Password' => \App\Core\ViewComponents\Input\Password::class,
			'Richtext' => \App\Core\ViewComponents\Input\Richtext::class,
			'Select' => \App\Core\ViewComponents\Input\Select::class,
			'SelectMultiple' => \App\Core\ViewComponents\Input\SelectMultiple::class,
			'Slug' => \App\Core\ViewComponents\Input\Slug::class,
			'Textarea' => \App\Core\ViewComponents\Input\Textarea::class,
			'Time' => \App\Core\ViewComponents\Input\Time::class,
			'Yesno' => \App\Core\ViewComponents\Input\Yesno::class,
		];
	}


	// all input type will call this 
	protected function generateInputArgs($name, $config=[]){
		if(isset($config['type'])){
			unset($config['type']); //type parameter will not be needed again now
		}
		return array_merge([
			'name' => $name,
			'multiLanguage' => $this->multiLanguage
		], $config);
	}

	public function type($type, $name, $config=[]){
		$studlycase = Str::studly($type);
		if(isset($this->mapInput[$studlycase])){
			$args = $this->generateInputArgs($name, $config);
			return (new $this->mapInput[$studlycase](...$args))->htmlRender();
		}

		$camelize = Str::camel($type);
		if(method_exists($this, $camelize)){
			return $this->{$camelize}($name, $config);
		}
		else{
			throw new InputException('Input type ' . $type .' is still not defined');
		}
	}

	public function multiLanguage(){
		$this->multiLanguage = true;
		return $this;
	}

	protected function mandatoryConfig($config=[], $mandatory=[], $input_type='text'){
		if(!empty($mandatory)){
			foreach($mandatory as $config_key){
				if(!isset($config[$config_key])){
					throw new InputException('Config "'.$config_key.'" is mandatory for input type "'.$input_type.'"');
				}
			}
		}
	}

	public function loadView($view_name, $input_name, $config=[], $fallback=true){
		if(view()->exists($this->baseView.$view_name)){
			if(!isset($config['name'])){
				$config['name'] = $input_name;
			}
			if($this->multiLanguage){
				$config['multiLanguage'] = true;
			}
			return view($this->baseView.$view_name, $config)->render();
		}

		$msg = 'Input '.$view_name.' view is still not defined';
		if($fallback){
			return '<div class="alert alert-danger">'.$msg.'</div>';
		}
		throw new InputException($msg);
	}


	public function text($name, $config=[]){
		return $this->type('Text', $name, $config);
	}
	public function number($name, $config=[]){
		return $this->type('Number', $name, $config);
	}
	public function currency($name, $config=[]){
		return $this->type('Currency', $name, $config);
	}
	public function email($name, $config=[]){
		return $this->type('Email', $name, $config);
	}
	public function password($name, $config=[]){
		return $this->type('Password', $name, $config);
	}
	public function color($name, $config=[]){
		return $this->type('Color', $name, $config);
	}
	public function richtext($name, $config=[]){
		return $this->type('RichText', $name, $config);
	}
	public function textarea($name, $config=[]){
		return $this->type('Textarea', $name, $config);
	}
	public function tel($name, $config=[]){
		return $this->type('Tel', $name, $config);
	}
	public function tags($name, $config=[]){
		return $this->type('Tags', $name, $config);
	}
	public function image($name, $config=[]){
		return $this->type('Image', $name, $config);
	}
	public function imageMultiple($name, $config=[]){
		return $this->type('ImageMultiple', $name, $config);
	}
	public function imageSimple($name, $config=[]){
		return $this->type('ImageSimple', $name, $config);
	}
	public function slug($name, $config=[]){
		return $this->type('Slug', $name, $config);
	}
	public function date($name, $config=[]){
		return $this->type('Date', $name, $config);
	}
	public function time($name, $config=[]){
		return $this->type('Time', $name, $config);
	}
	public function dateTime($name, $config=[]){
		return $this->type('DateTime', $name, $config);
	}
	public function dateRange($name, $config=[]){
		return $this->type('DateRange', $name, $config);
	}
	public function file($name, $config=[]){
		return $this->type('File', $name, $config);
	}
	public function fileMultiple($name, $config=[]){
		return $this->type('FileMultiple', $name, $config);
	}
	public function select($name, $config=[]){
		return $this->type('Select', $name, $config);
	}
	public function selectMultiple($name, $config=[]){
		return $this->type('SelectMultiple', $name, $config);
	}
	public function radio($name, $config=[]){
		return $this->type('Radio', $name, $config);
	}
	public function checkbox($name, $config=[]){
		return $this->type('Checkbox', $name, $config);
	}
	public function yesno($name, $config=[]){
		return $this->type('Yesno', $name, $config);
	}
	public function map($name, $config=[]){
		return $this->type('Map', $name, $config);
	}

	// will generate a custom view input type
	public function view($name, $config=[]){
		$this->mandatoryConfig($config, ['view_source', 'data'], 'view');
		return $this->loadView('view', $name, $config);
	}


}