<?php

namespace CWX\Crust\Db;

use CWX\Crust\Core\Collection;

class Manager {
    protected $pdo;
    protected $tables;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function query($sql, array $params = array()) {
        $stmt = $this->pdo->prepare($sql);

        if($stmt->execute($params) === false) {
            $error = $stmt->errorInfo();

            throw new \Exception(
                sprintf('Error while querying database (%d: %s)', $error[0], $error[2])
            );
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastInsertedId() {
        return $this->pdo->lastInsertId();
    }

    public function getTables() {
        if($this->tables) return $this->tables;

        $tables = new Collection();

        foreach($this->query('SHOW TABLES') as $table) {
            $table = array_shift($table);
            $tables->add(new Table($table, $this));
        }

        $this->tables = $tables;

        return $this->tables;
    }

    public function getFieldDefinitions($fieldSpec) {
        return array(
            'name' => $fieldSpec['Field'],
            'type' => self::getFieldType($fieldSpec['Type']),
            'nullable' => $fieldSpec['Null'] === 'YES',
            'pk' => $fieldSpec['Key'] === 'PRI'
        );
    }

    protected static function getFieldType($type) {
        if(preg_match('#^(tiny|big)?int#', $type)) return 'int';
        if(preg_match('#^varchar|text#', $type)) return 'string';
        if(preg_match('#^float|double|real|decimal#', $type)) return 'float';
        if(preg_match('#^date|datetime#', $type)) return 'date';

        return null;
    }
}
