<?php
namespace App\Modules\Example\Models;

use App\Core\Models\BaseModel;

class ExampleTranslator extends BaseModel
{
    // $fillable now will be used as ColumnListing default data source for better performance column listing
    public $fillable = [
        'id',
        'main_id',
        'lang',
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

}
