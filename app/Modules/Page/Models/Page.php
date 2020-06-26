<?php
namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\Shared\Translateable;

class Page extends Model
{
	use Translateable;

	public $translate_model = 'App\Modules\Page\Models\PageTranslator';

}
