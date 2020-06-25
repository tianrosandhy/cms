<?php
namespace App\Core\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Process\SettingProcess;

class CoreController extends BaseController
{
	use Partials\Auth;
	use Partials\Profile;
	use Partials\Language;
	use Partials\Privilege;
	use Partials\UserManagement;

	public function index(){
		$p = (new BaseViewPresenter)
			->setTitle('Dashboard')
			->setView('core::dashboard');
		return $p->render();
	}

	public function storeSetting(){
		return (new SettingProcess)->handle();
	}



}