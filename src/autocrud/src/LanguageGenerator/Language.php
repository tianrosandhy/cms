<?php
namespace TianRosandhy\Autocrud\LanguageGenerator;

class Language
{
    public static function available()
    {
        return config('autocrud.lang.available', [
            'en' => 'English'
        ]);
    }

    public static function default()
    {
        return config('autocrud.lang.default', 'en');
    }
}