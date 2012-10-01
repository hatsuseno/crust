<?php

namespace CWX\Crust\Listener;

use CWX\Crust\Core\Collection;

class Pool extends Collection {
    public function get($name) {
        if(!$this->has($name) {
            $this->set($name, new Collection());
        }

        return parent::get($name);
    }
}
