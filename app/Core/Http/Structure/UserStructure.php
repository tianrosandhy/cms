<?php
namespace App\Core\Http\Structure;

use DataStructure;
use App\Core\Base\Structure\BaseStructure;
use App\Core\Models\User;
use App\Core\Transformers\UserTransformer;
use Media;
use Permission;

class UserStructure extends BaseStructure
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
				->createValidation('required|email|unique:users,email,[id]', true),
			DataStructure::view('core::pages.user.crud-additional'),
			DataStructure::field('password')
				->name('Password')
				->formColumn(6)
				->inputType('text')
				->valueData(function(){
					return '';
				})
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
					$lists = new \App\Core\Components\RoleStructure;
					return $lists->dropdown_list;
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

	public function transformer(){
		return new UserTransformer;
	}

	public function customFilter($context){
		$roles = new \App\Core\Components\RoleStructure;
		return $context->whereIn('role_id', $roles->array_only);
	}

	public function dataTableRoute(){
		return route('admin.user.datatable');
	}

	public function model(){
		return new User;
	}

}