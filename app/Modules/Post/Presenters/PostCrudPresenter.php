<?php
namespace App\Modules\Post\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Post\Http\Skeleton\PostSkeleton;

class PostCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if(isset($instance->id)){
			$this->title = __('post::module.post.edit');
		}
		else{
			$this->title = __('post::module.post.add');
		}
		$this->data = $instance;
		$this->view = 'core::master.crud';
		$this->back_url = route('admin.post.index');
		#if you want to override this crud view, you can use below view instead
		// $this->view = '[LOWECASE_MODULE_NAME]::crud';

		$this->skeleton = new PostSkeleton;
		$this->config = config('module-setting.post');
	}

	public function setSelectedMenuName(){
		return 'post';
	}
}