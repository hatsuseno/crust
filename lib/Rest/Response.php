<?php

namespace CWX\Crust\Rest;

use CWX\Crust\Response\Response as BaseResponse;

class Response extends BaseResponse {
    public function init() {
        $this->setHeader('Content-Type', 'application/json');
    }

    public function setData(array $data) {
        return $this->setContent(json_encode($data));
    }

    public function setEntity($entity) {
        return $this->setData(array('entity' => $entity));
    }

    public function setCollection(array $entities) {
        return $this->setData(array('entities' => $entities));
    }

    public function setMetaEntities(array $tables) {
        return $this->setData(array('meta_entities' => $tables));
    }

    public function setOK($message = '') {
        return $this->setData(array(
            'success' => true,
            'message' => $message
        ));
    }
}
