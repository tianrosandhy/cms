<?php
namespace App\Modules\Example\Models;

use App\Core\Models\BaseModel;
use TianRosandhy\Autocrud\Shared\Sluggable;
use TianRosandhy\Autocrud\Shared\Translateable;
use TianRosandhy\Autocrud\Shared\ImageGrabable;

class Example extends BaseModel
{
    use Translateable;
    use Sluggable;
    use ImageGrabable;

    // $fillable now will be used as ColumnListing default data source for better performance column listing
    public $fillable = [
        'id',
        'text',
        'number',
        'dates',
        'daterange',
        'select',
        'select_multiple',
        'textarea',
        'richtext',
        'image',
        'image_multiple',
        'file',
        'file_multiple',
        'radio',
        'checkbox',
        'yesno',
        'map',
    ];

    public $translate_model = 'App\Modules\Example\Models\ExampleTranslator';

    public function slugTarget()
    {
        return 'text';
    }

}
