<?php

namespace PdoExtend\Structure;

/**
 * @method TableInterface current()
 * @method string key() The table name.
 */
interface DatabaseInterface extends \Iterator {

    public function hasTable($table);
}
