<?php
namespace App\Core\Http\Structure;

use App\Core\Models\User;
use DatatableStructure;
use Illuminate\Database\Eloquent\Builder;
use Input;
use Media;
use Permission;
use TianRosandhy\Autocrud\Generator\Datatable\DatatableCollection;
use TianRosandhy\Autocrud\Generator\Datatable\DatatableCollectionContract;
use TianRosandhy\Autocrud\Generator\Datatable\TableChecker;

class UserDatatableStructure extends DatatableCollection implements DatatableCollectionContract
{
    use TableChecker;

    public function handle()
    {
        $this->registers([
            DatatableStructure::field('name')
                ->name('Full Name')
                ->searchable(true)
                ->orderable(true)
                ->inputType(Input::TYPE_TEXT),
            DatatableStructure::field('email')
                ->name('Email')
                ->searchable(true)
                ->orderable(true)
                ->inputType(Input::TYPE_EMAIL),
            DatatableStructure::field('role_id')
                ->name('Role')
                ->searchable(true)
                ->orderable(true)
                ->inputType(Input::TYPE_SELECT)
                ->dataSource(function () {
                    $lists = new \App\Core\Components\RoleStructure;
                    return $lists->dropdown_list;
                }),
            DatatableStructure::field('image')
                ->name('Image')
                ->inputType(Input::TYPE_IMAGE)
                ->hideOnExport(true),
            DatatableStructure::field('is_active')
                ->name('Is Active')
                ->inputType(Input::TYPE_YESNO),
        ]);
    }

    public function dataTableRoute(): string
    {
        return route('admin.user.datatable');
    }

    public function batchDeleteRoute(): string
    {
        return route('admin.user.delete');
    }

    // public function exportRoute(): string
    // {
    //     return route('admin.user.export');
    // }

    public function queryBuilder(): Builder
    {
        $roles = new \App\Core\Components\RoleStructure;
        return User::with('role')->whereIn('role_id', $roles->array_only);
    }

    public function transformer($row): array
    {
        return [
            'name' => $row->name,
            'email' => $row->email,
            'role_id' => $row->role->name ?? '<small class="text-danger">Unassigned</small>',
            'image' => '<img src="' . Media::getSelectedImage($row->image, 'thumb') . '" style="height:50px;">',
            'is_active' => $row->is_active ? '<span class="p-1 btn btn-success" title="Active"><span class="iconify" data-icon="uim:check"></span>' : '<span class="p-1 btn btn-danger" title="Not Active"><span class="iconify" data-icon="uim:multiply"></span></span>',
            'action' => $this->actionButton($row),
        ];
    }

    protected function actionButton($row)
    {
        $out = '
		<div class="btn-group">
		';
        if (Permission::has('admin.user.edit')) {
            $out .= '<a href="' . route('admin.user.edit', ['id' => $row->id]) . '" class="btn btn-light text-primary"><span class="iconify" data-icon="dashicons:edit"></span></a>';
        }

        $is_sa = $row->role->is_sa ?? false;
        if (!$is_sa) {
            if (Permission::has('admin.user.delete')) {
                $out .= '
				<a href="' . route('admin.user.delete', ['id' => $row->id]) . '" class="btn btn-light text-danger delete-button"><span class="iconify" data-icon="fluent:delete-16-filled"></span></a>
				';
            }
        }
        $out .= '</div>';

        return $out;
    }

    // public function exportRow($raw_data): array
    // {
    //     return [
    //         'name' => $row->name,
    //         'email' => $row->email,
    //         'role_id' => $row->role->name ?? 'Unassigned',
    //         'image' => '',
    //         'is_active' => $row->is_active ? 'YES' : 'NO',
    //     ];
    //     return $raw_data->toArray();
    // }

    // public function exportFileName()
    // {
    //     return "Example Report";
    // }

}
