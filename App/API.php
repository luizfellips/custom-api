<?php

namespace App;

class API
{

    private array $url;
    private string $service;
    private string $method;
    private ?int $id;

    /**
     * the constructor will set the service, method and an id, if there is one being specified in the URL variable.
     */
    public function __construct(string $url)
    {
        $this->url = explode('/', $url);
        if ($this->url[0] === 'api') {
            array_shift($this->url);
            $this->service = 'App\Services\\' . ucfirst($this->url[0] . 'Service');
            $this->id = $this->url[1];
            $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        }
    }

    /**
     * This will execute the API which will go through these steps: 
     * create a new service,
     * call method from created service, 
     * pass array of parameters for the method containing the id.
     */
    public function execute()
    {
        //if service and method are not set, throw 404
        if (!$this->service || !$this->method) {
            http_response_code(404);
            echo json_encode(array('status' => 'error', 'data' => 'Endpoint not found'), JSON_UNESCAPED_UNICODE);
            exit;
        }
        try {
            /**
             * create a new service
             * call method from created service, 
             * pass array of parameters for the method containing the id
             */
            $response = call_user_func_array(array(new $this->service, $this->method), array($this->id));
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
