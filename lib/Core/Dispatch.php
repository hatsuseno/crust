<?php

namespace CWX\Crust\Core;

use CWX\Crust\Request\Request,
    CWX\Crust\Request\Handler,
    CWX\Crust\Response\NotFoundResponse,
    CWX\Crust\Response\ServerErrorResponse,
    CWX\Crust\Core\Collection;

abstract class Dispatch {
    private $handlerPool;

    public function __construct() {
        $this->handlerPool = new Collection();
    }

    public function addHandler(Handler $handler) {
        $this->handlerPool->add($handler);

        return $this;
    }

    public function getRequestHandler(Request $request) {
        return $this->handlerPool->iterUntil(
            function(Handler $handler) use ($request) {
                return $handler->match($request);
            },
            function($x) { return $x instanceof Handler; }
        );
    }

    public function getHandlerPool() {
        return $this->handlerPool;
    }
}
