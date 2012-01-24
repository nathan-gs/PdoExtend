<?php

namespace PdoExtend\Export;

use PdoExtend\Structure\TableInterface;

interface ExportTableToFileInterface {
    public function export(TableInterface $table, $toDirectory, $baseFileName = null);
}