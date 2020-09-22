<?php
namespace App\Modules\Notification\Services;

use App\Core\Exceptions\InstanceException;
use App\Core\Services\BaseInstance;
use App\Modules\Notification\Models\NotificationSent;
use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Services\Firebase;
use App\Core\Models\UserPushToken;

class NotificationInstance extends BaseInstance
{

	public function __construct(){
		parent::__construct(new Notification);
	}

	public function blast($title, $message, $image=null, $additional_param = []){
		//list receiver sementara ambil semua dari tabel user push token
		$receiver_collecions = $this->getReceivers();
		$receivers = $receiver_collecions->pluck('push_token')->toArray();

		$body = [
			'title' => $title,
			'body' => $message,
			'click_action' => 1,
			'sound' => 'default',
			'user_id' => request()->get('user')->id ?? null,
		];	

		$fcm_response = $this->createRequest($receivers, $body);

		//kalau ada case response gagal, hapus push token dari database
		$failureDetect = $fcm_response['data']['failure'] ?? 0;
		$results = $fcm_response['data']['results'];
		if($failureDetect > 0){
			$receivers = $this->deleteUnusedPushToken($receivers, $results);
		}

		//store notification data to database
		$this->storeNotificationToDatabase([
			'title' => $title, 
			'content' => $message, 
			'image' => $image ? \Storage::url($image) : null, 
			'response' => $fcm_response,
			'receivers' => $receivers, 
		]);

		return $fcm_response;
	}

	protected function getReceivers(){
		return UserPushToken::where('is_active', 1)->get(['id', 'user_id', 'push_token']);
	}

	protected function createRequest($registration_ids=[], $body){
		$params = [
			'registration_ids' => $registration_ids ?? [],
			'priority' => 'high',
			'delay_while_idle' => true,
			'notification'=> $body,
			'body'=> $body,
			'data' => $body
		];

		$fb = new Firebase;
		return $fb->send($params);
	}

	protected function deleteUnusedPushToken($push_tokens=[], $responses=[]){
		$deleted_list = [];
		foreach($responses as $rindex => $resp){
			if(isset($resp['error'])){
				//delete this push token when return error
				if(isset($push_tokens[$rindex])){
					$deleted_list[] = $push_tokens[$rindex];
					unset($push_tokens[$rindex]);
				}
			}
		}

		if(!empty($deleted_list)){
			//force nonactive
			UserPushToken::whereIn('push_token', $deleted_list)->update([
				'is_active' => 0
			]);
		}

		return array_values($push_tokens);
	}

	protected function storeNotificationToDatabase($param=[]){
		$notif = new Notification;
		$notif->title = $param['title'] ?? null;
		$notif->content = $param['content'] ?? null;
		$notif->image = $param['image'] ?? null;
		$notif->target = 'push_token';
		$notif->fcm_response = isset($param['response']) ? json_encode($param['response']) : null;
		$notif->save();

		$param['receivers'] = $param['receivers'] ?? [];
		if(!empty($param['receivers'])){
			$upt = UserPushToken::whereIn('push_token', $param['receivers'])->get(['user_id', 'push_token']);
			$notif_sent = [];
			foreach($param['receivers'] as $push_token){
				$grab = $upt->where('push_token', $push_token)->first();
				$user_id = $grab->user_id ?? null;
				$notif_sent[] = [
					'notification_id' => $notif->id,
					'user_id' => $user_id,
					'push_token' => $push_token,
					'status' => 1,
					'read_at' => null,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
			}

			if(!empty($notif_sent)){
				NotificationSent::insert($notif_sent);
			}
		}
	}
}