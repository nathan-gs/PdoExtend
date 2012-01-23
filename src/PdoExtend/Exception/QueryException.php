<?php

namespace PdoExtend\Exception;

class QueryException extends PdoException {
    private $query;
    private $sqlCode;
    private $errorMessage;

    public function __construct($query = '', $message = '', $code = 0, $previous = null) {
        $this->query = $query;
        $this->sqlCode = $code;
        $this->errorMessage = $message;
        
        parent::__construct($this->__toString(), (int) $code, $previous);
    }
    
    public function __toString() {
        $message = array();
        $message['error'] = $this->errorMessage;
        $message['code'] = $this->sqlCode;
        $message['query'] = $this->query;
        $message['trace'] = $this->getTraceAsString();
        
        return print_r($message, true);
    }
}