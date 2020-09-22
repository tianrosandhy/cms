<?php
namespace App\Modules\Notification\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Modules\Notification\Models\Notification;
use Permission;

class NotificationSkeleton extends BaseSkeleton
{
	#ENABLE THIS PROPERTY IF YOU WANT TO USE MULTI LANGUAGE FEATURE
	//public $multi_language = true;

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
			DataStructure::field('content')
				->name('Content')
				->inputType('textarea')
				->inputAttribute([
					'maxlength' => 500
				])
				->createValidation('required', true)
				->validationTranslation([
					'content.required' => 'Please fill the notification content'
				]),
			DataStructure::field('image')
				->name('Image')
				->inputType('image')
				->searchable(false)
				->orderable(false),

			DataStructure::field('sent')
				->name('Sent')
				->searchable(false)
				->orderable(false)
				->hideForm(),

		]);
	}

	public function dataTableRoute(){
		return route('admin.notification.datatable');
	}

	//public function customFilter($context){
	//	return $context;
	//}

	public function model(){
		return new Notification;
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'title' => $row->title,
			'content' => $row->content,
			'image' => '<img src="'.$row->getImageUrl('image', 'thumb').'" style="height:50px;">',
			'sent' => $row->sents->count(),
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		$out = '';
		if(Permission::has('admin.notification.delete')){
			$out .= '<a href="'.route('admin.notification.delete', ['id' => $row->id]).'" class="btn btn-danger delete-button">Delete</a>';
		}
		return $out;
	}
}