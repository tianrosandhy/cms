<?php
namespace App\Core\Http\Structure;

use App\Core\Models\User;
use FormStructure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Input;
use TianRosandhy\Autocrud\Generator\Form\FormCollection;
use TianRosandhy\Autocrud\Generator\Form\FormCollectionContract;

class UserFormStructure extends FormCollection implements FormCollectionContract
{
    public function __construct(Model $data=null)
    {
        $this->data = $data;
        parent::__construct();
    }

    public function formRoute(): string
    {
        if ($this->data->getKey()) {
            return route('admin.user.update', ['id' => $this->data->getKey()]);
        }
        return route('admin.user.store');
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
        $this->registers([
            FormStructure::field('name')
                ->name('Full Name')
                ->inputType(Input::TYPE_TEXT)
                ->validation('required|max:50'),
            FormStructure::field('email')
                ->name('Email')
                ->inputType(Input::TYPE_EMAIL)
                ->validation('required|email|unique:users,email,[id]'),
            FormStructure::field('additional')
                ->view('core::pages.user.crud-additional'),
            FormStructure::field('password')
                ->name('Password')
                ->formColumn(6)
                ->inputType(Input::TYPE_TEXT)
                ->valueData(function () {
                    return '';
                })
                ->createValidation('required|min:6|confirmed'),
            FormStructure::field('password_confirmation')
                ->name('Password Confirmation')
                ->formColumn(6)
                ->inputType(Input::TYPE_TEXT),
            FormStructure::field('role_id')
                ->name('Role')
                ->inputType(Input::TYPE_SELECT)
                ->validation('required')
                ->dataSource(function () {
                    $lists = new \App\Core\Components\RoleStructure;
                    return $lists->dropdown_list;
                }),
            FormStructure::field('image')
                ->name('Image')
                ->inputType(Input::TYPE_IMAGE)
                ->formColumn(6),
            FormStructure::field('is_active')
                ->name('Is Active')
                ->inputType(Input::TYPE_YESNO)
                ->dataSource([
                    0 => 'Not Active',
                    1 => 'Active'
                ])
                ->formColumn(6),

        ]);
    }

}
