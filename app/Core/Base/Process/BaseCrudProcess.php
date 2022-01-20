<?php
namespace App\Core\Base\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use Language;
use SlugMaster;
use Storage;
use Illuminate\Http\UploadedFile;
use App\Core\Contracts\CanProcess;

class BaseCrudProcess extends BaseProcess implements CanProcess
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
		if(method_exists($this, 'setStructure')){
			$this->structure = $this->setStructure();
		}
		else{
			throw new ProcessException('Structure must be set in class that extend to BaseCrudProcess with "->setStructure()"');
		}
	}

	public function validate(){
		$validator = $this->structure->generateValidation($this->mode, $this->instance->getKey());
		if($validator){
			if($validator->fails()){
				throw new ProcessException($validator);
			}
		}
	}

	public function process(){
		//your logic after validation success
		if($this->structure->multi_language){
			$structure_inputs = $this->structure->autoCrudMultiLanguage();
		}
		else{
			$structure_inputs = $this->structure->autoCrud();
		}

		if(!empty($structure_inputs)){
			$inputs = $structure_inputs;
			if($this->structure->multi_language){
				$inputs = $structure_inputs[Language::default()] ?? $structure_inputs;
			}


			#DYNAMIC SINGLE MODE
			//create new instance if not exists, but use selected instance if exists
			$instance = $this->instance ?? $this->structure->model();
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
					$inputs = $structure_inputs[$lang] ?? [];
					$added = 0;
					foreach($inputs as $field => $value){
						if($value instanceof UploadedFile){
							//jika berupa file upload, ambil value dari hasil upload di awal saja
							$trans->{$field} = $instance->{$field};
						}
						else{
							$trans->{$field} = $value;
						}
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

		// if you have another logic for storing data that doesnt cover by Structure, you can define them here.
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