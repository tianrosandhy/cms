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
}