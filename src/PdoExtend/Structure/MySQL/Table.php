<?php

namespace PdoExtend\Structure\MySQL;

use PdoExtend\Structure;

class Table implements Structure\TableInterface {

    private $connection;
    private $tableName;

    /**
     * @var \Iterator
     */
    private $columns;

    public function __construct(\PDO $connection, $tableName) {
        $this->connection = $connection;
        $this->tableName = $tableName;

        $sql = 'DESCRIBE '.$this->getName().';';
        $statement = $this->connection->query($sql);
        $this->columns = new \ArrayIterator(\array_values($statement->fetchAll(\PDO::FETCH_ASSOC)));
    }
    
    public function getName() {
        return $this->tableName;
    }

    /**
     * @return Table
     */
    public function current() {
        return new Column($this->connection, $this->key());
    }

    public function key() {
        return $this->columns->current();
    }

    public function next() {
        $this->columns->next();
    }

    public function rewind() {
        $this->columns->rewind();
    }

    public function valid() {
        return $this->columns->valid();
    }

    public function hasColumn($columnName) {
        return isset($this->columns[$columnName]);
    }

    public function __toString() {
        return $this->getName();
    }
}