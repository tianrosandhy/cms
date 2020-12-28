<?php
namespace App\Modules\Page\Models;

use App\Core\Models\BaseModel;
use App\Core\Shared\Translateable;
use App\Core\Shared\Sluggable;
use App\Core\Shared\ImageGrabable;

class Page extends BaseModel
{
	use Translateable;
	use Sluggable;
	use ImageGrabable;

	public $translate_model = 'App\Modules\Page\Models\PageTranslator';

	public function slugTarget(){
		return 'title';
	}

}
