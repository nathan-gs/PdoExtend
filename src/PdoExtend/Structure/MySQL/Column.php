<?php

namespace PdoExtend\Structure\MySQL;

use PdoExtend\Structure;

class Column implements Structure\ColumnInterface {
    
    private $connection;
    private $name;


    public function __construct(\PDO $connection, $name) {
        $this->connection = $connection;
    }

    public function getName() {
        return $this->name;
    }

    public function __toString() {
        return $this->getName();
    }
}
