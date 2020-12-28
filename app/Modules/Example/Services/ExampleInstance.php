<?php
namespace App\Modules\Example\Services;

use App\Core\Exceptions\InstanceException;
use App\Core\Services\BaseInstance;
use App\Modules\Example\Models\Example;

class ExampleInstance extends BaseInstance
{
	public function __construct(){
		parent::__construct(new Example);
	}
}