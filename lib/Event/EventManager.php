<?php

namespace CWX\Crust\Event;

use CWX\Crust\Listener\Pool;

class EventManager {
    protected $listenerPool = null;

    public function __construct(Pool $pool = null) {
        $this->listenerPool = is_null($pool) ? new Pool() : $pool;
    }

    public function dispatch(Event $event) {
        $eventType = get_class($event);
        $processed = false;

        while($eventType) {
            $processed = $this->getPool()->get($eventType)->mapUntil(
                function ($listener) use ($event) { return $listener($event); },
                function ($retval) { return $retval === true; }
            );

            if($processed)
                break;

            $eventType = get_parent_class($eventType);
        }

        return $processed;
    }

    public function on($eventType, $listener) {
        $this->getPool()->get($eventType)->add($listener);
    }

    public function getPool() {
        return $this->listenerPool;
    }
}
