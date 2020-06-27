<?php
namespace App\Modules\Post\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Post\Http\Skeleton\PostCategorySkeleton;

class PostCategoryCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if(isset($instance->id)){
			$this->title = __('post::module.post_category.edit');
		}
		else{
			$this->title = __('post::module.post_category.add');
		}
		$this->data = $instance;
		$this->view = 'core::master.crud';
		#if you want to override this crud view, you can use below view instead
		// $this->view = '[LOWECASE_MODULE_NAME]::crud';

		$this->skeleton = new PostCategorySkeleton;
		$this->config = config('module-setting.post_category');
	}

	public function setSelectedMenuName(){
		return 'post_category';
	}
}