<?php
namespace App\Http\Controllers;

use App\Modules\Example\Models\Example;
use FormStructure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Input;
use TianRosandhy\Autocrud\Generator\Form\FormCollection;
use TianRosandhy\Autocrud\Generator\Form\FormCollectionContract;

class FormStruct extends FormCollection implements FormCollectionContract
{
    public function __construct(Model $data=null)
    {
        $this->data = $data;
        parent::__construct();
    }

    public function formRoute(): string
    {
        if ($this->data->getKey()) {
            return route('form-route', ['id' => $this->data->getKey()]);
        }
        return route('form-route');
    }

    public function isMultiLanguage(): bool 
    {
        return true;
    }

    public function isAjax(): bool
    {
        return true;
    }

    public function handle()
    {
        $this->registers([
            FormStructure::field('text')
                ->name('Name Example')
                ->validation('required')
                ->translateable(true)
                ->validationTranslation([
                    'text.required' => 'Teks wajib diisi'
                ]),
            FormStructure::field('image')
                ->name('Image')
                ->inputType(Input::TYPE_IMAGE),
            FormStructure::field('image_multiple')
                ->name('Image Multiple')
                ->inputType(Input::TYPE_IMAGEMULTIPLE),
            FormStructure::field('file')
                ->name('File')
                ->inputType(Input::TYPE_FILE),
            FormStructure::field('dates')
                ->name('Date')
                ->translateable(true)
                ->tabGroup('Next Group')
                ->inputType(Input::TYPE_DATE)
                ->createValidation('required|date')
                ->updateValidation('nullable|date')
                ->validationTranslation([
                    'dates.required' => 'Mohon mengisi tanggal',
                    'dates.date' => 'Format tanggal tidak valid'
                ])
                ->formColumn(6),
            FormStructure::field('select')
                ->name('Contoh List')
                ->tabGroup('Next Group')
                ->inputType(Input::TYPE_SELECT)
                ->formColumn(6)
                ->dataSource([
                    5 => 'Lorem ipusm',
                    1 => 'Dolor sit amet',
                    2 => 'Sip Oke',
                ]),
        ]);
    }

}
