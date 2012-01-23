<?php

namespace PdoExtend\Collection;

class LazyMapCollection implements \Iterator {

    /**
     * @var \Iterator
     */
    private $iterator;
    private $mapCallBack;

    public function __construct(\Closure $mapCallBack) {
        $this->mapCallBack = $mapCallBack;
    }

    public function rewind() {
        $callBack = $this->mapCallBack;
        $this->iterator = $callBack();
        return $this->iterator->rewind();
    }

    public function current() {
        return $this->iterator->current();
    }

    public function key() {
        return $this->iterator->key();
    }

    public function next() {
        return $this->iterator->next();
    }

    public function valid() {
        return $this->iterator->valid();
    }

}