<?php

namespace PdoExtend\Structure\MySQL;

use PdoExtend\Structure;

class Column implements Structure\ColumnInterface {
    
    private $connection;


    public function __construct(\PDO $connection) {
        
    }


    public function __toString() {
        ;
    }
}
