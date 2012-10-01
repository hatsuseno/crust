<?php

namespace CWX\Crust\Rest;

use CWX\Crust\Response\Response as BaseResponse;

class Response extends BaseResponse {
    public function init() {
        $this->setHeader('Content-Type', 'application/json');
    }

    public function setEntity($entity) {
        return $this->setContent(json_encode(array(
            'entity' => $entity
        )));
    }

    public function setCollection(array $entities) {
        return $this->setContent(json_encode(array(
            'entities' => $entities
        )));
    }

    public function setOK($message = '') {
        return $this->setContent(json_encode(array(
            'success' => true,
            'message' => $message
        )));
    }
}
