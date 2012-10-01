<?php

namespace CWX\Crust\Request;

use CWX\Crust\Event\Event,
    CWX\Crust\Request\Request;

// Old bits from the finished, though unused, Event manager
// chain. Not sure if it's worth keeping around.
// TODO: decide above
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
