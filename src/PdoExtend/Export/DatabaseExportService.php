<?php

namespace PdoExtend\Export;

use PdoExtend;
use PdoExtend\Structure\MySQL\Database;

class DatabaseExportService {

    private $connection;

    public function __construct(PdoExtend\Pdo $connection) {
        $this->connection = $connection;
    }

    public function export($toDirectory) {
        $databaseName = $this->connection->getDatabaseName();

        $database = new Database($this->connection);
        $tableCsvDump = new MySQLDump\TableDataToCsvFile($this->connection->getUsername(), $this->connection->getPassword(), $this->connection->getDatabaseName());
        $tableStructureDump = new MySQLDump\TableStructureToFile($this->connection->getUsername(), $this->connection->getPassword(), $this->connection->getDatabaseName());

        $this->destinationDirectoryDeleteTables($toDirectory);
        
        foreach ($database->getTables() as $tableName => $table) {
            $tableDir = $toDirectory . '/' . $databaseName . '/' . $tableName;
            if (!is_dir($tableDir)) {
                mkdir($tableDir, 0755, true);
            }
            $tableStructureDump->export($tableName, $tableDir.'/'.$tableName.'-structure.sql');
            $tableCsvDump->export($table, $tableDir.'/'.$tableName);
        }
    }
    
    private function destinationDirectoryDeleteTables($path) {
        exec('rm -r ' . $path . '/*');
    }

}
