<?php

namespace CWX\Crust\Db;

use CWX\Crust\Core\Collection;

class Table {
    protected $name;
    protected $manager;

    protected $fields;

    public function __construct($name, Manager $manager) {
        $this->name = $name;
        $this->manager = $manager;
    }

    public function getFields() {
        if($this->fields) return $this->fields;

        $fields = new Collection();

        $fieldDefinitions = array_map(
            array($this->manager, 'getFieldDefinitions'),
            $this->manager->query('DESCRIBE ' . $this->name)
        );

        foreach($fieldDefinitions as $definition) {
            $fields->set($definition['name'], $definition);
        }

        $this->fields = $fields;

        return $fields;
    }

    public function getPrimaryKeyField() {
        return $this->getFields()->iterUntil(
            function ($field) { return $field['pk'] ? $field : false; },
            function ($x) { return is_array($x); }
        );
    }

    public function getAll() {
        return $this->manager->query(sprintf(
            "SELECT * FROM `%s`",
            $this->name
        ));
    }

    public function getEntity($pk) {
        $pkField = $this->getPrimaryKeyField();

        $results = $this->manager->query(
            sprintf("SELECT * FROM `%s` AS t WHERE t.`%s` = ?",
                $this->name,
                $pkField['name']
            ),
            array($pk)
        );

        return array_shift($results);
    }

    public function newEntity($data) {
        $results = $this->manager->query(
            sprintf("INSERT INTO `%s` (%s) VALUES (%s)",
                $this->name,
                implode(', ', array_keys($data)),
                implode(', ', array_fill(0, count($data), '?'))
            ),
            array_values($data)
        );

        return $this->manager->getLastInsertedId();
    }

    public function updateEntity($pk, array $data) {
        $pkField = $this->getPrimaryKeyField();
        
        $params = array_merge(array_values($data), array($pk));

        $results = $this->manager->query(
            sprintf("UPDATE `%s` SET %s WHERE `%s`.`%s` = ?",
                $this->name,
                implode(', ', array_map(
                    function($v) {
                        return sprintf('`%s` = ?', $v);
                    },
                    array_keys($data)
                )),
                $this->name,
                $pkField['name']
            ),
            $params
        );

        return $pk;
    }

    public function deleteEntity($pk) {
        $pkField = $this->getPrimaryKeyField();

        $this->manager->query(
            sprintf("DELETE FROM `%s` WHERE `%s`.`%s` = ?",
                $this->name,
                $this->name,
                $pkField['name']
            ),
            array($pk)
        );

        return $pk;
    }

    public function getName() {
        return $this->name;
    }
}
