<?php


define('API_KEY','xkeysi8ujnkiuhg456789b-1bae0ac30985d87e1fd65115f83a58b913a314cc758382e715b2906508e031a3-wQzjv3rbNWhGasJ7');

class SendInBlue
{

    public $api_key;
    public $base_url;
    public $timeout;
    public $curl_opts = array();
    public function __construct()
    {
        if (!function_exists('curl_init')) {
            throw new \Exception('Mailin requires CURL module');
        }
        // $this->base_url = $base_url;
        // $this->api_key = $api_key;
        // $this->timeout = $timeout;
    }

    public function do_request()
    {
//        $called_url = $this->base_url."/".$resource;
        $ch = curl_init();
        $auth_header = 'api-key:'.API_KEY;

        $input['sender']=['name'=>"Kishor Pant",'email'=>"alerts@securtrix.com"];
        $input['to']=['name'=>"Pankaj",'email'=>'mr.kishorpant@gmail.com'];
        $input['subject']='Email Testing';
        $input['htmlContent']="Testing Email with HTML Content";

        $content_header = "Content-Type:application/json";
        $timeout = ($this->timeout!='')?($this->timeout):30000; //default timeout: 30 secs
        if ($timeout!='' && ($timeout <= 0 || $timeout > 60000)) {
            throw new \Exception('value not allowed for timeout');
        }
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows only over-ride
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        curl_setopt($ch, CURLOPT_URL, 'https://api.sendinblue.com/v3/smtp/email');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array($auth_header,$content_header));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \RuntimeException('cURL error: ' . curl_error($ch));
        }
        if (!is_string($data) || !strlen($data)) {
            throw new \RuntimeException('Request Failed');
        }
        curl_close($ch);


        echo json_encode($input);
        return json_decode($data, true);
    }

}


$object = new SendInBlue('');
$response_object=$object->do_request();

echo json_encode($response_object);


?>