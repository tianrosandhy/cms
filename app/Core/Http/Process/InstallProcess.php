<?php
namespace App\Core\Http\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Contracts\CanProcess;
use App\Core\Exceptions\ProcessException;
use App\Core\Http\Traits\InstallerTrait;
use Artisan;
use DB;
use Language;
use Validator;

class InstallProcess extends BaseProcess implements CanProcess
{
    use InstallerTrait;

    public function validate()
    {
        Artisan::call('migrate');
        //validation process
        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            throw new ProcessException($validator);
        }
    }

    public function process()
    {
        $db = $this->checkDatabaseConnection();
        if ($db) {
            //check if has database config has changed parameters
            $env = $this->updateEnv();
            if ($env) {
                $this->setSuccessMessage('File .env has been updated.');
                return true;
            } else {
                throw new ProcessException('Please update the .env file manually before you can continue install this CMS');
            }
        }

        $this->installAction();

        $this->setSuccessMessage('CMS Installation has been finished. Now you can use this CMS');
        return true;
    }

    public function installAction()
    {
        Artisan::call('autocrud:role');
        Language::insertDefaultLanguage();
        $this->createUser($this->request->email, $this->request->name, $this->request->password);
        $this->createInstallHint();
    }

    protected function createUser($email, $username, $password)
    {
        DB::table('users')->insert([
            'name' => $username,
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 1, //default
            'image' => '',
            'activation_key' => null,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

}
