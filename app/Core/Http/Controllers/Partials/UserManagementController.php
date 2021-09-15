<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\UserPresenter;
use App\Core\Presenters\UserCrudPresenter;
use App\Core\Http\Skeleton\UserSkeleton;
use App\Core\Models\User;
use App\Core\Http\Process\UserCrudProcess;
use App\Core\Base\Process\BaseDeleteProcess;
use App\Core\Base\Process\BaseDatatableProcess;

trait UserManagementController
{
	public function userManagement(){
		return (new UserPresenter)->render();
	}

	public function userManagementDataTable(){
		return (new BaseDatatableProcess)
			->setSkeleton(new UserSkeleton)
			->type('datatable')
			->handle();
	}

	public function userManagementCreate(){
		$user = new User;
		return (new UserCrudPresenter($user))->render();
	}

	public function userManagementStore(){
		return (new UserCrudProcess())
			->setSuccessRedirectTarget(route('admin.user.index'))
			->setSuccessMessage('User data has been saved')
			->type('http')
			->handle();
	}

	public function userManagementEdit($id){
		$user = User::findOrFail($id);
		return (new UserCrudPresenter($user))->render();
	}

	public function userManagementUpdate($id){
		$data = User::findOrFail($id);
		return (new UserCrudProcess($data))
			->setSuccessRedirectTarget(route('admin.user.index'))
			->setSuccessMessage('User data has been updated')
			->type('http')
			->handle();
	}

	public function userManagementDelete($id){
		return (new BaseDeleteProcess)
			->setModel(new User)
			->setId($id)
			->type('ajax')
			->handle();
	}

}