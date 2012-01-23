<?php

namespace PdoExtend\Structure\MySQL;

use PdoExtend\Structure;

class Database implements Structure\DatabaseInterface {

    private $connection;

    /**
     * @var \Iterator
     */
    private $tables;

    public function __construct(\PDO $connection) {
        $this->connection = $connection;

        $sql = 'SHOW TABLES;';
        $statement = $this->connection->query($sql);

        $this->tables = new \ArrayIterator(\array_values($statement->fetchAll(\PDO::FETCH_ASSOC)));
    }

    /**
     * @return Table
     */
    public function current() {
        return new Table($this->connection, $this->key());
    }

    public function key() {
        return $this->tables->key();
    }

    public function next() {
        $this->tables->next();
    }

    public function rewind() {
        $this->tables->rewind();
    }

    public function valid() {
        return $this->tables->valid();
    }

    public function hasTable($table) {
        return isset($this->tables[$table]);
    }

}