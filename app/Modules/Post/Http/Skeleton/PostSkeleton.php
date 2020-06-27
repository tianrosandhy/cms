<?php
namespace App\Modules\Post\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Modules\Post\Models\Post;
use Permission;

class PostSkeleton extends BaseSkeleton
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
			DataStructure::field('excerpt')
				->name('Excerpt')
				->inputType('textarea')
				->inputAttribute([
					'maxlength' => 200
				]),
			DataStructure::field('author')
				->name('Author')
				->tabGroup('Details'),
			DataStructure::field('description')
				->name('Description')
				->hideTable()
				->inputType('richtext'),
			DataStructure::field('tags')
				->name('Tags')
				->inputType('tags')
				->hideTable()
				->tabGroup('Details'),
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
		return route('admin.post.datatable');
	}

	public function model(){
		return new Post;
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'title' => $row->title,
			'excerpt' => descriptionMaker($row->excerpt, 15),
			'author' => $row->author,
			'description' => $row->description,
			'image' => '<img src="'.$row->getImageUrl('image', 'thumb').'" style="height:50px;">',
			'is_active' => $this->switcherFormat($row, 'is_active', (Permission::has('admin.post.switch') ? 'toggle' : 'label')),
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		$out = '';
		if(Permission::has('admin.post.edit')){
			$out .= '<a href="'.route('admin.post.edit', ['id' => $row->id]).'" class="btn btn-info">Edit</a>';
		}
		if(Permission::has('admin.post.delete')){
			$out .= '<a href="'.route('admin.post.delete', ['id' => $row->id]).'" class="btn btn-danger delete-button">Delete</a>';
		}
		return $out;
	}
}