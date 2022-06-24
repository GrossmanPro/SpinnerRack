<?php
use \PDO;
use PHPUnit\Framework\TestCase;

require '../DbConfig.php';
require '../DbConnection.php';
require '../Creator.php';

final class CreatorTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess

    public function testSetFirstNameSuccess() {
        // TODO
        // How do I pass a db connection to this class?
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new \src\Creator($pdo);
        $creator->setFirstName("Eric");
        $this->assertEquals("Eric", $creator->getFirstName());
    }

    public function testSetFirstNameFail() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new \src\Creator($pdo);
        $creator->setFirstName("Eric");
        $this->assertFalse("Elvis" === $creator->getFirstName());
    }
    
    public function testSetLastNameSuccess() {
        // TODO
        // How do I pass a db connection to this class?
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new \src\Creator($pdo);
        $creator->setLastName("Grossman");
        $this->assertEquals("Grossman", $creator->getLastName());
    }

    public function testSetLastNameFail() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new \src\Creator($pdo);
        $creator->setLastName("Grossman");
        $this->assertFalse("Presley" === $creator->getLastName());
    }

}
