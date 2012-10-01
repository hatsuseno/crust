<?php

namespace CWX\Crust\Rest;

use CWX\Crust\Request\Handler as BaseHandler,
    CWX\Crust\Request\Request,
    CWX\Crust\Response\NotFoundResponse,
    CWX\Crust\Db\Table;

class EntityHandler extends BaseHandler {
    protected $table;

    public function setTable(Table $table) {
        $this->table = $table;

        return $this;
    }

    public function match(Request $request) {
        $path = $request->getPath();

        if(strlen($path) === 0) return false;

        $pathParts = explode('/', $path);

        $nameGuess = array_shift($pathParts);

        if($nameGuess != $this->table->getName())
            return false;

        return is_numeric(array_shift($pathParts)) ? $this : false;
    }

    public function buildResponse(Request $request) {
        list($tableName, $id) = explode('/', $request->getPath());

        switch($request->getMethod()) {
            case 'GET': return $this->get($request, $id);
            case 'DELETE': return $this->delete($request, $id);
            case 'PUT': return $this->put($request, $id);

            default:
                return new NotFoundResponse();
        }
    }

    public function get(Request $request, $id) {
        $response = new EntityResponse();

        $entity = $this->table->getEntity($id);

        return $response->setEntity($entity);
    }

    public function put(Request $request, $id) {
        $pk = $this->table->updateEntity(
            $id,
            $request->getParameter($this->table->getName(), array())
        );

        return $this->get($request, $pk);
    }

    public function delete(Request $request, $id) {
        $response = new Response();

        $pk = $this->table->deleteEntity($id);

        return $response->setOK();
    }
}
