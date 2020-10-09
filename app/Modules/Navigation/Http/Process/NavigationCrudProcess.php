<?php
namespace App\Modules\Navigation\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Navigation\Http\Skeleton\NavigationSkeleton;

class NavigationCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new NavigationSkeleton;
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.navigation.index'), //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

}