<?php
namespace App\Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\Shared\Translateable;
use App\Core\Shared\Sluggable;
use App\Core\Shared\ImageGrabable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
	use HasFactory;
	use Translateable;
	use Sluggable;
	use ImageGrabable;

	public $translate_model = 'App\Modules\Post\Models\PostTranslator';

	public function slugTarget(){
		return 'title';
	}

	protected static function newFactory(){
		return \Database\Factories\PostFactory::new();
	}
	
}
