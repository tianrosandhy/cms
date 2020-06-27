<?php
namespace App\Modules\Post\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Post\Http\Skeleton\PostCategorySkeleton;

class PostCategoryCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new PostCategorySkeleton;
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.post_category.index'), //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

}