<?php
namespace App\Modules\Page\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Modules\Page\Http\Skeleton\PageSkeleton;
use Validator;

class PageStoreProcess extends BaseProcess
{
	public function __construct(){
		parent::__construct();
		$this->skeleton = new PageSkeleton;
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => null, //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$validator = $this->skeleton->generateValidation('create');
		if($validator){
			if($validator->fails()){
				throw new ProcessException($validator);
			}
		}
	}

	public function process(){
		//your logic after validation success
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}