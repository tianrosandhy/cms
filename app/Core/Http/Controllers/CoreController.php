<?php
namespace App\Core\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Process\LoginProcess;
use App\Core\Http\Process\ProfileProcess;
use App\Core\Http\Process\SettingProcess;

class CoreController extends BaseController
{

	public function index(){
		$p = (new BaseViewPresenter)
			->setTitle('Dashboard')
			->setView('core::dashboard');
		return $p->render();
	}

	public function login(){
		$p = (new BaseViewPresenter)
			->setTitle('Login')
			->setView('core::pages.login');
		return $p->render();
	}

	public function storeLogin(){
		$process = new LoginProcess;
		return $process->handle();
	}

	public function logout(){
		admin_guard()->logout();
		return redirect(admin_url('/'));
	}

	public function myProfile(){
		$p = (new BaseViewPresenter)
			->setTitle('My Profile')
			->setView('core::pages.my-profile');
		return $p->render();
	}

	public function storeMyProfile(){
		$process = new ProfileProcess;
		return $process->handle();
	}

	public function storeSetting(){
		$process = new SettingProcess;
		return $process->handle();
	}

	public function register(){
	}
}