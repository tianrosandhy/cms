<?php
namespace App\Core\Components\DataTable;

use App\Core\Exceptions\DataTableException;

trait DataTableProcessor
{

	public function process(){
		try{
			$this->validateRequest();
			$this->handleProcess();
		}catch(\Exception $e){
			return [
				'error' => $e->getMessage()
			];
		}
		return [
			'draw' => $this->request->draw,
			'data' => $this->data,
			'recordsFiltered' => $this->recordsFiltered,
			'recordsTotal' => $this->recordsTotal
		];
	}

	public function validateRequest(){
		//prepare variabel disini aja sekalian
		$this->draw = $this->request->draw;
		$this->columns = $this->request->columns;
		$this->start = $this->request->start;
		$this->length = $this->request->length;

		$validator = $this->request->validate([
			'draw' => 'required|numeric',
			'columns' => 'required|array',
			'order' => 'array',
			'start' => 'required',
			'length' => 'required',
		]);
	}

	public function handleProcess(){
		//prepare variable utk search array & sort condition
		$this->prepareDataTableVariables();
		$this->getDataByRequest();

		$output = [];
		foreach($this->raw_data as $row){
			$rf = $this->skeleton->rowFormat($row);
			if(!empty($rf)){
				$output[] = $rf;
			}
		}

		$this->data = $output;
	}

	public function prepareDataTableVariables(){
		$fallback_order = null;
		$this->filter = [];
		foreach($this->request->columns as $idx => $col){
			$this->response_format[$col['data']] = null;
			if(isset($col['search']['value'])){
				$this->filter[$col['data']] = $col['search']['value'];
			}
			if(empty($fallback_order) && $col['orderable'] <> 'false'){
				$fallback_order = $col['data'];
			}
		}

		if(isset($this->request->order[0]['column'])){
			$cindex = $this->request->order[0]['column'];
			$order_by = $this->request->columns[$cindex]['data'] ?? $fallback_order;
		}
		else{
			$order_by = $fallback_order;
		}
		$order_dir = $this->request->order[0]['dir'] ?? 'desc';
		$this->order_by = $order_by;
		$this->order_dir = $order_dir;
	}

	public function getDataByRequest(){
		try{
			$data = $this->skeleton->model();
		}catch(\Exception $e){
			throw new DataTableException('Failed to get data from table. Make sure you have already migrate the module');
		}

		$without_filter = $data;

		if(!empty($this->filter)){
			foreach($this->filter as $column => $value){
				//custom filtering diset lagi nanti
				$data = $data->where($column, 'like', '%'.trim($value).'%');
			}
		}

		if(method_exists($this->skeleton, 'customFilter')){
			$data = $this->skeleton->customFilter($data);
			$without_filter = $this->skeleton->customFilter($without_filter);
		}

		$data = $data->orderBy($this->order_by, $this->order_dir);
		$data = $data->skip($this->start);
		$data = $data->take($this->length);
		$this->recordsFiltered = $without_filter->count();
		$this->recordsTotal = $without_filter->count();
		$this->raw_data = $data->get();
	}


}