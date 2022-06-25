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
    public function testLoadCreatorByConstructorSuccess() {
        $dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
        $username = "SpinnerRackUser";
        $password = "password";
        $pdo = new PDO($dsn, $username, $password);
        $creator = new Creator($pdo, 1);
        // with id, John Byrne is Creator 1
        $this->assertEquals("Byrne", $creator->getLastName());
        $this->assertEquals("John", $creator->getFirstName());
        $pdo = null;
    }
    
    /**
     * @covers ::__construct
     */
    public function testLoadCreatorByConstructorFail() {
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
        $creator = new Creator($pdo);
        // John Byrne is Creator 1
        $creator->loadCreatorById(1);
        $this->assertEquals("Byrne", $creator->getLastName());
        $this->assertEquals("John", $creator->getFirstName());
        // Jim Starlin is Creator 5
        $creator->loadCreatorById(5);
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
        $creator = new Creator($pdo);
        try {
            $creator->loadCreatorById(0);
        } catch (Exception $e) {
            $this->assertEquals("This creator does not exist", $e->getMessage());
        }
    }
    
}
