<?php

namespace PdoExtend\Export;

use PdoExtend;
use PdoExtend\Structure\MySQL\Database;
use PdoExtend\Structure\DatabaseInterface;

class DatabaseExportService {

    private $connection;
    private $dumpers = array();
    private $database;

    public function __construct(PdoExtend\Pdo $connection, DatabaseInterface $database, array $dumpers) {
        $this->connection = $connection;
        $this->database = $database;
        foreach ($dumpers as $dump) {
            $this->addTableDumper($dump);
        }
    }
    
    public function addTableDumper(ExportTableToFileInterface $dump) {
        $this->dumpers[] = $dump;
    }

    public function export($toDirectory) {
        $databaseName = $this->connection->getDatabaseName();

        $this->destinationDirectoryDeleteTables($toDirectory);
        
        foreach ($this->database as $tableName => $table) {
            $tableDir = $toDirectory . '/' . $databaseName . '/' . $tableName;
            if (!is_dir($tableDir)) {
                mkdir($tableDir, 0755, true);
            }
            foreach ($this->dumpers as $dumper) {
                $dumper->export($table, $tableDir);
            }
        }
    }
    
    private function destinationDirectoryDeleteTables($path) {
        exec('rm -r ' . $path . '/*');
    }

}
