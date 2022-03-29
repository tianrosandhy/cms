<?php
namespace TianRosandhy\Autocrud;

class Autocrud
{
    /**
     * asset() method will return a core css & js used
     */
    public static function assets()
    {
        return view('autocrud::assets')->render();
    }

    public static function slugify(string $text): string
    {
        $input = preg_replace("/[^a-zA-Z0-9- &]/", "", $text);
        $string = strtolower(str_replace(' ', '-', $input));
        if (strpos($string, '&') !== false) {
            $string = str_replace('&', 'and', $string);
        }
        return $string;
    }
}