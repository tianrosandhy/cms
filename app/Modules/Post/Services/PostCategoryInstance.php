<?php
namespace App\Modules\Post\Services;

use App\Core\Exceptions\InstanceException;
use App\Core\Services\BaseInstance;
use App\Modules\Post\Models\PostCategory;

class PostCategoryInstance extends BaseInstance
{
	public function __construct(){
		parent::__construct(new PostCategory);
	}
}