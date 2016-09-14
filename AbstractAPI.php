<?php

/**
 * Class API
 * Handles all the parsing of the request and the return of the json response
 * Classes that extends this class should only implements endpoints
 */
abstract class AbstractAPI
{
    /**
     * @var string
     * HTTP method of the request, either GET, POST, DELETE, PUT
     */
    protected $entryMethod = '';

    /**
     * @var string
     * The entity requested. eg: /users
     */
    protected $endPoint = '';

    /**
     * @var string
     * An optionnal information to handle specific actions on entities . eg: /users/playlist
     */
    protected $endPointAction = '';

    /**
     * @var array
     * additionnal params from the request  eg: users/<id>
     */
    protected $args = array();

    /**
     * API constructor.
     * @param $request
     * @throws Exception
     */
    public function __construct($request)
    {
        header("Content-Type: application/json");

        $this->args = explode('/', rtrim($request, '/'));
        $this->endPoint = array_shift($this->args);
        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->endPointAction = array_shift($this->args);
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }

        switch ($this->method) {
            case 'DELETE':
            case 'POST':
                $this->request = $this->sanitizeInput($_POST);
                break;
            case 'GET':
                $this->request = $this->sanitizeInput($_GET);
                //other stuff
                break;
            case 'PUT':
                $this->request = $this->sanitizeInput($_GET);
                //use file_get_contents("php://input"); to complete this part
                break;
            default:
                $this->_response('Invalid HTTP Method', 405);
                break;
        }
    }

    /**
     * @return string
     * Will call the right method for the requested endPoint
     * Return 404 if no method is found
     */
    public function processEndPointMethod() {
        if (method_exists($this, $this->endPoint)) {
            return $this->_response($this->{$this->endPoint}($this->args));
        }
        return $this->_response("No Endpoint: $this->endPoint", 404);
    }

    /**
     * @param $data
     * @param int $status
     * @return string - Return the json result
     */
    private function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data);
    }


    /**
     * @param $code
     * @return mixed
     * Map HTTP return codes with clear messages
     */
    private function requestStatus($code) {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

    /**
     * @param $input
     * @return array|string
     */
    private function sanitizeInput($input) {
        $cleanResult = array();
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $cleanResult[$key] = $this->sanitizeInput($value);
            }
        } else {
            $cleanResult = trim(strip_tags($input));
        }
        return $cleanResult;
    }
}