<?php

namespace CWX\Crust\Rest;

use CWX\Crust\Request\Handler as BaseHandler,
    CWX\Crust\Request\Request,
    CWX\Crust\Response\NotFoundResponse,
    CWX\Crust\Db\Manager,
    CWX\Crust\Db\Table;

class IndexHandler extends BaseHandler {
    protected $manager;

    public function setDbManager(Manager $manager) {
        $this->manager = $manager;

        return $this;
    }

    public function match(Request $request) {
        return strlen($request->getPath()) === 0 ? $this : false;
    }

    public function buildResponse(Request $request) {
        return $request->getMethod() === 'GET' ? $this->get($request) : new NotFoundResponse();
    }

    public function get(Request $request) {
        $response = new IndexResponse();

        $tables = $this->manager->getTables()->map(function(Table $table) {
            return array(
                'name' => $table->getName(),
                'fields' => $table->getFields()->map(function($fieldSpec) {
                    return $fieldSpec;
                })
            );
        });

        $response->setContent(json_encode(array(
            'entity_table' => $tables
        )));

        return $response;
    }
}
