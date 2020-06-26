<?php
namespace App\Modules\Page\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Page\Http\Skeleton\PageSkeleton;

class PageCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new PageSkeleton;
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.page.index'), //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

}