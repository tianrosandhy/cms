<?php
namespace App\Modules\Post\Models;

use App\Core\Models\BaseModel;
use App\Core\Shared\Translateable;
use App\Core\Shared\Sluggable;
use App\Core\Shared\ImageGrabable;

class PostCategory extends BaseModel
{
	use Translateable;
	use Sluggable;
	use ImageGrabable;

	public $translate_model = 'App\Modules\Post\Models\PostCategoryTranslator';

	public function slugTarget(){
		return 'title';
	}
	
}
