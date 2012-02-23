<?php

namespace PdoExtend\Tests\Helper;

use PdoExtend\Helper\InHelper;

class InHelperTest extends \PHPUnit_Framework_TestCase {
    
    public function testReverseSort() {
        $helper = new InHelper('test', array(12, 34, 44, 32, 1));
        
        $this->assertSame(' (:test4, :test3, :test2, :test1, :test0) ', $helper->getFields());
        
        $pdoStatement = $this->getMock('PDOStatement');
        $pdoStatement->expects($this->exactly(5))
                ->method('bindValue');
        $helper->getStatement($pdoStatement);
    }
}