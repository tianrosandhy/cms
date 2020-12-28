<?php
namespace App\Modules\Navigation\Models;

use App\Core\Models\BaseModel;
use App\Core\Shared\ImageGrabable;
use App\Core\Shared\Translateable;

class NavigationItem extends BaseModel
{
    use ImageGrabable;
    use Translateable;

	public $translate_model = 'App\Modules\Navigation\Models\NavigationItemTranslator';

    protected $fillable = [
    ];

    public function children(){
        return $this->hasMany('App\Modules\Navigation\Models\NavigationItem', 'parent');
    }

    public function group(){
        return $this->belongsTo('App\Modules\Navigation\Models\Navigation', 'group_id');
    }
}
