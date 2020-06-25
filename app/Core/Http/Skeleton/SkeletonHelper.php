<?php
namespace App\Core\Http\Skeleton;

use App\Core\Exceptions\SkeletonException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait SkeletonHelper
{
	//utk generate checker datatable
	public function checkerFormat($row, $primary_key='id'){
		return '<input type="checkbox" data-id="'.$row->{$primary_key}.'" name="multi_check['.$row->{$primary_key}.']" class="multichecker_datatable"><span style="color:transparent; position:absolute;">'.$row->{$primary_key}.'</span>';		
	}

	public function switcherFormat($row, $field='is_active', $mode='toggle'){
		if($mode == 'toggle'){
			$table = $row->getTable();
			return view('core::components.input.yesno', [
				'value' => $row->{$field},
				'name' => $field,
				'attr' => [
					'data-id' => encrypt($row->getKey()),
					'data-pk' => encrypt($row->getKeyName()),
					'table' => encrypt($table),
					'field' => encrypt($field),
					'data-table-switch' => 1
				]
			])->render();
		}
		else{
			return $row->field ? '<span class="badge badge-success" title="Active"><i data-feather="check"></i></span>' : '<span class="badge badge-danger" title="Not Active"><i data-feather="x"></i></span>';
		}
	}










	public function modelTableListing(){
		$model = $this->model();
		if($model instanceof Model || $model instanceof Builder){
			if($model instanceof Builder){
				$model = $model->getModel();
			}
			return $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
		}
		throw new SkeletonException('You need to define the model skeleton first');
	}

	public function getTableName(){
		$model = $this->model();
		if($model instanceof Model || $model instanceof Builder){
			if($model instanceof Builder){
				$model = $model->getModel();
			}
			return $model->getTable();
		}
		throw new SkeletonException('You need to define the model skeleton first');
	}

	// generate auto CRUD prepared data by skeleton's data
	public function autoCrud(){
		$table_listing = $this->modelTableListing();
		$table_name = $this->getTableName();

		$post = [];
		foreach($this->output() as $row){
			if(!$row->getHideForm()){
				if(in_array($row->getField(), $table_listing)){
					$post[$row->getField()] = $this->request->{$row->getField()} ?? null;
				}
			}
		}
		return $post;

	}

}