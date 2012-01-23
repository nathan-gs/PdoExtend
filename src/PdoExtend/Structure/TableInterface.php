<?php

namespace PdoExtend\Structure;

/**
 * @method ColumnInterface current()
 * @method string key() The column name.
 */
interface TableInterface extends \Iterator {
    
    public function hasColumn($columnName);
    
    public function __toString();
    
}