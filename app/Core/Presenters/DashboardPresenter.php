<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;

class DashboardPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Dashboard';
		$this->view = 'core::dashboard';
	}
}