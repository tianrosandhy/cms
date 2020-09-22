<?php
namespace App\Modules\Notification\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Presenters\NotificationIndexPresenter;
use App\Modules\Notification\Presenters\NotificationCrudPresenter;
use App\Modules\Notification\Http\Process\NotificationDatatableProcess;
use App\Modules\Notification\Http\Process\NotificationCrudProcess;
use App\Modules\Notification\Http\Process\NotificationDeleteProcess;
use NotificationInstance;

class NotificationController extends BaseController
{
	public function index(){
		return (new NotificationIndexPresenter)->render();
	}

	public function datatable(){
		return (new NotificationDatatableProcess)
			->type('datatable')
			->handle();
	}

	public function create(){
		$data = new Notification;
		return (new NotificationCrudPresenter($data))->render();
	}

	public function store(){
		$this->request->validate([
			'title' => 'required',
			'content' => 'required'
		]);
		$blast = NotificationInstance::blast($this->request->title, $this->request->content, $this->request->image);
		return redirect()->route('admin.notification.index')->with('success', 'Notification has been sent');
	}

	public function edit($id){
		$data = Notification::findOrFail($id);
		return (new NotificationCrudPresenter($data))->render();
	}

	public function update($id){
		$data = Notification::findOrFail($id);
		return (new NotificationCrudProcess($data))
			->type('http')
			->handle();
	}
	
	public function delete($id=null){
		return (new NotificationDeleteProcess)
			->setModel(new Notification)
			->setId($id)
			->type('ajax')
			->handle();
	}

}