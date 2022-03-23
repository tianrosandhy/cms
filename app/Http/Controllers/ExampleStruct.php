<?php
namespace App\Http\Controllers;

use TianRosandhy\Autocrud\StructureCollection\DatatableStructureCollection;
use TianRosandhy\Autocrud\StructureCollection\DatatableStructureCollectionContract;
use DatatableStructure;
use App\Modules\Example\Models\Example;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Input;

class ExampleStruct extends DatatableStructureCollection implements DatatableStructureCollectionContract
{
    public function handle()
    {
        $this->registers([
            DatatableStructure::field('text')
                ->name('Name Example')
                ->searchable(true)
                ->orderable(true),
            DatatableStructure::field('daterange')
                ->name('Date Range')
                ->inputType(Input::TYPE_DATERANGE)
                ->searchable(true)
                ->orderable(true),
            DatatableStructure::field('select')
                ->name('Contoh List')
                ->inputType(Input::TYPE_SELECT)
                ->searchable(true)
                ->orderable(true)
                ->dataSource([
                    0 => 'Lorem ipusm',
                    1 => 'Dolor sit amet',
                    2 => 'Sip Oke'
                ]),
        ]);
    }

    public function dataTableRoute(): string 
    {
        return route('datatable-route');
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
}