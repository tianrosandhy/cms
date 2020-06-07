<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;

class LoginPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Log In';
		$this->view = 'core::pages.login';
	}
}