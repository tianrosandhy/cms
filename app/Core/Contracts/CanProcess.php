<?php
namespace App\Core\Contracts;

interface CanProcess
{
    // this method will throw ValidationException if process fails
    public function validate();

    // this method will handle the processing logic
    public function process();
}
