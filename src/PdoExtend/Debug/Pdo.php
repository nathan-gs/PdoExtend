<?php

namespace PdoExtend\Debug;

class Pdo extends \PdoExtend\Pdo {

    private $queryList = array();

    public function __construct($dsn, $username = null, $passwd = null,
            $options = array()) {
        parent::__construct($dsn, $username, $passwd, $options);
        $this->setAttribute(\PDO::ATTR_STATEMENT_CLASS,
                array('PdoExtend\Debug\PdoStatement', array($this)));
    }

    public function addQuery($sql, $variables = array(), $backtrace = array()) {
        $this->queryList[] = array($sql, $variables, $backtrace, $this->transLevel);
    }

    public function getQueries() {
        return $this->queryList;
    }

}