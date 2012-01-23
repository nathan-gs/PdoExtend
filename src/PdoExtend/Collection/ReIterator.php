<?php

namespace PdoExtend\Collection;

class ReIterator implements \Iterator {

    /**
     * @var \Iterator
     */
    private $rewindCount;
    private $valueIterator;
    private $currentIterator;

    public function __construct(\Iterator $iterator) {
        $this->currentIterator = $iterator;
        $this->valueIterator = array();
    }

    public function rewind() {
        if ($this->isSecondTime()) {
            $this->currentIterator = new \ArrayIterator($this->valueIterator);
        }
        $this->currentIterator->rewind();
        if ($this->isFirstTime() && $this->valid()) {
            $this->valueIterator[$this->key()] = $this->current();
        }
        $this->rewindCount++;
    }

    public function current() {
        return $this->currentIterator->current();
    }

    public function key() {
        return $this->currentIterator->key();
    }

    public function next() {
        $this->currentIterator->next();
        if ($this->isFirstTime() && $this->valid()) {
            $this->valueIterator[$this->key()] = $this->current();
        }
    }

    public function valid() {
        return $this->currentIterator->valid();
    }

    private function isSecondTime() {
        return $this->rewindCount == 1;
    }

    private function isFirstTime() {
        return $this->rewindCount < 2;
    }

}