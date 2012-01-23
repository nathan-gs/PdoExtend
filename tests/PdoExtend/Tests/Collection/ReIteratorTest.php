<?php

namespace PdoExtend\Tests\Collection;

use PdoExtend\Collection\ReIterator;

class ReIteratorTest extends \PHPUnit_Framework_TestCase {

    public function testRewind() {

        $innerIterator = $this->getMock('\Iterator');
        $innerIterator->expects($this->once())
                ->method('rewind');
        $collection = new ReIterator($innerIterator);
        foreach ($collection as $item) {
            
        }
        foreach ($collection as $item) {
            
        }
    }

    public function testValues() {
        $values = array(
            't1',
            't2',
            't3',
        );

        $collection = new ReIterator(new \ArrayIterator($values));
        foreach ($collection as $item) {
            
        }
        $arr1 = iterator_to_array($collection);
        foreach ($collection as $item) {
            
        }
        $arr2 = iterator_to_array($collection);

        $this->assertSame($arr1, $arr2);
        $this->assertSame($values, iterator_to_array($collection));
    }

}