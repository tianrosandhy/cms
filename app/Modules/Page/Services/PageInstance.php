<?php
namespace App\Modules\Page\Services;

use App\Core\Exceptions\InstanceException;
use App\Core\Services\BaseInstance;
use App\Modules\Page\Models\Page;

class PageInstance extends BaseInstance
{
	public function __construct(){
		parent::__construct(new Page);
	}

}