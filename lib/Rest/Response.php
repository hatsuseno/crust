<?php

namespace CWX\Crust\Rest;

use CWX\Crust\Response\Response as BaseResponse;

class Response extends BaseResponse {
    public function init() {
        $this->setHeader('Content-Type', 'application/json');
    }
}
