<?php
namespace App\Core\Presenters;

use App\Core\Exceptions\ViewPresenterException;
use Setting;
use Sidebar;
use App\Core\Shared\DynamicProperty;

class BaseViewPresenter
{
	use DynamicProperty;
	
	public 
		$view,
		$user,
		$selected_menu;

	public function setDefaultProperty(){
		$request = request();
		$this->user = $request->get('user');
		$this->role = $request->get('role');
		$this->is_sa = $request->get('is_sa');
		$this->base_permission = $request->get('base_permission');

		$this->setting = Setting::data();
		$this->sidebar = Sidebar::generate();

		if(method_exists($this, 'setSelectedMenuName')){
			$this->selected_menu = $this->setSelectedMenuName();
		}
		else{
			$this->selected_menu = Sidebar::fallbackSelectedMenu();
		}

		if(!property_exists($this, 'breadcrumb')){
			$this->breadcrumb = [];
		}
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