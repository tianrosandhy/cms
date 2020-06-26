<?php
namespace App\Modules\Page\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Modules\Page\Models\Page;
use Permission;

class PageSkeleton extends BaseSkeleton
{
	public $multi_language = true;

	public function handle(){
		$this->registers([
			DataStructure::checker(),
			DataStructure::field('title')
				->name('Title')
				->inputType('text')
				->createValidation('required', true)
				->validationTranslation([
					'title.required' => 'Judulnya isi cuk'
				]),
			DataStructure::field('description')
				->name('Description')
				->hideTable()
				->inputType('richtext')
				->tabGroup('Description'),
			DataStructure::switcher('is_active', 'Is Active')
		]);
	}

	public function dataTableRoute(){
		return route('admin.page.datatable');
	}

	public function model(){
		return new Page;
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'title' => $row->title,
			'description' => $row->description,
			'is_active' => $this->switcherFormat($row, 'is_active', (Permission::has('admin.page.switch') ? 'toggle' : 'label')),
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		$out = '';
		if(Permission::has('admin.page.edit')){
			$out .= '<a href="'.route('admin.page.edit', ['id' => $row->id]).'" class="btn btn-info">Edit</a>';
		}
		if(Permission::has('admin.page.delete')){
			$out .= '<a href="'.route('admin.page.delete', ['id' => $row->id]).'" class="btn btn-danger delete-button">Delete</a>';
		}
		return $out;
	}
}