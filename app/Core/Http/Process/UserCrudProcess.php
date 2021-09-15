<?php
namespace App\Core\Http\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Core\Http\Structure\UserStructure;
use Validator;

class UserCrudProcess extends BaseProcess
{
	public function __construct($instance=null){
		parent::__construct();
		if(isset($instance->id)){
			$this->mode = 'update';
		}
		else{
			$this->mode = 'create';
		}
		$this->instance = $instance;
		$this->structure = new UserStructure;
	}


	public function validate(){
		$current_key = empty($this->instance) ? null : $this->instance->getKey();
		$validator = $this->structure->generateValidation($this->mode, $current_key);
		if($validator){
			if($validator->fails()){
				throw new ProcessException($validator);
			}
		}

		//tambahan validasi jika dalam kondisi update + ganti password
		if($this->mode == 'update' && $this->request->password){
			$validator = Validator::make($this->request->all(), [
				'password' => 'required|confirmed|min:6'
			]);
			if($validator->fails()){
				throw new ProcessException($validator);
			}
		}
		// dd($this->request->all());
	}

	public function process(){
		//your logic after validation success
		$structure_inputs = $this->structure->autoCrud();
		if(!empty($structure_inputs)){
			//create new instance if not exists, but use selected instance if exists
			$instance = $this->instance ?? $this->structure->model();
			foreach($structure_inputs as $field => $value){
				//gausah ubah password dalam mode update jika tidak diperlukan
				if($this->mode == 'update' && $field == 'password' && empty($value)){
					continue;
				}
				if($field == 'password'){
					$value = bcrypt($value);
				}

				$instance->{$field} = $value;
			}
			$instance->save();
		}
		if($this->request->save_only){
			$this->setSuccessRedirectTarget(route('admin.user.edit', ['id' => $instance->id]));
		}

		// if you have another logic for storing data that doesnt cover by Structure, you can define them here.
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}