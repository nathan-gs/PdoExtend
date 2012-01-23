<?php

namespace PdoExtend\Helper;
use \RangeException;

class InHelper {

    private $baseName;
    private $fields;
    private $type;

    public function __construct($baseName, array $fields,
            $type = \PDO::PARAM_STR) {
        if(count($fields) == 0) {
            throw new RangeException();
        }
        $this->baseName = $baseName;
        $this->fields = $fields;
        $this->type = $type;
    }

    public function getFields() {
        $count = count($this->fields);
        $sql = ' (';
        for ($i = 0;
                $i < $count;
                $i++) {
            $sql .= ':' . $this->baseName . $i;
            if($i +1 < $count) {
                $sql .= ', ';
            }
        }
        $sql .= ') ';

        return $sql;
    }

    public function getStatement(\PDOStatement $statement) {
        $i = 0;
        foreach ($this->fields as $field) {
            $statement->bindValue(':' . $this->baseName . $i, $field,
                    $this->type);
            $i++;
        }

        return $statement;
    }

}