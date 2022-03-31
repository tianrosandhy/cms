<?php
namespace App\Modules\Example\Presenters;

use App\Core\Base\Presenters\BaseViewPresenter;
use App\Modules\Example\Http\Structure\ExampleFormStructure;

class ExampleCrudPresenter extends BaseViewPresenter
{
    public function __construct($instance = null)
    {
        $this->title = __('example::module.example.add');
        if (isset($instance->id)) {
            $this->title = __('example::module.example.edit');
        }
        $this->data = $instance;
        $this->back_url = route('admin.example.index');
        $this->view = 'core::master.crud';

        $this->breadcrumb = [
            [
                'label' => __('example::module.index'),
                'url' => route('admin.example.index'),
            ],
        ];

        $this->structure = new ExampleFormStructure($this->data);
        $this->config = config('module-setting.example');
    }

    public function setSelectedMenuName()
    {
        return 'example';
    }
}
