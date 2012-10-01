<?php

require '../init.php';

use CWX\Crust\Db\Manager as DbManager,
    CWX\Crust\Rest\Dispatch,
    CWX\Crust\Request\Request;

$dbManager = new DbManager(
    new PDO('dsn', 'user', 'pass')
);

$dispatch = new Dispatch();
$dispatch->setDbManager($dbManager);

$response = Request::instantiateCurrentRequest()->process($dispatch);

$response->execute();
