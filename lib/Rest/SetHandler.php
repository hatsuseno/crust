<?php

namespace CWX\Crust\Rest;

use CWX\Crust\Request\Handler as BaseHandler,
    CWX\Crust\Request\Request,
    CWX\Crust\Response\NotFoundResponse,
    CWX\Crust\Db\Table;

class SetHandler extends BaseHandler {
    protected $table;

    public function setTable(Table $table) {
        $this->table = $table;

        return $this;
    }

    public function match(Request $request) {
        return $request->getPath() === $this->table->getName() ? $this : false;
    }

    public function buildResponse(Request $request) {
        switch($request->getMethod()) {
            case 'GET': return $this->get($request);
            case 'POST': return $this->post($request);

            default:
                return new NotFoundResponse();
        }
    }

    public function get(Request $request) {
        $response = new IndexResponse();

        return $response->setCollection($this->table->getAll());
    }

    public function post(Request $request) {
        $response = new Response();

        $pk = $this->table->newEntity(
            $request->getParameter($this->table->getName())
        );

        return $this->setOK(array('id' => $pk));
    }
}
