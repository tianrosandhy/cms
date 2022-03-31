<?php
namespace App\Modules\Example\Http\Controllers;

use App\Core\Base\Controllers\BaseController;
use App\Modules\Example\Models\Example;
use App\Modules\Example\Http\Structure\ExampleDatatableStructure;
use App\Modules\Example\Http\Structure\ExampleFormStructure;
use App\Modules\Example\Presenters\ExampleCrudPresenter;
use App\Modules\Example\Http\Process\ExampleCrudProcess;
use App\Modules\Example\Http\Process\ExampleDeleteProcess;
use App\Modules\Example\Http\Process\ExampleExportProcess;
use Permission;

class ExampleController extends BaseController
{
    public function index()
    {
        $title = __('example::module.example.index');
        $structure = new ExampleDatatableStructure;
        $selected_menu = 'example';

        return view('example::index', compact(
            'title',
            'structure',
            'selected_menu'
        ));
    }

    public function export()
    {
        return (new ExampleDatatableStructure)->exportResponse();
    }

    public function datatable()
    {
        return (new ExampleDatatableStructure)->datatableResponse();
    }

    public function create()
    {
        $title = __('example::module.example.add');
        $data = new Example;
        $structure = new ExampleFormStructure($data);
        $breadcrumb = [
            [
                'label' => __('example::module.example.index'),
                'url' => route('admin.example.index'),
            ],
        ];

        return view('example::crud', compact(
            'title',
            'data',
            'structure',
            'breadcrumb'
        ));
    }

    public function store()
    {
        return (new ExampleCrudProcess(new Example))
            ->setSuccessRedirectTarget(route('admin.example.index'))
            ->type($this->request->ajax() ? 'ajax' : 'http')
            ->handle();
    }

    public function edit($id)
    {
        $title = __('example::module.example.edit');
        $data = Example::findOrFail($id);
        $structure = new ExampleFormStructure($data);
        $breadcrumb = [
            [
                'label' => __('example::module.example.index'),
                'url' => route('admin.example.index'),
            ],
        ];

        return view('example::crud', compact(
            'title',
            'data',
            'structure',
            'breadcrumb'
        ));
    }

    public function update($id)
    {
        $data = Example::findOrFail($id);
        return (new ExampleCrudProcess($data))
            ->setSuccessRedirectTarget(route('admin.example.index'))
            ->type($this->request->ajax() ? 'ajax' : 'http')
            ->handle();
    }

    public function delete($id=null)
    {
        return (new ExampleDeleteProcess($id))
            ->type('ajax')
            ->handle();
    }
}