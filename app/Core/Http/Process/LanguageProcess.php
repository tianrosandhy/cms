<?php
namespace App\Core\Http\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;

class LanguageProcess extends BaseProcess
{
	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => null, //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$validate = Validator::make($this->request->all(), [
			//your validation rules
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}
	}

	public function process(){
		//your logic after validation success
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}