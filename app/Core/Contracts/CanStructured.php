<?php
namespace App\Core\Contracts;

interface CanStructured
{
    // this method will register the structures handle
    public function handle();

    // this method will set the model used in structure
    public function model();
}
