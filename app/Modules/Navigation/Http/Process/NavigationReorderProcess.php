<?php
namespace App\Modules\Navigation\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Modules\Navigation\Models\Navigation;
use App\Modules\Navigation\Models\NavigationItem;
use Validator;

class NavigationReorderProcess extends BaseProcess
{

	public function validate(){

	}

	public function process(){
		$iteration = 1;
		foreach($this->order_data as $row){
			$this->reorderData($row, $iteration++);
		}
	}

	public function reorderData($row, $iteration=1, $parent=null){
		$instance = NavigationItem::find($row['id']);
		$instance->sort_no = $iteration;
		$instance->parent = $parent;
		$instance->save();

		if(isset($row['children'])){
			$iter = 1;
			foreach($row['children'] as $child){
				$this->reorderData($child, $iter++, $row['id']);
			}
		}
	}


}