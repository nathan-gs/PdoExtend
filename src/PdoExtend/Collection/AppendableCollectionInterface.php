<?php

namespace PdoExtend\Collection;

interface AppendableCollectionInterface extends \Traversable {

    public function append($value);

}