<?php

namespace CWX\Crust\Request;

abstract class Handler {
    abstract public function match(Request $request);
    abstract public function buildResponse(Request $request);
}
