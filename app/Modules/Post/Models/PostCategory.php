<?php
namespace App\Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\Shared\Translateable;
use App\Core\Shared\Sluggable;
use App\Core\Shared\ImageGrabable;

class PostCategory extends Model
{
	use Translateable;
	use Sluggable;
	use ImageGrabable;

	public $translate_model = 'App\Modules\Post\Models\PostCategoryTranslator';

	public function slugTarget(){
		return 'title';
	}
	
}
