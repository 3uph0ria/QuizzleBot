<?php

class vk
{
    private $version = '5.103';
    private $url = 'https://api.vk.com/method/';
    private $token = $bot['Token'];
    private $key = $bot['ServerKey'];
    public $data = '';

    public function __construct() {
        $this->data = json_decode(file_get_contents('php://input'), true);
        if ($this->data['type'] == 'confirmation') exit($this->key);
        else {

        }
    }

    public function call($method, $params = []) {
        $params['access_token'] = $this->token;
        $params['v'] = $this->version;

        $url = $this->url.$method.'?'.http_build_query($params);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($json, true);
        return $response['response'];
    }

    public function send($peer_id, $message, $attachments = []) {
        return $this->call('messages.send', [
            'random_id' => rand(),
            'peer_id' => $peer_id,
            'disable_mentions' => 1,
            'dont_parse_links' => 1,
            'message' => $message,
            'read_state' => 1,
            'attachment' => $attachments,
        ]);
    }

    public function request($method,$params=array()){
        $url = 'https://api.vk.com/method/'.$method;
        $params['access_token']= "1fad858b7317f525fde845597b031a85c24466b239c128e3e13bc2445528ccadbce573e620462929a9a99";
        $params['v']= "5.81";
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type:multipart/form-data"
            ));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $result = json_decode(curl_exec($ch), True);
            curl_close($ch);
        } else {
            $result = json_decode(file_get_contents($url, true, stream_context_create(array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($params)
                )
            ))), true);
        }
        if (isset($result['response']))
            return $result['response'];
        else
            return $result;
    }

    public function RequestManagerPhoto($peer_id, $message)
    {
        $this->send($peer_id, '', $message);
    }
}
