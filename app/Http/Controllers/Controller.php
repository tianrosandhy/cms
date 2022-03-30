<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Modules\Example\Models\Example;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $struct = new ExampleStruct;
        return view('test', [
            'struct' => $struct
        ]);
    }

    public function export()
    {
        $struct = new ExampleStruct;
        return $struct->exportResponse();
    }

    public function form()
    {
        $struct = new FormStruct(new Example);
        return view('form', [
            'struct' => $struct
        ]);
    }

    public function formPost()
    {
        $struct = new FormStruct(new Example);
        $crudResponse = $struct->autoCrud();
        if ($crudResponse->ok()) {
            return redirect()->route('index')->with([
                'success' => 'OKE MANTAP'
            ]);
        } else {
            return redirect()->back()->withInput()->with([
                'error' => $crudResponse->errors()
            ]);
        }
    }

    public function datatable()
    {
        $struct = new ExampleStruct;
        return $struct->datatableResponse();
    }
}
