<?php

namespace PdoExtend;

class Pdo extends NestedTransaction {

    public function __construct($dsn, $username = null, $passwd = null,
            $options = array()) {
        parent::__construct($dsn, $username, $passwd, $options);

        $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(\PDO::ATTR_STATEMENT_CLASS,
                array('PdoExtend\PdoStatement', array($this)));
    }

    
    public function query($statement) {
        try {
            return parent::query($statement);
        } catch (\PDOException $e) {
            throw new Exception\QueryException($statement, $e->getMessage(), $e->getCode(), $e);
        }
    }
    
    public function exec($statement) {
        try {
            return parent::exec($statement);
        } catch (\PDOException $e) {
            throw new Exception\QueryException($statement, $e->getMessage(), $e->getCode(), $e);
        }
    }
}