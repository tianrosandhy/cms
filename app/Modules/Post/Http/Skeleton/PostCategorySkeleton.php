<?php
namespace App\Modules\Post\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Modules\Post\Models\PostCategory;
use Permission;

class PostCategorySkeleton extends BaseSkeleton
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
					'title.required' => 'Please fill the title'
				]),
			DataStructure::field('description')
				->name('Description')
				->hideTable()
				->inputType('richtext'),
			DataStructure::field('image')
				->name('Image')
				->inputType('image')
				->searchable(false)
				->orderable(false)
				->tabGroup('Details'),
			DataStructure::switcher('is_active', 'Is Active')
		]);
	}

	public function dataTableRoute(){
		return route('admin.post_category.datatable');
	}

	public function model(){
		return new PostCategory;
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'title' => $row->title,
			'image' => '<img src="'.$row->getImageUrl('image', 'thumb').'" style="height:50px;">',
			'is_active' => $this->switcherFormat($row, 'is_active', (Permission::has('admin.post_category.switch') ? 'toggle' : 'label')),
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		$out = '';
		if(Permission::has('admin.post_category.edit')){
			$out .= '<a href="'.route('admin.post_category.edit', ['id' => $row->id]).'" class="btn btn-info">Edit</a>';
		}
		if(Permission::has('admin.post_category.delete')){
			$out .= '<a href="'.route('admin.post_category.delete', ['id' => $row->id]).'" class="btn btn-danger delete-button">'. __('core::module.form.delete') .'</a>';
		}
		return $out;
	}
}