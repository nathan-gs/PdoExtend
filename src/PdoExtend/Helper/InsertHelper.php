<?php

namespace PdoExtend\Helper;

class InsertHelper {
    static public function getInsertOnDuplicateSql($tableName, array $fields) {
        $fieldCount = count($fields);
        $sql = 'INSERT INTO `'.$tableName.'` (';
        {
            $i = 0;
            foreach ($fields as $field) {
                $sql .= '`' . $field . '`';
                $i ++;
                if ($i < $fieldCount)
                    $sql .= ', ';
            }
        }
        $sql .= ') VALUES (';
        {
            $i = 0;
            foreach ($fields as $field) {
                $sql .= ':' . $field;
                $i ++;
                if ($i < $fieldCount)
                    $sql .= ', ';
            }
        }
        $sql .= ')';
        $sql .= ' ON DUPLICATE KEY UPDATE ';{
            $i = 0;
            foreach ($fields as $field) {
                $i ++;
                if($field == 'id') {
                    continue;
                }
                $sql .= '`' . $field . '`=:'. $field. ' ';
                if ($i < $fieldCount)
                    $sql .= ', ';
            }
        }
   
        return $sql;
    }
    
    public static function getLastInsertId(\PDO $pdoConnection) {
        return $pdoConnection->lastInsertId();
//        
//        $r = $pdoConnection->query('SELECT LAST_INSERT_ID()');
//
//        return $r->fetchColumn();
    }
}