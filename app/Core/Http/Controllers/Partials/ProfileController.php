<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Process\ProfileProcess;

trait ProfileController
{
	public function myProfile(){
		return (new BaseViewPresenter)
			->setTitle('My Profile')
			->setView('core::pages.my-profile')
			->render();
	}

	public function storeMyProfile(){
		return (new ProfileProcess)
			->setSuccessMessage('Your profile has been updated successfully')
			->handle();
	}	
}