<?php
namespace App\Core\Http\Controllers;

use App\Core\Base\Controllers\BaseController;
use App\Core\Http\Process\InstallProcess;
use App\Core\Http\Traits\InstallerTrait;
use App\Core\Presenters\InstallPresenter;

class InstallController extends BaseController
{
    use InstallerTrait;

    public function index()
    {
        return (new InstallPresenter)
            ->setHasInstall($this->checkHasInstall())
            ->setDb($this->checkDatabaseConnection())
            ->setEnv($this->getEnv())
            ->render();
    }

    public function process()
    {
        return (new InstallProcess)
            ->setErrorRedirectTarget(route('cms.install'))
            ->setSuccessRedirectTarget(admin_url('/'))
            ->setSuccessMessage('Your site has been installed successfully')
            ->type('http')
            ->handle();
    }

}
