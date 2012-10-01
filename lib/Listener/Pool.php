<?php

namespace CWX\Crust\Listener;

use CWX\Crust\Core\Collection;

// This extension of the plain collection is only there
// because sometimes I need a collection that auto-instantiates
// on request, and sometimes I don't.
class Pool extends Collection {
    public function get($name) {
        if(!$this->has($name) {
            $this->set($name, new Collection());
        }

        return parent::get($name);
    }
}
