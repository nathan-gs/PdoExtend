<?php

namespace PdoExtend\Debug;

class PdoStatement extends \PdoExtend\PdoStatement {

    public function execute($input_parameters = null) {
        $this->connection->addQuery($this->getSql(), $this->bound_params, debug_backtrace());

        parent::execute($input_parameters);
    }

}
