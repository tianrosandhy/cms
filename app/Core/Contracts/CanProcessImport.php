<?php
namespace App\Core\Contracts;

interface CanProcessImport
{
    // this method will process importing the $rows[]
    public function handleImport($rows = []);
}
