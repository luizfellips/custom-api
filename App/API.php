<?php

namespace App;

class API{
    private $service;
    private $method;
    private $url;

    public function __construct($url)
    {
        $this->url = explode('/', $url);
        if($this->url[0] === 'api'){
            array_shift($this->url);
            $this->service = 'App\Services\\' . ucfirst($this->url[0] . 'Service');
            array_shift($this->url);
            $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        }
    }

    public function execute(){
        if(!$this->service || !$this->method){
            http_response_code(404);
            echo json_encode(array('status' => 'error', 'data' => 'Endpoint not found'), JSON_UNESCAPED_UNICODE);
            exit;
        }
        try {
            $response = call_user_func_array(array(new $this->service, $this->method), $this->url);
            http_response_code(200);
            echo json_encode(array('status' => 'success', 'data' => $response));
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}