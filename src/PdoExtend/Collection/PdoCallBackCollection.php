<?php

namespace PdoExtend\Collection;

use iController\Shared\Map\Exception\EntityNotFoundException;

class PdoCallBackCollection extends AbstractCollection implements \Countable {

    private $pdoStatement;
    private $callBack;
    private $count = null;

    public function __construct(\PDOStatement $pdoStatement, $callBack) {
        $this->pdoStatement = $pdoStatement;
        $this->callBack = $callBack;
    }

    public function rewind() {
        $this->pdoStatement->execute();

        parent::rewind();
    }

    protected function fetch() {
        try {
            $row = $this->pdoStatement->fetch(\PDO::FETCH_ASSOC);
            return \call_user_func_array($this->callBack, array($row));
        } catch (EntityNotFoundException $e) {
            return false;
        }
    }

    
    public function count() {
        if($this->count === null) {
            $this->count = $this->pdoStatement->count();
        }
        return $this->count;
    }
}