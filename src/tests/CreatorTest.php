<?php
use PHPUnit\Framework\TestCase;

require_once '../DbConfig.php';
require_once '../DbConn.php';
require_once '../Creator.php';

class CreatorTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess   
    
    /**
     * @covers ::setFirstName
     */
    public function testSetFirstNameSuccess() {
        // TODO
        // How do I pass a db connection to this class?
        global $pdo;
        $creator = new Creator($pdo);
        $creator->setFirstName("Eric");
        $this->assertEquals("Eric", $creator->getFirstName());
    }

    /**
     * @covers ::setFirstName
     */
    public function testSetFirstNameFail() {
        global $pdo;
        $creator = new Creator($pdo);
        $creator->setFirstName("Eric");
        $this->assertFalse("Elvis" === $creator->getFirstName());
    }
    
    /**
     * @covers ::getFullName
     */
    public function testGetFullNameSuccess() {
        global $pdo;
        // Jim Starlin is Creator 5
        $creator = new Creator();
        $creator->loadCreatorById($pdo, 5);
        $this->assertEquals("Jim Starlin", $creator->getFullName(false));
        $this->assertEquals("Starlin, Jim", $creator->getFullName(true));
    }    
    
    /**
     * @covers ::setLastName
     */
    public function testSetLastNameSuccess() {
        global $pdo;
        $creator = new Creator($pdo);
        $creator->setLastName("Grossman");
        $this->assertEquals("Grossman", $creator->getLastName());
    }

    /**
     * @covers ::setLastName
     */
    public function testSetLastNameFail() {
        global $pdo;
        $creator = new Creator($pdo);
        $creator->setLastName("Grossman");
        $this->assertFalse("Presley" === $creator->getLastName());
    }

    /**
     * @covers ::__construct
     */
    public function testLoadCreatorNoId() {
        global $pdo;
        $creator = new Creator($pdo);
        $this->assertEquals("", $creator->getLastName());
        $this->assertEquals("", $creator->getFirstName());
    }
    
    /**
     * @covers ::loadCreatorById
     */
    public function testLoadCreatorByIdSuccess() {
        global $pdo;
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
        global $pdo;
        $creator = new Creator();
        try {
            $creator->loadCreatorById($pdo, 0);
        } catch (Exception $e) {
            $this->assertEquals("This creator does not exist", $e->getMessage());
        }
    }
    
    /**
     * @covers ::saveCreator
     */
    public function testSaveCreatorNewSuccess() {
        global $pdo;
        $creator = new Creator();
        $creator->setFirstName("Delete");
        $creator->setLastName("Me78");
        $id = $creator->saveCreator($pdo);
        $this->assertTrue(ctype_digit($id));
        return $id;
    }
    
    // id is a string in signature because lastInsertId 
    // returns its value as a string, not an integer
    /**
     * @depends testSaveCreatorNewSuccess
     * @covers ::saveCreator
     */
    public function testSaveCreatorUpdateSuccess(string $id) {
        global $pdo;
        $creator = new Creator();
        $creator->loadCreatorById($pdo, (int)$id);
        $creator->setFirstName("Joe");
        $idPostSave = $creator->saveCreator($pdo);   
        $this->assertTrue(is_int($idPostSave));
        $this->assertEquals("Joe", $creator->getFirstName());
    }
    
}
