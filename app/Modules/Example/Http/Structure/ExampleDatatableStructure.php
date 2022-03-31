<?php
namespace App\Modules\Example\Http\Structure;

use App\Modules\Example\Models\Example;
use DatatableStructure;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Input;
use Permission;
use TianRosandhy\Autocrud\Generator\Datatable\DatatableCollection;
use TianRosandhy\Autocrud\Generator\Datatable\DatatableCollectionContract;
use TianRosandhy\Autocrud\Generator\Datatable\TableChecker;

class ExampleDatatableStructure extends DatatableCollection implements DatatableCollectionContract
{
    use TableChecker;

    public function handle()
    {
        $source_example = [
            'Lorem',
            'Ipsum',
            'Dolor',
            'Sit amet',
            'Chimi',
            'Chocolate',
            'Watermelon',
        ];
        $this->registers([
            DatatableStructure::field('text')
                ->name('Text Example')
                ->inputType(Input::TYPE_TEXT)
                ->searchable(true)
                ->orderable(true),
            DatatableStructure::field('number')
                ->name('Number Example')
                ->inputType(Input::TYPE_NUMBER)
                ->searchable(true)
                ->orderable(true)
                ->searchOverride(function ($current_value, $context, $data_structures) {
                    // custom search override example
                    return function ($qry) use ($current_value) {
                        return $qry->where('number', '<=', $current_value);
                    };
                }),
            DatatableStructure::field('dates')
                ->name('Date Example')
                ->searchable(true)
                ->orderable(true)
                ->inputType(Input::TYPE_DATE),
            DatatableStructure::field('daterange')
                ->name('Date Range Example')
                ->inputType(Input::TYPE_DATERANGE)
                ->hideOnExport(true),
            DatatableStructure::field('select')
                ->name('Select Example')
                ->inputType(Input::TYPE_SELECT)
                ->dataSource($source_example),
            DatatableStructure::field('select_multiple[]')
                ->name('Select Multiple Example')
                ->inputType(Input::TYPE_SELECTMULTIPLE)
                ->dataSource($source_example),
            DatatableStructure::field('textarea')
                ->name('Textarea Example')
                ->inputType(Input::TYPE_TEXTAREA)
                ->hideOnExport(true)
                ->orderOverride(DB::raw('CHAR_LENGTH(textarea)')),
            DatatableStructure::field('richtext')
                ->name('Rich Text Example')
                ->inputType(Input::TYPE_RICHTEXT)
                ->hideOnExport(true),
            DatatableStructure::field('image')
                ->name('Image Example')
                ->inputType(Input::TYPE_IMAGESIMPLE)
                ->hideOnExport(true),
            DatatableStructure::field('image_multiple')
                ->name('Image Multiple Example')
                ->inputType(Input::TYPE_IMAGEMULTIPLE)
                ->hideOnExport(true),
            DatatableStructure::field('file')
                ->name('File Example')
                ->inputType(Input::TYPE_FILE)
                ->hideOnExport(true),
            DatatableStructure::field('file_multiple')
                ->name('File Multiple Example')
                ->inputType(Input::TYPE_FILEMULTIPLE)
                ->hideOnExport(true),
            DatatableStructure::field('radio')
                ->name('Radio Example')
                ->inputType(Input::TYPE_RADIO)
                ->dataSource([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ]),
            DatatableStructure::field('checkbox[]')
                ->name('Checkbox Example')
                ->inputType(Input::TYPE_CHECKBOX)
                ->dataSource([
                    'Ayam' => 'Ayam',
                    'Kambing' => 'Kambing',
                    'Sapi' => 'Sapi',
                ]),
            DatatableStructure::field('yesno')
                ->name('Yes/No Example')
                ->searchable(true)
                ->orderable(true)
                ->inputType(Input::TYPE_YESNO),
        ]);
    }

    public function dataTableRoute(): string
    {
        return route('admin.example.datatable');
    }

    public function batchDeleteRoute(): string
    {
        return route('admin.example.delete');
    }

    public function exportRoute(): string
    {
        return route('admin.example.export');
    }

    public function queryBuilder(): Builder
    {
        return Example::query();
    }

    public function transformer($row): array
    {
        return [
            'text' => $row->e('text'),
            'number' => $row->number,
            'dates' => $row->dates,
            'daterange' => $row->generateTags('daterange'),
            'select' => $row->select,
            'select_multiple' => $row->generateTags('select_multiple'),
            'textarea' => $row->textarea,
            'richtext' => $row->richtext,
            'image' => $row->outputImage('image'),
            'image_multiple' => $row->outputImage('image_multiple'),
            'file' => $row->outputFile('file'),
            'file_multiple' => $row->outputFile('file_multiple'),
            'radio' => $row->radio,
            'checkbox' => $row->generateTags('checkbox'),
            'yesno' => $row->yesno ? '<span class="p-1 btn btn-success" title="Active"><span class="iconify" data-icon="uim:check"></span>' : '<span class="p-1 btn btn-danger" title="Not Active"><span class="iconify" data-icon="uim:multiply"></span></span>',
            'action' => $this->actionButton($row),
        ];
    }

    protected function actionButton($row)
    {
        $out = '<div class="btn-group">';
        if (Permission::has('admin.example.edit')) {
            $out .= '<a href="' . route('admin.example.edit', ['id' => $row->id]) . '" class="btn btn-light text-primary" data-popup-lg title="Edit"><span class="iconify" data-icon="dashicons:edit"></span></a>';
        }
        if (Permission::has('admin.example.delete')) {
            $out .= '<a href="' . route('admin.example.delete', ['id' => $row->id]) . '" class="btn btn-light text-danger delete-button" title="Delete"><span class="iconify" data-icon="fluent:delete-16-filled"></span></a>';
        }
        $out .= '</div>';
        return $out;
    }

    public function exportRow($row): array
    {
        $daterange = json_decode($row->daterange, true);
        $sdaterange = '';
        if ($daterange) {
            $sdaterange = implode(', ', $daterange);
        }
        $select_multiple = json_decode($row->select_multiple, true);
        $sselect_multiple = '';
        if ($select_multiple) {
            $sselect_multiple = implode(', ', $select_multiple);
        }
        $checkbox = json_decode($row->checkbox, true);
        $scheckbox = '';
        if ($checkbox) {
            $scheckbox = implode(', ', $checkbox);
        }

        return [
            'text' => $row->e('text'),
            'number' => $row->number,
            'dates' => $row->dates,
            'daterange' => $sdaterange,
            'select' => $row->select,
            'select_multiple' => $sselect_multiple,
            'radio' => $row->radio,
            'checkbox' => $scheckbox,
            'yesno' => $row->yesno ? 'YES' : 'NO',
        ];
    }

    public function exportFileName()
    {
        return "Example Report";
    }

}
