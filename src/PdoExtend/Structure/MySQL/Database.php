<?php

namespace PdoExtend\Structure\MySQL;

use PdoExtend\Structure;

class Database implements Structure\DatabaseInterface {

    private $connection;
    private $name;

    /**
     * @var \Iterator
     */
    private $tables;

    public function __construct(\PDO $connection, $name = null) {
        $this->connection = $connection;

        if ($name === null) {
            $name = $this->connection->getDatabaseName();
        }
        $this->name = $name;

        $sql = 'SHOW TABLES;';
        $statement = $this->connection->query($sql);

        $this->tables = new \ArrayIterator(\array_map(
                                function ($input) {
                                    return reset($input);
                                }, $statement->fetchAll(\PDO::FETCH_ASSOC)));
    }

    /**
     * @return Table
     */
    public function current() {
        return new Table($this->connection, $this->key());
    }

    public function key() {
        return $this->tables->current();
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
        return array_search($table, $this->tables) ? true : false;
    }

    public function getName() {
        return $this->name;
    }

}