<?php
namespace App\Modules\Notification\Services;

use Log;
use GuzzleHttp\Client;

class Firebase
{
    public function __construct(){
        $this->client = new Client([
            'base_uri' => 'https://fcm.googleapis.com/'
        ]);
    }

    public function send($param=[]){
        return $this->post('fcm/send', $param);
    }




    public function post($url, $param=[]){
        $request_id = $this->recordClientSend('POST', $url, $param);
        return $this->runHttpClient('POST', $url, $param, $request_id);
    }

    public function get($url, $param=[]){
        $request_id = $this->recordClientSend('GET', $url, $param);
        return $this->runHttpClient('GET', $url, $param, $request_id);
    }

    private function recordClientSend($method, $url, $parameters){
        //generate custom request_id hash for log purpose
        $request_id = substr(sha1(uniqid() . time() . rand(1,1000)), 5, 20);
        $info = [
            'request_id' => $request_id,
            'method' => $method,
            'url' => env('ALBEDO_BASE_URL').$url,
            'parameters' => $parameters,
        ];

        Log::info("FCM CLIENT SEND DATA : \n". json_encode($info, JSON_PRETTY_PRINT));
        return $request_id;
    }

    private function runHttpClient($method, $url, $parameters, $request_id='')
    {

        $result = ['status' => false];
        $options = [
            'verify' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'key=' . env('FCM_SERVER_KEY')
            ],
            'json' => $parameters
        ];


        $log_option = $options;
        Log::info("FCM REQUEST ID ".$request_id." DETAIL : \n". json_encode($log_option));

        try {
            $response = $this->client->request($method, $url, $options);
            $data = $response->getBody()->getContents();
            $result['status'] = true;
            $result['data'] = json_decode($data, true);
            if ($response->getStatusCode() === 200) {
                Log::info("FCM SUCCESS RESPONSE " . $request_id ." : \n". json_encode($result['data'])."\n\n\n");
            }
            else{
                Log::info("FCM HTTP ".$response->getStatusCode()." RESPONSE " . $request_id ." : \n". json_encode($result['data'])."\n\n\n");
            }
        } catch (\Exception $e) {
            if(!$e->getResponse()){
                // possibly happened because the problem in internet connection
                $result['error'] = [
                    'code' => 0,
                    'message' => 'Failed to connect to server. Please check your internet connection'
                ];
                return $result;
            }
            $error = (string)$e->getResponse()->getBody(true);
            $response_code = $e->getResponse()->getStatusCode();
            $error_detail = json_decode($error);

            if($error_detail){
                //if error response in json format
                $error_message = $error_detail->message;
                $result['error'] = [
                    'code' => $response_code,
                    'message' => $error_message,
                    'detail' => $error_detail->error
                ];
                Log::info(sprintf("FCM ERROR RESPONSE '.$request_id.' : %s \n\n\n", json_encode($result['error'])));
            }
            else{
                //if error response in RAW format
                Log::info("FCM RAW RESPONSE (Code : ".($e->getResponse()->getStatusCode() ? $e->getResponse()->getStatusCode() : '-').") : \n".$e->getMessage());
            }
        }

        return $result;
    }

}