<?php
namespace App\Core\Contracts;

interface CanTransform
{
    // this method will transform the $row of model to single array based on $mode
    public function transform($row, $mode = 'datatable');
}
