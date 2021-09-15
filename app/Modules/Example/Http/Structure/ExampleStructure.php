<?php
namespace App\Modules\Example\Http\Structure;

use DataStructure;
use App\Core\Base\Structure\BaseStructure;
use App\Modules\Example\Models\Example;
use App\Modules\Example\Transformers\ExampleTransformer;
use Permission;

class ExampleStructure extends BaseStructure
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
				->inputType('daterange')
				->exportable(false),
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
				->inputType('textarea')
				->exportable(false),
			DataStructure::field('richtext')
				->name('Rich Text Example')
				->inputType('richtext')
				->exportable(false),
			DataStructure::field('image')
				->name('Image Example')
				->inputType('image_simple')
				->searchable(false)
				->orderable(false)
				->exportable(false),
			DataStructure::field('image_multiple')
				->name('Image Multiple Example')
				->inputType('image_multiple')
				->searchable(false)
				->orderable(false)
				->exportable(false),
			DataStructure::field('file')
				->name('File Example')
				->inputType('file')
				->searchable(false)
				->orderable(false)
				->exportable(false),
			DataStructure::field('file_multiple')
				->name('File Multiple Example')
				->inputType('file_multiple')
				->searchable(false)
				->orderable(false)
				->exportable(false),
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
				->inputType('map')
				->exportable(false),

		]);
	}

	public function dataTableRoute(){
		return route('admin.example.datatable');
	}

	public function batchDeleteRoute(){
		return route('admin.example.delete');
	}

	public function exportRoute(){
		return route('admin.example.export');
	}	

	//public function customFilter($context){
	//	$searched_field = $this->getSearchField('field_name');
	//	return $context;
	//}

	public function model(){
		return new Example;
	}

	public function transformer(){
		return new ExampleTransformer;
	}
}