<?php
namespace App\Core\Contracts;

interface CanProcessExport
{
    // this method will register the import name
    public function exportName() : string;

    // this method will register the used model
    public function exportModel();

    // this method will register the used Structure class
    public function exportStructure();
}