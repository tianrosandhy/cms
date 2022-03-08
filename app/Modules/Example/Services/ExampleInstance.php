<?php
namespace App\Modules\Example\Services;

use App\Core\Base\Services\BaseInstance;
use App\Modules\Example\Models\Example;

class ExampleInstance extends BaseInstance
{
    public function __construct()
    {
        parent::__construct(new Example);
    }
}
