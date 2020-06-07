<?php
namespace App\Core\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Core\Presenters\DashboardPresenter;
use App\Core\Presenters\LoginPresenter;
use App\Core\Presenters\RegisterPresenter;
use App\Core\Http\Process\LoginProcess;

class CoreController extends BaseController
{
	public function index(){
		$p = new DashboardPresenter;
		return $p->render();
	}

	public function login(){
		$p = new LoginPresenter;
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

	public function register(){
		$p = new RegisterPresenter;
		return $p->render();
	}
}