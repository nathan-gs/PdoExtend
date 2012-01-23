<?php

namespace  PdoExtend\Collection;

abstract class AbstractCollection implements \Iterator
{
    protected $current = false;
    protected $key = 0;


    abstract protected function fetch();


    public function current() {
        return $this->current;
    }
    
    public function key() {
        return $this->key;
    }
    
    public function next() {
        $this->current = $this->fetch();
        $this->key++;
    }
    
    public function rewind() {
        $this->key = 0;
        $this->current = $this->fetch();
        $this->key++;
    }
    
    public function valid() {
        return $this->current === false ? false : true;
    }
    
}