<?php
namespace App\Modules\Example\Models;

use App\Core\Models\BaseModel;
use App\Core\Shared\Translateable;
use App\Core\Shared\Sluggable;

class Example extends BaseModel
{
	use Translateable;
	use Sluggable;

	public $translate_model = 'App\Modules\Example\Models\ExampleTranslator';

	public function slugTarget(){
		return 'text';
	}
	
}
