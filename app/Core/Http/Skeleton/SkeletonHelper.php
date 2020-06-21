<?php
namespace App\Core\Http\Skeleton;

trait SkeletonHelper
{
	//utk generate checker datatable
	public function checkerFormat($row, $primary_key='id'){
		return '<input type="checkbox" data-id="'.$row->{$primary_key}.'" name="multi_check['.$row->{$primary_key}.']" class="multichecker_datatable"><span style="color:transparent; position:absolute;">'.$row->{$primary_key}.'</span>';		
	}
}