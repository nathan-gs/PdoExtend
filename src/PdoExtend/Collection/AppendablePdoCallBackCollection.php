<?php

namespace PdoExtend\Collection;

class AppendablePdoCallBackCollection extends PdoCallBackCollection implements AppendableCollectionInterface {

    protected $appendedItems = array();
    protected $appendedItemsKey = 0;
    protected $useAppendedItems = false;

    public function append($value) {
        $this->appendedItems[] = $value;
    }

    protected function fetch() {
        if ($this->useAppendedItems === true) {
            $item = $this->fetchAppended();
        } else {
            $item = parent::fetch();
            if ($item === false && $this->useAppendedItems === false) {
                $this->useAppendedItems = true;
                $item = $this->fetchAppended();
                if($item === false) {
                    
                }
            }
        }
        return $item;
    }

    protected function fetchAppended() {
        if (isset($this->appendedItems[$this->appendedItemsKey])) {
            $item = $this->appendedItems[$this->appendedItemsKey];
            $this->appendedItemsKey++;
            return $item;
        } else {
            return false;
        }
    }
    

}