<?php

namespace CWX\Crust\Core;

class Collection {
    protected $collection = null;

    public function __construct(array $collection = array()) {
        $this->collection = $collection;
    }

    public function map($function) {
        $collector = array();

        foreach($this->collection as $key => $value) {
            $collector[] = call_user_func($function, $value, $key);
        }

        return $collector;
    }

    public function iterUntil($function, $condition = null) {
        if(!is_callable($condition)) $condition = 'intval';

        foreach($this->collection as $key => $value) {
            $x = call_user_func($function, $value, $key);

            if(call_user_func($condition, $x))
                return $x;
        }

        return false;
    }

    public function get($key, $default = null) {
        return $this->has($key) ? $this->collection[$key] : $default;
    }

    public function set($key, $value) {
        $this->collection[$key] = $value;
        
        return $this;
    }

    public function add($value) {
        $this->collection[] = $value;

        return $this;
    }

    public function has($key) {
        return array_key_exists($key, $this->collection);
    }

    public function clear() {
        $this->collection = array();

        return $this;
    }

    public function count() {
        return count($this->collection);
    }
}
