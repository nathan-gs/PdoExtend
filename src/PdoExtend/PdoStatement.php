<?php

namespace PdoExtend;

use PdoExtend\Exception;

class PdoStatement extends \PDOStatement implements \Countable {

    protected $connection;
    protected $bound_params = array();
    const NO_MAX_LENGTH = -1;

    private function __construct(\PDO $connection) {
        $this->connection = $connection;
    }

    public function count() {
        $statement = $this->connection->query('SELECT count(*) FROM (' . $this->getSql() . ') AS tmp_count_query');
        return $statement->fetchColumn();
    }

    public function bindParam($paramno, &$param, $type = \PDO::PARAM_STR, $maxlen = null, $driverdata = null) {
        $this->bound_params[$paramno] = array(
            'value' => &$param,
            'type' => $type,
            'maxlen' => (is_null($maxlen)) ? self::NO_MAX_LENGTH : $maxlen,
                // ignore driver data
        );

        $result = parent::bindParam($paramno, $param, $type, $maxlen, $driverdata);
    }

    public function bindValue($parameter, $value, $data_type = \PDO::PARAM_STR) {
        $this->bound_params[$parameter] = array(
            'value' => $value,
            'type' => $data_type,
            'maxlen' => self::NO_MAX_LENGTH
        );
        parent::bindValue($parameter, $value, $data_type);
    }

    public function getSql($values = array()) {
        $sql = $this->queryString;

        if (count($values) > 0) {
            array_multisort($values, SORT_DESC);
            foreach ($values as $key => $value) {
                $sql = str_replace($key, $this->connection->quote($value), $sql);
            }
        }

        if (count($this->bound_params)) {
            array_multisort($this->bound_params, SORT_DESC);
            foreach ($this->bound_params as $key => $param) {
                $value = $param['value'];
                if (!is_null($param['type'])) {
                    $value = self::cast($value, $param['type']);
                }
                if ($param['maxlen'] && $param['maxlen'] != self::NO_MAX_LENGTH) {
                    $value = self::truncate($value, $param['maxlen']);
                }
                if (!is_null($value)) {
                    $sql = str_replace($key, $this->connection->quote($value), $sql);
                } else {
                    $sql = str_replace($key, 'NULL', $sql);
                }
            }
        }
        return $sql;
    }

    static protected function cast($value, $type) {
        switch ($type) {
            case \PDO::PARAM_BOOL:
                return (bool) $value;
                break;
            case \PDO::PARAM_NULL:
                return null;
                break;
            case \PDO::PARAM_INT:
                return (int) $value;
            case \PDO::PARAM_STR:
            default:
                return $value;
        }
    }

    static protected function truncate($value, $length) {
        return substr($value, 0, $length);
    }

    public function execute($input_parameters = null) {
        try {
            return parent::execute($input_parameters);
        } catch (\PDOException $e) {
            throw new Exception\QueryException($this->getSql(), $e->getMessage(), $e->getCode(), $e);
        }
    }

}