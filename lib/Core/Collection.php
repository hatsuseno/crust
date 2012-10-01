<?php

namespace CWX\Crust\Core;

// Generic 'collection' implementation. Working with plain PHP
// arrays gets annoying real quickly, especially for (my idea of)
// a proper map function, and some additional fun that can be had.
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

    // This is perhaps the oddest thing in this bit of crapware.
    // This function applies a function to each element of an
    // array, and stops if the 'condition' function returns true,
    // at which point it returns the current computed value
    //
    // By default we implement this as 'intval' (since PHP has no
    // 'boolval' function to cast down to bool, and for most
    // uses this works fine) which causes the first thing cast
    // as a non-zero integer to be returned
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
