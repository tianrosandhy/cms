<?php
namespace App\Core\Contracts;

interface CanProcessPreimport
{
    // this method will register the import name
    public function importName() : string;

    // this method will register the used Structure class
    public function importStructure();

    // this method will validate the inputted data. 
    public function rowValidator($rows=[]);
}