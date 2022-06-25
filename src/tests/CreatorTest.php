<?php
use PHPUnit\Framework\TestCase;

require '../DbConfig.php';
require '../DbConnection.php';
require '../Creator.php';

class CreatorTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess

    public function testSetFirstNameSuccess() {
        // TODO
        // How do I pass a db connection to this class?
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator($pdo);
        $creator->setFirstName("Eric");
        $this->assertEquals("Eric", $creator->getFirstName());
        $pdo = null;
    }

    public function testSetFirstNameFail() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator($pdo);
        $creator->setFirstName("Eric");
        $this->assertFalse("Elvis" === $creator->getFirstName());
        $pdo = null;
    }
    
    public function testSetLastNameSuccess() {
        // TODO
        // How do I pass a db connection to this class?
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator($pdo);
        $creator->setLastName("Grossman");
        $this->assertEquals("Grossman", $creator->getLastName());
        $pdo = null;
    }

    public function testSetLastNameFail() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator($pdo);
        $creator->setLastName("Grossman");
        $this->assertFalse("Presley" === $creator->getLastName());
        $pdo = null;
    }
    
    public function testLoadCreatorSuccess() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator($pdo, 1);
        // John Byrne is Creator 1
        $this->assertEquals("Byrne", $creator->getLastName());
        $this->assertEquals("John", $creator->getFirstName());
        $pdo = null;
    }
    
    public function testLoadCreatorFail() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator($pdo, 1);
        // John Byrne is Creator 1
        $this->assertFalse("Macchio" === $creator->getLastName());
        $this->assertFalse("Ralph" === $creator->getFirstName());
        $pdo = null;
    }


}
