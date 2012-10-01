<?php

namespace CWX\Crust\Request;

// This could just as well be an interface.
// TODO: refactor into interface, or document why it shouldn't be.
abstract class Handler {
    abstract public function match(Request $request);
    abstract public function buildResponse(Request $request);
}
