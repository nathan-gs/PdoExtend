<?php

namespace PdoExtend;

class Pdo extends NestedTransaction {

    private $username;
    private $password;
    private $dsn;

    public function __construct($dsn, $username = null, $passwd = null,
            $options = array(), $pdoStatementClass = 'PdoExtend\PdoStatement') {
        parent::__construct($dsn, $username, $passwd, $options);
        $this->username = $username;
        $this->password = $passwd;
        $this->dsn = $dsn;

        $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(\PDO::ATTR_STATEMENT_CLASS,
                array($pdoStatementClass, array($this)));
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

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDsn() {
        return $this->dsn;
    }

    public function getDatabaseName() {
        $matches = array();
        \preg_match('%dbname=([\w\\\]+)%', $this->getDsn(), $matches);

        return $matches[1];
    }

}