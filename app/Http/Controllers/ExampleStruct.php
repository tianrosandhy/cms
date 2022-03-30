<?php
namespace App\Http\Controllers;

use App\Modules\Example\Models\Example;
use DatatableStructure;
use Illuminate\Database\Eloquent\Builder;
use Input;
use TianRosandhy\Autocrud\Generator\Datatable\DatatableCollection;
use TianRosandhy\Autocrud\Generator\Datatable\DatatableCollectionContract;
use TianRosandhy\Autocrud\Generator\Datatable\TableChecker;

class ExampleStruct extends DatatableCollection implements DatatableCollectionContract
{
    use TableChecker;

    public function handle()
    {
        $this->registers([
            DatatableStructure::field('text')
                ->name('Name Example')
                ->searchable(true)
                ->orderable(true),
            DatatableStructure::field('dates')
                ->name('Date')
                ->inputType(Input::TYPE_DATE)
                ->searchable(true)
                ->hideOnDatatable(true)
                ->orderable(true),
            DatatableStructure::field('select')
                ->name('Contoh List')
                ->inputType(Input::TYPE_SELECT)
                ->searchable(true)
                ->hideOnExport(true)
                ->orderable(true)
                ->dataSource([
                    5 => 'Lorem ipusm',
                    1 => 'Dolor sit amet',
                    2 => 'Sip Oke',
                ]),
        ]);
    }

    public function dataTableRoute(): string
    {
        return route('datatable-route');
    }

    public function batchDeleteRoute(): string
    {
        return route('data-delete-route');
    }

    public function exportRoute(): string
    {
        return route('datatable-export');
    }

    public function queryBuilder(): Builder
    {
        return Example::query();
    }

    public function transformer($raw_data): array
    {
        $single = $raw_data->toArray();
        $single['action'] = '';
        return $single;
    }

    public function exportRow($raw_data): array
    {
        return $raw_data->toArray();
    }

    public function exportFileName()
    {
        return "Example Report";
    }
}
