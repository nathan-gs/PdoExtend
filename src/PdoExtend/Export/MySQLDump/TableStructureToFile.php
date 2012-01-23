<?php

namespace PdoExtend\Export\MySQLDump;

class TableStructureToFile {
    private $database;
    private $username;
    private $password;
    private $mysqlDumpPath;
    
    public function __construct($username, $password, $database, $mysqlDumpPath = '') {
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->mysqlDumpPath = $mysqlDumpPath;
    }

    public function export($table, $file) {
        exec($this->mysqlDumpPath.'mysqldump -u' . $this->username . ' -p' . quotemeta($this->password) . ' ' . $this->database . ' ' . $table . ' --no-data --create-options --disable-keys --lock-tables --skip-add-drop-table --skip-comments  > "' . $filename . '"');
    }

}