<?php

namespace CWX\Crust\Event;

class Event {
    protected $params;

    public function __construct(array $params = array()) {
        $this->params = $params;
    }

    public function getParameters() {
        return $this->parameters;
    }
}
