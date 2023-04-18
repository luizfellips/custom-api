<?php

namespace App;

class API
{
    private $url;

    public function __construct($url)
    {
        $this->url = explode('/', $url);
    }

    public function execute()
    {
        if (!strtolower($_SERVER['REQUEST_METHOD']) || !('App\Services\\' . ucfirst($this->url[1] . 'Service'))) {
            http_response_code(404);
            echo json_encode(array('status' => 'error', 'data' => 'Endpoint not found'), JSON_UNESCAPED_UNICODE);
            exit;
        }
        try {
            http_response_code(200);
            echo json_encode(array('status' => 'success', 'data' => call_user_func_array(
                array(
                    new ('App\Services\\' . ucfirst($this->url[1] . 'Service')),
                    strtolower($_SERVER['REQUEST_METHOD'])
                ),
                array($this->url[2])
            )));
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}
