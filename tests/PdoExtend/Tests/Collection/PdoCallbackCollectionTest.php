<?php

namespace PdoExtend\Tests\Collection;

use PdoExtend\Collection\PdoCallBackCollection;
use PdoExtend\Collection\ReIterator;

class PdoCallbackCollectionTest extends \PHPUnit_Framework_TestCase {

    public function testItemsStayTheSame() {

        $pdoStatement = $this->getMock('\PDOStatement');
        $pdoStatement->expects($this->once())
                ->method('execute');
        $i = 0;
        $collection = new ReIterator(new PdoCallBackCollection($pdoStatement, function ($row) use (&$i) {
                            if ($i < 3) {
                                $i++;
                                return $i + 1;
                            }
                            return false;
                        }));
        foreach ($collection as $item) {
            
        }
        foreach ($collection as $item) {
            
        }
    }
}