<?php
namespace App\Modules\Example\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Modules\Example\Models\Example;
use Permission;

class ExampleSkeleton extends BaseSkeleton
{
	#ENABLE THIS PROPERTY IF YOU WANT TO USE MULTI LANGUAGE FEATURE
	//public $multi_language = true;

	#ENABLE THIS PROPERTY IF YOU DONT WANT TO USE THE NATIVE DATATABLE IN CRUD PAGE, AND YOU WANT TO DEFINE CUSTOM VIEW FOR EACH DATA ROW.
	//public $mode = 'custom'; // set ke mode custom untuk custom view menggantikan datatable
	//public $custom_html = 'example::custom-data';

	public function handle(){
		$source_example = [
			'Lorem',
			'Ipsum',
			'Dolor',
			'Sit amet',
			'Chimi',
			'Chocolate',
			'Watermelon'
		];
		$this->registers([
			DataStructure::checker(),
			DataStructure::field('text')
				->name('Text Example')
				->inputType('text')
				->createValidation('required', true)
				->validationTranslation([
					'text.required' => 'Please fill the text'
				]),
			DataStructure::field('number')
				->name('Number Example')
				->inputType('number'),
			DataStructure::field('dates')
				->name('Date Example')
				->inputType('date'),
			DataStructure::field('daterange')
				->name('Date Range Example')
				->inputType('daterange'),
			DataStructure::field('select')
				->name('Select Example')
				->inputType('select')
				->dataSource($source_example),
			DataStructure::field('select_multiple[]')
				->name('Select Multiple Example')
				->inputType('select_multiple')
				->dataSource($source_example),
			DataStructure::field('textarea')
				->name('Textarea Example')
				->inputType('textarea'),
			DataStructure::field('richtext')
				->name('Rich Text Example')
				->inputType('richtext'),
			DataStructure::field('image')
				->name('Image Example')
				->inputType('image_simple')
				->searchable(false)
				->orderable(false),
			DataStructure::field('image_multiple')
				->name('Image Multiple Example')
				->inputType('image_multiple')
				->searchable(false)
				->orderable(false),
			DataStructure::field('file')
				->name('File Example')
				->inputType('file')
				->searchable(false)
				->orderable(false),
			DataStructure::field('file_multiple')
				->name('File Multiple Example')
				->inputType('file_multiple')
				->searchable(false)
				->orderable(false),
			DataStructure::field('radio')
				->name('Radio Example')
				->inputType('radio')
				->dataSource([
					'L' => 'Laki-laki',
					'P' => 'Perempuan',
				]),
			DataStructure::field('checkbox[]')
				->name('Checkbox Example')
				->inputType('checkbox')
				->dataSource([
					'Ayam' => 'Ayam',
					'Kambing' => 'Kambing',
					'Sapi' => 'Sapi',
				]),
			DataStructure::switcher('yesno', 'Yes/No Example'),
			DataStructure::field('map')
				->name('Map Example')
				->inputType('map'),

		]);
	}

	public function dataTableRoute(){
		return route('admin.example.datatable');
	}

	//public function customFilter($context){
	//	$searched_field = $this->getSearchField('field_name');
	//	return $context;
	//}

	public function model(){
		return new Example;
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'text' => $row->e('text'),
			'number' => $row->number,
			'dates' => $row->dates,
			'daterange' => $row->generateTags('daterange'),
			'select' => $row->select,
			'select_multiple' => $row->generateTags('select_multiple'),
			'textarea' => $row->textarea,
			'richtext' => $row->richtext,
			'image' => $row->outputImage('image'),
			'image_multiple' => $row->outputImage('image_multiple'),
			'file' => $row->outputFile('file'),
			'file_multiple' => $row->outputFile('file_multiple'),
			'radio' => $row->radio,
			'checkbox' => $row->generateTags('checkbox'),
			'yesno' => $this->switcherFormat($row, 'yesno', (Permission::has('admin.example.switch') ? 'toggle' : 'label')),
			'map' => $row->generateTags('map'),
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		$out = '';
		if(Permission::has('admin.example.edit')){
			$out .= '<a href="'.route('admin.example.edit', ['id' => $row->id]).'" class="btn btn-info">Edit</a>';
		}
		if(Permission::has('admin.example.delete')){
			$out .= '<a href="'.route('admin.example.delete', ['id' => $row->id]).'" class="btn btn-danger delete-button">Delete</a>';
		}
		return $out;
	}
}