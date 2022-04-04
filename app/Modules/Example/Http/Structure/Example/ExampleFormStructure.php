<?php
namespace App\Modules\Example\Http\Structure\Example;

use App\Modules\Example\Models\Example;
use FormStructure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Input;
use TianRosandhy\Autocrud\Generator\Form\FormCollection;
use TianRosandhy\Autocrud\Generator\Form\FormCollectionContract;

class ExampleFormStructure extends FormCollection implements FormCollectionContract
{
    public function __construct(Model $data=null)
    {
        $this->data = $data;
        parent::__construct();
    }

    public function formRoute(): string
    {
        if ($this->data->getKey()) {
            return route('admin.example.update', ['id' => $this->data->getKey()]);
        }
        return route('admin.example.store');
    }

    public function isMultiLanguage(): bool 
    {
        return false;
    }

    public function isAjax(): bool
    {
        return true;
    }

    public function prependForm($data=null): ?string
    {
        // return any html string via view()->render();
        return null;
    }

    public function appendForm($data=null): ?string
    {
        // return any html string via view()->render();
        return null;
    }

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
            FormStructure::field('text')
                ->name('Text Example')
                ->inputType(Input::TYPE_TEXT)
                ->validation('required'),
            FormStructure::field('number')
                ->name('Number Example')
                ->inputType(Input::TYPE_NUMBER)
                ->validation('required'),
            FormStructure::field('dates')
                ->name('Date Example')
                ->inputType(Input::TYPE_DATE)
                ->formColumn(4),
            FormStructure::field('daterange')
                ->name('Date Range Example')
                ->inputType(Input::TYPE_DATERANGE)
                ->formColumn(8),
            FormStructure::field('select')
                ->name('Select Example')
                ->inputType(Input::TYPE_SELECT)
                ->dataSource($source_example)
                ->formColumn(6),
            FormStructure::field('select_multiple[]')
                ->name('Select Multiple Example')
                ->inputType(Input::TYPE_SELECTMULTIPLE)
                ->dataSource($source_example)
                ->formColumn(6),
            FormStructure::field('textarea')
                ->name('Textarea Example')
                ->inputType(Input::TYPE_TEXTAREA),
            FormStructure::field('richtext')
                ->name('Rich Text Example')
                ->inputType(Input::TYPE_RICHTEXT),
            FormStructure::field('image')
                ->name('Image Example')
                ->inputType(Input::TYPE_IMAGESIMPLE)
                ->formColumn(3),
            FormStructure::field('image_multiple')
                ->name('Image Multiple Example')
                ->inputType(Input::TYPE_IMAGEMULTIPLE)
                ->formColumn(9),
            FormStructure::field('file')
                ->name('File Example')
                ->inputType(Input::TYPE_FILE)
                ->formColumn(6),
            FormStructure::field('file_multiple')
                ->name('File Multiple Example')
                ->inputType(Input::TYPE_FILEMULTIPLE)
                ->formColumn(6),
            FormStructure::field('radio')
                ->name('Radio Example')
                ->inputType(Input::TYPE_RADIO)
                ->dataSource([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->formColumn(4),
            FormStructure::field('checkbox[]')
                ->name('Checkbox Example')
                ->inputType(Input::TYPE_CHECKBOX)
                ->dataSource([
                    'Ayam' => 'Ayam',
                    'Kambing' => 'Kambing',
                    'Sapi' => 'Sapi',
                ])
                ->formColumn(4),
            FormStructure::field('yesno')
                ->name('Yes/No Example')
                ->searchable(true)
                ->orderable(true)
                ->inputType(Input::TYPE_YESNO)
                ->formColumn(4),
        ]);
    }

}
