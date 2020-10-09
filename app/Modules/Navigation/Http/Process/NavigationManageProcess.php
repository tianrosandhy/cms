<?php
namespace App\Modules\Navigation\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Modules\Navigation\Models\Navigation;
use App\Modules\Navigation\Models\NavigationItem;
use Validator;
use Language;

class NavigationManageProcess extends BaseProcess
{
	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => null, //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$validate = Validator::make($this->request->all(), [
			'group_id' => 'required',
			'type' => 'required',
		], [
			'group_id.required' => 'Invalid request',
			'type.required' => 'Navigation type is required'
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}
	}

	public function process(){
		$this->post = $this->request->all();
		$this->generateTypeConfig();
		$this->stored['url'] = $this->getUrlByType();
		$this->handleSlug();
		$this->handleAdditionalFields();
		if(isset($this->stored['id'])){
			//update
			$instance = NavigationItem::find($this->stored['id']);
			unset($this->stored['id']);
		}
		else{
			//insert
			$instance = new NavigationItem;
		}

		foreach($this->stored as $field => $value){
			$instance->{$field} = $value;
		}
		
		$instance->save();
		$this->storeLanguageData($instance);
		return $instance;
	}

	protected function storeLanguageData($instance){
		if(method_exists($instance, 'translatorInstance')){
			$instance->clearTranslate();
			foreach(Language::available(true) as $code => $lang){
				$lang_instance = $instance->translatorInstance();
				$lang_instance->lang = $code;
				//cukup simpen titlenya aja, sisanya ga wajib disimpen kok krn yg kepake hanya di data utama
				$lang_instance->group_id = $instance->group_id;
				$lang_instance->title = $this->request->title[$code] ?? $instance->title;
				$lang_instance->save();
			}
		}
	}



	protected function generateTypeConfig(){
		$typelist = config('module-setting.navigation.action_type');
		$used = 'no action';
		if(isset($this->post['type'])){
			if(isset($typelist[$this->post['type']])){
				$used = $this->post['type'];
			}
		}

		$this->menu_config = $typelist[$used];
		$this->stored['type'] = $used;
	}
	
	protected function getUrlByType(){
		$url = $this->menu_config['url'];
		if(strlen($this->post['url']) > 0 && $this->post['type'] == 'url'){
			$url = $this->post['url'];
		}

		if(isset($this->menu_config['route_prefix']) && isset($this->post['slug']['site'])){
			$url = $this->post['slug']['site'];
		}
		return $url;
	}

	

	protected function handleSlug(){
		$slug_for_saved = isset($this->post['slug'][$this->post['type']]) ? $this->post['slug'][$this->post['type']] : null;
		if(is_array($this->post['title'])){
			$this->stored['title'] = $this->post['title'][def_lang()] ?? '';
		}
		else{
			$this->stored['title'] = $this->post['title'] ?? '';
		}
		if($slug_for_saved){
			$this->stored['slug'] = $slug_for_saved;
		}
		else{
			$this->stored['slug'] = null;
		}
	}

	protected function handleAdditionalFields(){
		$this->stored['group_id'] = $this->post['group_id'];
		$this->stored['new_tab'] = $this->post['new_tab'];
		if(isset($this->post['parent'])){
			$this->stored['parent'] = $this->post['parent'];
		}
		if(isset($this->post['navigation_item_id'])){
			$this->stored['id'] = $this->post['navigation_item_id'];
		}
		else{
			//ini cuma berlaku saat insert aja
			$this->stored['sort_no'] = 999;
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