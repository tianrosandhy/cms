<?php
namespace App\Core\Http\Process;

use App\Core\Exceptions\ProcessException;
use App\Core\Exceptions\DataTableException;
use Str;

class BaseProcess{

	public $type = 'http'; //default request type
	public 
		$config = [],
		$http_code = 200,
		$response_type = 'success',
		$data = null;

	public function __construct(){
		$this->request = request();
		$this->config = $this->config();
	}

	// dynamic property set
	public function __call($name, $arguments){
		$method = substr($name, 0, 3);
		if(in_array($method, ['get', 'set'])){
			$prop = substr($name, 3);
			$prop = Str::snake($prop);

			if($method == 'get' && property_exists($this, $prop)){
				return $this->{$prop};
			}
			if($method == 'set' && isset($arguments[0])){
				$this->{$prop} = $arguments[0];
			}
			return $this;
		}
	}

	public function type($process_type=null){
		$available_process_type = ['http', 'ajax', 'datatable'];
		if(in_array(strtolower($process_type), $available_process_type)){
			$this->type = strtolower($process_type);
		}
		return $this;
	}

	public function handle(){
		try{
			if(method_exists($this, 'validate')){
				$this->validate();
			}
			$this->data = $this->process();
		}catch(ProcessException | DataTableException $e){
			if(method_exists($e, 'getCode')){
				$this->setHttpCode($e->getCode());
			}
			$this->setErrorMessage($e->getMessage());
			if(method_exists($this, 'revert')){
				$this->revert();
			}
			return $this->generateResponse();
		}

		return $this->generateResponse();
	}


	private function setHttpCode($http_code = 200){
		if($http_code <> 200){
			$this->response_type = 'error';
		}
		else{
			$this->response_type = 'success';
		}
		if($http_code == 0){
			$http_code = 500;
		}
		$this->http_code = $http_code;
	}


	// response management
	private function generateResponse(){
		if($this->type == 'http'){
			return $this->generateHttpResponse();
		}
		if($this->type == 'ajax'){
			return $this->generateAjaxResponse();
		}
		if($this->type == 'datatable'){
			return $this->generateDatatableResponse();
		}
	}

	private function generateHttpResponse(){
		if($this->response_type == 'error'){
			return $this->getErrorRedirectTarget()->with(['error' => $this->getErrorMessage()])->withInput();
		}
		else{
			return $this->getSuccessRedirectTarget()->with(['success' => $this->getSuccessMessage()]);
		}
	}

	private function generateAjaxResponse(){
		return response()->json([
			'type' => $this->response_type,
			'message' => $this->response_type == 'success' ? $this->getSuccessMessage() : null,
			'data' => $this->data ?? null,
			'error' => $this->response_type == 'error' ? $this->getErrorMessage() : [],
			'redirect' => $this->config['success_redirect_target'] ?? null
		], $this->http_code);
	}

	private function generateDatatableResponse(){
		return response()->json($this->data, $this->http_code);
	}




	// property getter and setter

	public function setErrorMessage($err){
		$this->config['error_message'] = $err;
		return $this;
	}
	public function getErrorMessage(){
		return $this->config['error_message'] ?? ['Sorry, we cannot process your request.'];
	}

	public function setSuccessMessage($msg){
		$this->config['success_message'] = $msg;
		return $this;
	}
	public function getSuccessMessage(){
		return $this->config['success_message'] ?? ['Your data has been saved.'];
	}

	public function setErrorRedirectTarget($target){
		$this->config['error_redirect_target'] = $target;
		return $this;
	}
	public function getErrorRedirectTarget(){
		return isset($this->config['error_redirect_target']) ? redirect($this->config['error_redirect_target']) : redirect()->back();
	}

	public function setSuccessRedirectTarget($target){
		$this->config['success_redirect_target'] = $target;
		return $this;
	}
	public function getSuccessRedirectTarget(){
		return isset($this->config['success_redirect_target']) ? redirect($this->config['success_redirect_target']) : redirect()->back();
	}


}