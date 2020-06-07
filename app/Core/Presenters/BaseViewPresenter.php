<?php
namespace App\Core\Presenters;

use App\Core\Exceptions\ViewPresenterException;
use Str;

class BaseViewPresenter
{
	public 
		$view,
		$user;

	// dynamic property set
	public function __call($name, $arguments){
		$method = substr($name, 0, 3);
		if(in_array($method, ['get', 'set'])){
			$prop = substr($name, 3);
			$prop = Str::snake($prop);

			if($method == 'get' && property_exists($this->prop)){
				return $this->{$prop};
			}
			if($method == 'set' && isset($arguments[0])){
				$this->{$prop} = $arguments[0];
				return $this;
			}
		}
	}

	public function setDefaultProperty(){
		$request = request();
		$this->user = $request->get('user');
		$this->role = $request->get('role');
		$this->is_sa = $request->get('is_sa');
		$this->base_permission = $request->get('base_permission');
	}

	public function render(){
		if(!$this->view){
			throw new PresenterException('You need to set the view target with "->setView(...)" before render the presenter');
		}

		$this->setDefaultProperty();
		
		$data = get_object_vars($this);
		return view($this->view, $data);
	}

}