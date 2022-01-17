<?php
namespace App\Core\Excels;

use Maatwebsite\Excel\Concerns\ToArray;

class ArrayImporter implements ToArray
{
    public function array(array $array)
    {   
        return $array;
    }
}