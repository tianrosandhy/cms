<?php
namespace App\Modules\Navigation\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Modules\Navigation\Models\Navigation;
use Permission;

class NavigationSkeleton extends BaseSkeleton
{
	#ENABLE THIS PROPERTY IF YOU WANT TO USE MULTI LANGUAGE FEATURE
	//public $multi_language = true;

	#ENABLE THIS PROPERTY IF YOU DONT WANT TO USE THE NATIVE DATATABLE IN CRUD PAGE, AND YOU WANT TO DEFINE CUSTOM VIEW FOR EACH DATA ROW.
	//public $mode = 'custom'; // set ke mode custom untuk custom view menggantikan datatable
	//public $custom_html = 'navigation::custom-data';

	public function handle(){
		$this->registers([
			DataStructure::checker(),
			DataStructure::field('group_name')
				->name('Group Name')
				->formColumn(12)
				->createValidation('required', true),

			DataStructure::field('description')
				->name('Description')
				->formColumn(12)
				->inputType('textarea'),

			DataStructure::field('max_level')
				->name('Max Level')
				->formColumn(12)
				->inputType('number')
				->searchable(false)
				->inputAttribute([
					'min' => 0,
					'max' => 2,
				]),
			DataStructure::switcher('is_active', 'Is Active', 12),
		]);
	}

	public function dataTableRoute(){
		return route('admin.navigation.datatable');
	}

	//public function customFilter($context){
	//	return $context;
	//}

	public function model(){
		return new Navigation;
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'group_name' => '<a href="'.route('admin.navigation_item.manage', ['id' => $row->id]).'">'.$row->group_name.'</a>',
			'description' => descriptionMaker($row->description),
			'max_level' => $row->max_level,
			'is_active' => $this->switcherFormat($row, 'is_active', (Permission::has('admin.navigation.switch') ? 'toggle' : 'label')),
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		$out = '';
		if(Permission::has('admin.navigation_item.manage')){
			$out .= '<a href="'.route('admin.navigation_item.manage', ['id' => $row->id]).'" class="btn btn-secondary manage-btn">Manage</a>';
		}
		if(Permission::has('admin.navigation.edit')){
			$out .= '<a href="'.route('admin.navigation.edit', ['id' => $row->id]).'" class="btn btn-info">Edit</a>';
		}
		if(Permission::has('admin.navigation.delete')){
			$out .= '<a href="'.route('admin.navigation.delete', ['id' => $row->id]).'" class="btn btn-danger delete-button">Delete</a>';
		}
		return $out;
	}

}