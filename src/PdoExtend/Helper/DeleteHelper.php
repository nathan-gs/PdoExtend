<?php

namespace PdoExtend\Helper;

class DeleteHelper {
    
    static public function notIn(\PDO $pdoConnection, $table, array $checkFields, $deleteField = '', $deleteValues = array()) {
        if (count($deleteValues) > 0) {
            $inHelper = new InHelper($table, $deleteValues, \PDO::PARAM_INT);
        }
        
        $sql = 'DELETE FROM `'.$table.'` WHERE 1=1';
        foreach ($checkFields as $field) {
            $sql .= ' AND `'.$field.'` = :'.$field;
        }
        if (count($deleteValues) > 0) {
            $sql .= ' AND `'.$deleteField.'` NOT IN '.$inHelper->getFields();
        }
        
        $deleteStatement = $pdoConnection->prepare($sql);
        if (count($deleteValues) > 0) {
            $deleteStatement = $inHelper->getStatement($deleteStatement);
        }
        return $deleteStatement;
    }

}