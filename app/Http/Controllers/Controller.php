<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $struct = new ExampleStruct;
        return view('test', [
            'struct' => $struct
        ]);
    }

    public function datatable()
    {
        $struct = new ExampleStruct;
        return $struct->ajaxResponse();
    }
}
