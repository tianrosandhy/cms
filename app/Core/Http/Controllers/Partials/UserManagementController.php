<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Base\Process\BaseDatatableProcess;
use App\Core\Base\Process\BaseDeleteProcess;
use App\Core\Http\Process\UserCrudProcess;
use App\Core\Http\Structure\UserStructure;
use App\Core\Models\User;
use App\Core\Presenters\UserCrudPresenter;
use App\Core\Presenters\UserPresenter;

use App\Core\Http\Structure\UserDatatableStructure;

trait UserManagementController
{
    public function userManagement()
    {
        return (new UserPresenter)->render();
    }

    public function userManagementDataTable()
    {
        $struct = new UserDatatableStructure;
        return $struct->datatableResponse();
    }

    public function userManagementCreate()
    {
        $user = new User;
        return (new UserCrudPresenter($user))->render();
    }

    public function userManagementStore()
    {
        return (new UserCrudProcess(new User))
            ->setSuccessRedirectTarget(route('admin.user.index'))
            ->setSuccessMessage('User data has been saved')
            ->type($this->request->ajax() ? 'ajax' : 'http')
            ->handle();
    }

    public function userManagementEdit($id)
    {
        $user = User::findOrFail($id);
        return (new UserCrudPresenter($user))->render();
    }

    public function userManagementUpdate($id)
    {
        $data = User::findOrFail($id);
        return (new UserCrudProcess($data))
            ->setSuccessRedirectTarget(route('admin.user.index'))
            ->setSuccessMessage('User data has been updated')
            ->type($this->request->ajax() ? 'ajax' : 'http')
            ->handle();
    }

    public function userManagementDelete($id=null)
    {
        return (new BaseDeleteProcess)
            ->setModel(new User)
            ->setId($id)
            ->type('ajax')
            ->handle();
    }

}
