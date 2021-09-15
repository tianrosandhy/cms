<?php
namespace App\Modules\Example\Transformers;

use App\Core\Base\Transformer\BaseTransformer;
use App\Core\Contracts\CanTransform;
use Media;
use Permission;

class ExampleTransformer extends BaseTransformer implements CanTransform
{
    public function transform($row, $mode='datatable'){
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