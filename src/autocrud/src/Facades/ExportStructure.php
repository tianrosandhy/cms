<?php
namespace TianRosandhy\Autocrud\Facades;

use App\Core\Facades\RefreshableFacade;

class ExportStructure extends RefreshableFacade
{
    protected static function getFacadeAccessor()
    {
        return \TianRosandhy\Autocrud\DataStructure\ExportStructure::class;
    }
}
