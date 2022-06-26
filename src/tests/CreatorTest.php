<?php
use PHPUnit\Framework\TestCase;

require '../Creator.php';

class CreatorTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess
    /**
     * @covers ::setFirstName
     */
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

    /**
     * @covers ::setFirstName
     */
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
    
    /**
     * @covers ::getFullName
     */
    public function testGetFullNameSuccess() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        // John Byrne is Creator 1
        $creator = new Creator();
        $creator->loadCreatorById($pdo, 1);
        $this->assertEquals("John Byrne", $creator->getFullName(false));
        $this->assertEquals("Byrne, John", $creator->getFullName(true));
    }
    
    
    /**
     * @covers ::setLastName
     */
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

    /**
     * @covers ::setLastName
     */
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

    /**
     * @covers ::__construct
     */
    public function testLoadCreatorNoId() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator($pdo);
        $this->assertEquals("", $creator->getLastName());
        $this->assertEquals("", $creator->getFirstName());
    }
    
    /**
     * @covers ::loadCreatorById
     */
    public function testLoadCreatorByIdSuccess() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator();
        // John Byrne is Creator 1
        $creator->loadCreatorById($pdo, 1);
        $this->assertEquals("Byrne", $creator->getLastName());
        $this->assertEquals("John", $creator->getFirstName());
        // Jim Starlin is Creator 5
        $creator->loadCreatorById($pdo, 5);
        $this->assertEquals("Starlin", $creator->getLastName());
        $this->assertEquals("Jim", $creator->getFirstName());        
    }
    
    /**
     * @covers ::loadCreatorById
     */
    public function testLoadCreatorByIdFail() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator();
        try {
            $creator->loadCreatorById($pdo, 0);
        } catch (Exception $e) {
            $this->assertEquals("This creator does not exist", $e->getMessage());
        }
        $pdo = null;
    }
    
    /**
     * @covers ::saveCreator
     */
    public function testSaveCreatorNewSuccess() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator();
        $creator->setFirstName("Neal");
        $creator->setLastName("Adams");
        $id = $creator->saveCreator($pdo);
        $this->assertTrue(ctype_digit($id));
        $pdo = null;
    }
    
}
