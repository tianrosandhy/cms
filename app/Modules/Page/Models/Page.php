<?php
namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\Shared\Translateable;
use App\Core\Shared\Sluggable;
use App\Core\Shared\ImageGrabable;

class Page extends Model
{
	use Translateable;
	use Sluggable;
	use ImageGrabable;

	public $translate_model = 'App\Modules\Page\Models\PageTranslator';

	public function slugTarget(){
		return 'title';
	}

}
