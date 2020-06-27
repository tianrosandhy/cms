<?php
namespace App\Modules\Post\Services;

use App\Core\Exceptions\InstanceException;
use App\Core\Services\BaseInstance;
use App\Modules\Post\Models\Post;

class PostInstance extends BaseInstance
{
	public function __construct(){
		parent::__construct(new Post);
	}
}