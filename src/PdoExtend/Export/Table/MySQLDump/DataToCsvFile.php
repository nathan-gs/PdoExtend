<?php

namespace PdoExtend\Export\Table\MySQLDump;

use PdoExtend\Structure\TableInterface;

class DataToCsvFile {
    private $database;
    private $username;
    private $password;
    private $mysqlDumpPath;
    private $tmpDir;
    
    public function __construct($username, $password, $database, $mysqlDumpPath = '', $tmpDir = null) {
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->mysqlDumpPath = $mysqlDumpPath;
        if($this->tmpDir != null) {
            $this->tmpDir = $tmpDir;
        } else {
            $this->tmpDir = sys_get_temp_dir().'/'.$database;
        }
    }

    public function export(TableInterface $table, $baseFilename) {
        if (!is_dir($this->tmpDir)) {
            mkdir($this->tmpDir, 0777, true);
            chmod($this->tmpDir, 0777);
        }
        exec('mysqldump -u' . $this->username . ' -p' . quotemeta($this->password) . ' ' . $this->database . ' ' . $table . ' --fields-terminated-by=\\\0 --no-create-info --tab ' . $this->tmpDir);
        exec('mv ' . $this->tmpDir . '/' . $table . '.txt ' . $baseFilename . '-data.csv');
        file_put_contents($baseFilename . '-data.sql',
                $this->getCsvLoad($table . '-data.csv', $table,
                        array_keys($table)));
    }

    private function getCsvLoad($fileToLoad, $table, array $columns) {
        $columnsString = implode('`, `', $columns);
        $str = <<<EOF
SET AUTOCOMMIT=0;
SET UNIQUE_CHECKS=0;
SET FOREIGN_KEY_CHECKS=0;
SET SQL_LOG_BIN=0;

LOAD DATA 
    LOCAL INFILE '$fileToLoad' 
    IGNORE 
    INTO TABLE $table
    FIELDS TERMINATED BY '\\0'
    LINES TERMINATED BY '\\n' 
    (`$columnsString`);

SET SQL_LOG_BIN=1;
SET FOREIGN_KEY_CHECKS=1;
SET UNIQUE_CHECKS=1;
SET AUTOCOMMIT=1;
COMMIT;

EOF;

        return $str;
    }

}