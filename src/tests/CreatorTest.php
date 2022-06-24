<?php

use PHPUnit\Framework\TestCase;
use src;

require '../DbConfig.php';
require '../DbConnection.php';
require '../Creator.php';

final class CreatorTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess

    public function testSetFirstNameSuccess() {
        
        $creator = new \src\Creator($db);
        $creator->setFirstName("Eric");
        $this->assertEquals("Eric", $creator->getFirstName());
    }

    public function testSetFirstNameFail() {
        $creator = new \src\Creator($db);
        $creator->setFirstName("Eric");
        $this->assertEquals("Elvis", $creator->getFirstName());
    }

}
