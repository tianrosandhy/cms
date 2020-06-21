<?php
namespace App\Core\Components;

use App\Core\Http\Skeleton\BaseSkeleton;
use App\Core\Components\DataTable\DataTableProcessor;

class DataTable
{
	use DataTableProcessor;

	public 
		$skeleton,
		$request;

	public function __construct(){
		$this->request = request();
	}

	public function setSkeleton(BaseSkeleton $skeleton){
		$this->skeleton = $skeleton;
		return $this;
	}

	public function assets(){
		return view('core::components.datatable.asset', [
			'skeleton' => $this->skeleton
		]);
	}

	public function tableView(){
		return view('core::components.datatable.table-view', [
			'skeleton' => $this->skeleton
		]);
	}



}