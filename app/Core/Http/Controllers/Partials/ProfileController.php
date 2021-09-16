<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Base\Presenters\BaseViewPresenter;
use App\Core\Http\Process\ProfileProcess;

trait ProfileController
{
	public function myProfile(){
		return (new BaseViewPresenter)
			->setTitle(__('core::module.global.my_profile'))
			->setView('core::pages.my-profile.index')
			->render();
	}

	public function storeMyProfile(){
		return (new ProfileProcess)
			->setSuccessMessage('Your profile has been updated successfully')
			->handle();
	}	
}