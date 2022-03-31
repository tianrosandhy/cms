<?php
namespace App\Modules\Example\Presenters;

use App\Core\Base\Presenters\BaseViewPresenter;
use App\Modules\Example\Http\Structure\ExampleDatatableStructure;
use Permission;

class ExampleIndexPresenter extends BaseViewPresenter
{
    public function __construct()
    {
        $this->title = __('example::module.example.index');
        $this->view = 'core::master.index';
        #if you want to override this index view, you can use below view instead
        //$this->view = 'example::index';

        $this->structure = new ExampleDatatableStructure;
        $this->control_buttons = [];
        if (Permission::has('admin.example.create')) {
            $this->control_buttons[] = [
                'url' => route('admin.example.create'),
                'label' => __('core::module.form.add_data'),
                'type' => 'success',
                'icon' => 'plus',
                'attr' => [
                    'data-popup-lg' => '1',
                ],
            ];
        }
    }

    public function setSelectedMenuName()
    {
        return 'example';
    }
}
