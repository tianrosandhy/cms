<?php
namespace TianRosandhy\Autocrud\Facades;

use App\Core\Facades\RefreshableFacade;

class DatatableStructure extends RefreshableFacade
{
    protected static function getFacadeAccessor()
    {
        return \TianRosandhy\Autocrud\DataStructure\DatatableStructure::class;
    }
}
