<?php

namespace CWX\Crust\Request;

use CWX\Crust\Core\Dispatch,
    CWX\Crust\Response\NotFoundResponse,
    CWX\Crust\Core\Collection;

class Request {
    protected $method;
    protected $requestTime;
    protected $path;
    protected $parameters;

    public static function instantiateCurrentRequest() {
        $request = new self();

        $request->setMethod($_SERVER['REQUEST_METHOD']);

        // Lop off both the first and tailing '/' for sanity' sake
        $request->setPath(preg_replace(
            array('#^\/#', '#\/$#'),
            array('', ''),
            $_SERVER['PATH_INFO'])
        );

        $request->setRequestTime(
            \DateTime::createFromFormat('U', $_SERVER['REQUEST_TIME'])
        );

        $inputParams = array();

        // Hack-around for PUT requests, it's body is not automagically evaluated
        // as a hashmap, like POST is.
        if($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $inputParams = json_decode(file_get_contents('php://input'), true);
        }

        $request->setParameters(array_merge($_POST, $_GET, $inputParams));

        return $request;
    }

    public function setMethod($method) {
        $this->method = $method;

        return $this;
    }

    public function setRequestTime(\DateTime $requestTime) {
        $this->requestTime = $requestTime;

        return $this;
    }

    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    public function setParameters(array $params) {
        $this->parameters = new Collection($params);
    }

    public function getMethod() {
        return $this->method;
    }

    public function getRequestTime($fmt = null) {
        return $fmt ? $this->requestTime->format($fmt) : $this->requestTime;
    }

    public function getPath() {
        return $this->path;
    }

    public function getParameter($name, $default = null) {
        return $this->parameters->get($name);
    }

    public function process(Dispatch $dispatch) {
        $handler = $dispatch->getRequestHandler($this);

        if(!$handler) {
            return new NotFoundResponse();
        }

        return $handler->buildResponse($this);
    }
}
