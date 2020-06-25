<?php
namespace App\Core\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Core\Models\User;
use Media;

class UserSkeleton extends BaseSkeleton
{
	public function handle(){
		$this->registers([
			DataStructure::checker(),
			DataStructure::field('name')
				->name('Full Name')
				->inputType('text')
				->createValidation('required|max:50', true),
			DataStructure::field('email')
				->name('Email')
				->inputType('email')
				->createValidation('required|email', true),
			DataStructure::view('core::pages.partials.user-crud-additional'),
			DataStructure::field('password')
				->name('Password')
				->formColumn(6)
				->inputType('text')
				->createValidation('required|min:6|confirmed')
				->hideTable(),
			DataStructure::field('password_confirmation')
				->name('Password Confirmation')
				->formColumn(6)
				->inputType('text')
				->hideTable(),
			DataStructure::field('role_id')
				->name('Role')
				->inputType('select')
				->createValidation('required', true)
				->dataSource(function(){
					$out = [];
					foreach(app('role') as $role){
						$out[$role->id] = $role->name;
					}
					return $out;
				}),
			DataStructure::field('image')
				->name('Image')
				->inputType('image')
				->formColumn(6)
				->searchable(false)
				->orderable(false),
			DataStructure::switcher('is_active', 'Is Active', 6),
		]);
	}

	public function dataTableRoute(){
		return route('admin.user.datatable');
	}

	public function model(){
		return new User;
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'name' => $row->name,
			'email' => $row->email,
			'role_id' => $row->role->name ?? '<small class="text-danger">Unassigned</small>',
			'image' => '<img src="'.Media::getSelectedImage($row->image).'" style="height:50px;">',
			'is_active' => $this->switcherFormat($row, 'is_active'),
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		$out = '
		<a href="'.route('admin.user.edit', ['id' => $row->id]).'" class="btn btn-info">Edit</a>';
		$is_sa = $row->role->is_sa ?? false;
		if(!$is_sa){
			$out .= '
			<a href="'. route('admin.user.delete', ['id' => $row->id]) .'" class="btn btn-danger delete-button">Delete</a>
			';
		}

		return $out;
	}
}