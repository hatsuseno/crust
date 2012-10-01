<?php

namespace CWX\Crust\Request;

use CWX\Crust\Event\Event,
    CWX\Crust\Request\Request;

class Event extends BaseEvent {
    protected $request;

    public function setRequest(Request $request) {
        $this->request = $request;

        return $this;
    }

    public function getRequest() {
        return $this->request;
    }
}
