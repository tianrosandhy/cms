<?php
namespace App\Modules\Page\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Modules\Page\Models\Page;

class PageSkeleton extends BaseSkeleton
{
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
				->inputType('richtext'),
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
			'is_active' => $row->is_active ?? 0,
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		return '
		<a href="#" class="btn btn-primary">Detail</a>
		<a href="#" class="btn btn-info">Edit</a>
		<a href="#" class="btn btn-danger">Delete</a>
		';
	}
}