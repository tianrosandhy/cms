<?php
namespace TianRosandhy\Autocrud\Facades;

use Illuminate\Support\Facades\Facade;

class Language extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TianRosandhy\Autocrud\LanguageGenerator\Language::class;
    }
}
