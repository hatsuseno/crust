<?php

namespace CWX\Crust\Rest;

use CWX\Crust\Core\Dispatch as BaseDispatch,
    CWX\Crust\Db\Manager,
    CWX\Crust\Db\Table,
    CWX\Crust\Request\Request;

class Dispatch extends BaseDispatch {
    protected $manager;

    public function setDbManager(Manager $manager) {
        $this->manager = $manager;

        $tables = $manager->getTables();
        $pool = $this->getHandlerPool();

        $indexHandler = new IndexHandler();
        $indexHandler->setDbManager($manager);

        $pool->add($indexHandler);

        $tables->map(function (Table $table) use ($pool) {
            $handler = new EntityHandler();
            $index = new SetHandler();

            $handler->setTable($table);
            $index->setTable($table);

            $pool->add($handler)->add($index);
        });
    }
}
