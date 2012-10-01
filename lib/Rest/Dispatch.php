<?php

namespace CWX\Crust\Rest;

use CWX\Crust\Core\Dispatch as BaseDispatch,
    CWX\Crust\Db\Manager,
    CWX\Crust\Db\Table,
    CWX\Crust\Request\Request;

// Ye olde database discovery mechanism
// This extends Dispatch to become a class capable
// of generating RequestHandlers for stuff in the
// database that we want to publicize
class Dispatch extends BaseDispatch {
    protected $manager;

    public function setDbManager(Manager $manager) {
        $this->manager = $manager;

        $tables = $manager->getTables();
        $pool = $this->getHandlerPool();

        // The index handler provides a meta-resource, allowing
        // reflection on the tables as resources to be inspected
        $indexHandler = new IndexHandler();
        $indexHandler->setDbManager($manager);

        $pool->add($indexHandler);

        $tables->map(function (Table $table) use ($pool) {
            // EntityHandler is of course the 'star of the show'
            // and allows GET/PUT/DELETE access to our entities
            $handler = new EntityHandler();

            // SetHandler deals with things not addressed to a single
            // entity, but a set of them. Adds reflection of table
            // content through a GET and allows the addition of new
            // entities to the set through POST
            $index = new SetHandler();

            $handler->setTable($table);
            $index->setTable($table);

            $pool->add($handler)->add($index);
        });
    }
}
