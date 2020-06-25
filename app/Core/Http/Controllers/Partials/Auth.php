<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Process\LoginProcess;

trait Auth
{
	public function login(){
		$p = (new BaseViewPresenter)
			->setTitle('Login')
			->setView('core::pages.login');
		return $p->render();
	}

	public function storeLogin(){
		return (new LoginProcess)->handle();
	}

	public function logout(){
		admin_guard()->logout();
		return redirect(admin_url('/'));
	}


}