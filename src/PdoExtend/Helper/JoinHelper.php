<?php

namespace PdoExtend\Helper;

class JoinHelper {

    public static function multiToOne($leftTableAlias, $rightTable, $rightConditions, array $fields, $joinType = 'INNER') {
        $fieldCount = count($fields);
        $sql = '';
        $joinedTablePrefix = $leftTableAlias . '_' . $rightTable;
        $sql .= ' ' . $joinType . ' JOIN (';
        {
            $sql .= ' SELECT DISTINCT ';
            $i = 0;
            foreach ($fields as $leftField => $rightField) {
                $i++;
                $sql .= '`' . $rightField . '` AS `' . $rightField . '`';
                if ($i < $fieldCount) {
                    $sql .= ', ';
                }
            }
            $sql .= ' FROM ' . $rightTable;
            $sql .= ' WHERE 1=1 ';
            {
                $sql .= $rightConditions;
            }
        }
        $sql .= ') ' . $joinedTablePrefix;
        $sql .= ' ON (';
        $i = 0;
        foreach ($fields as $leftField => $rightField) {
            $i++;
            $sql .= $leftTableAlias . '.' . $leftField . ' = ' . $joinedTablePrefix . '.' . $rightField;
            if ($i < $fieldCount) {
                $sql .= ' AND ';
            }
        }
        $sql .= ')';

        return $sql;
    }

}