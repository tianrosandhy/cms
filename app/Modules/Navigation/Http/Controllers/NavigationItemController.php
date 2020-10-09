<?php
namespace App\Modules\Navigation\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Navigation\Models\Navigation;
use App\Modules\Navigation\Models\NavigationItem;
use App\Modules\Navigation\Presenters\NavigationManagePresenter;
use App\Modules\Navigation\Http\Process\NavigationManageProcess;
use App\Modules\Navigation\Http\Process\NavigationReorderProcess;
use NavigationInstance;

class NavigationItemController extends BaseController
{

	public function manage($id){
		$data = Navigation::findOrFail($id);
		$presenter = new NavigationManagePresenter($data);
		return $presenter->render();
	}

	public function storeManaged($id){
		$data = Navigation::findOrFail($id);
		return (new NavigationManageProcess($data))
			->type('http')
			->handle();
	}

	public function getEditForm($navid=0){
		$navigation = NavigationItem::findOrFail($navid);
		$data = $navigation->group;
		return view('navigation::partials.navigation-item-form', compact(
			'data',
			'navigation'
		))->render();
	}

	public function reorder($id){
		$data = Navigation::findOrFail($id);
		$order_data = json_decode($this->request->data, true);
		if(!$order_data){
			abort(400);
		}

		return (new NavigationReorderProcess)
			->setOrderData($order_data)
			->type('ajax')
			->handle();
	}

	public function refresh($id){
		$data = Navigation::findOrFail($id);

		$structure = NavigationInstance::setData($data)->generateStructure();
		return view('navigation::partials.navigation-item-list', compact(
			'data',
			'structure'
		))->render();
	}

	public function deleteItem($id){
		$data = NavigationItem::findOrFail($id);
		//cek peranakannya dulu. anak2nya diset ke parent yg sama spt data saat ini dulu
		$current_parent = $data->parent;
		if($data->children){
			foreach($data->children as $child){
				$child->parent = $current_parent;
				$child->save();
			}
		}
		$data->delete();
		return [
			'type' => 'success',
			'message' => 'Navigation item data has been deleted successfully'
		];
	}

}