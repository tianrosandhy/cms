<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use Language;
use SlugMaster;
use Storage;
use Illuminate\Http\UploadedFile;

class BaseCrudProcess extends BaseProcess
{
	public function __construct($instance=null){
		parent::__construct();
		if($instance){
			$this->mode = 'update';
		}
		else{
			$this->mode = 'create';
		}
		$this->instance = $instance;
		if(method_exists($this, 'setSkeleton')){
			$this->skeleton = $this->setSkeleton();
		}
		else{
			throw new ProcessException('Skeleton must be set in class that extend to BaseCrudProcess with "->setSkeleton()"');
		}
	}

	public function validate(){
		$validator = $this->skeleton->generateValidation($this->mode, $this->instance->getKey());
		if($validator){
			if($validator->fails()){
				throw new ProcessException($validator);
			}
		}
	}

	public function process(){
		//your logic after validation success
		if($this->skeleton->multi_language){
			$skeleton_inputs = $this->skeleton->autoCrudMultiLanguage();
		}
		else{
			$skeleton_inputs = $this->skeleton->autoCrud();
		}

		if(!empty($skeleton_inputs)){
			$inputs = $skeleton_inputs;
			if($this->skeleton->multi_language){
				$inputs = $skeleton_inputs[Language::default()] ?? $skeleton_inputs;
			}


			#DYNAMIC SINGLE MODE
			//create new instance if not exists, but use selected instance if exists
			$instance = $this->instance ?? $this->skeleton->model();
			if($instance instanceof \Illuminate\Database\Eloquent\Builder || $instance instanceof \Illuminate\Database\Query\Builder){
				$instance = $instance->getModel();
			}

			foreach($inputs as $field => $value){
				if($value instanceof UploadedFile){
					//upload dulu filenya, return file path
					$instance->{$field} = $this->handleDataImageUpload($value);
				}
				else{
					$instance->{$field} = $value;
				}
			}
			$instance->save();

			#DYNAMIC MULTI LANGUAGE MODE
			if(method_exists($instance, 'translatorInstance')){
				#clear translate data setiap kali insert/update data
				$instance->clearTranslate();
				foreach(Language::available() as $lang => $langname){
					$trans = $instance->translatorInstance();
					$trans->lang = $lang;
					$inputs = $skeleton_inputs[$lang] ?? [];
					$added = 0;
					foreach($inputs as $field => $value){
						$trans->{$field} = $value;
						$added++;
					}
					//kalau gaada field yg ditambah, gausa save data translate
					if($added > 0){
						$trans->save();
					}
				}
			}

			if(method_exists($instance, 'slugTarget') && $this->request->slug_master){
				//store current slug master to 
				$slug_instance = SlugMaster::insert($instance, $this->request->slug_master);
			}

			if(method_exists($this, 'afterCrud')){
				$this->afterCrud($instance);
			}

		}

		// if you have another logic for storing data that doesnt cover by Skeleton, you can define them here.
	}

	public function revert(){
		//your logic when validation or process failed to running
	}

	public function handleDataImageUpload($file){
		$filename = $file->getClientOriginalName();
		$extension = $file->getClientOriginalExtension();
		$nameonly = str_replace('.'.$extension, '', $filename);

		//check if file already exists
		$check_exists = Storage::exists('upload'.'/'.$nameonly.'.'.$extension);
		if($check_exists){
			$stored_name = $nameonly.'-'.substr(sha1(rand(1, 10000)), 0, 10).'.'.$extension;
		}
		else{
			$stored_name = $nameonly.'.'.$extension;
		}

		$file->storeAs('upload', $stored_name);
		return 'upload/' . $stored_name;
	}
}