<?php
use PHPUnit\Framework\TestCase;

require_once '../DbConfig.php';
require_once '../DbConn.php';
require_once '../Creator.php';

class CreatorTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess   
    // beStrictAboutCoversAnnotation="false" in PHPUnit configuration file
    
    /**
     * @covers \Creator::setFirstName
     * @covers \Creator::__construct
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
     * @covers \Creator::setFirstName
     * @covers \Creator::__construct
     */
    public function testSetFirstNameFail() {
        global $pdo;
        $creator = new Creator($pdo);
        $creator->setFirstName("Eric");
        $this->assertFalse("Elvis" === $creator->getFirstName());
    }
    
    /**
     * @covers \Creator::getFullName
     * @covers \Creator::__construct
     * @covers \Creator::getId
     */
    public function testGetFullNameSuccess() {
        global $pdo;
        // Jim Starlin is Creator 5
        $creator = new Creator();
        $creator->loadCreatorById($pdo, 5);
        $this->assertEquals("Jim Starlin", $creator->getFullName(false));
        $this->assertEquals("Starlin, Jim", $creator->getFullName(true));
        $this->assertEquals(5, $creator->getId());
    }    
    
    /**
     * @covers \Creator::setLastName
     * @covers \Creator::getLastName
     * @covers \Creator::__construct
     */
    public function testSetLastNameSuccess() {
        global $pdo;
        $creator = new Creator($pdo);
        $creator->setLastName("Grossman");
        $this->assertEquals("Grossman", $creator->getLastName());
    }

    /**
     * @covers \Creator::setLastName
     * @covers \Creator::getLastName
     * @covers \Creator::__construct
     */
    public function testSetLastNameFail() {
        global $pdo;
        $creator = new Creator($pdo);
        $creator->setLastName("Grossman");
        $this->assertFalse("Presley" === $creator->getLastName());
    }

    /**
     * @covers \Creator::__construct
     * @covers \Creator::getLastName
     * @covers \Creator::getFirstName
     */
    public function testLoadCreatorNoId() {
        global $pdo;
        $creator = new Creator($pdo);
        $this->assertEquals("", $creator->getLastName());
        $this->assertEquals("", $creator->getFirstName());
    }
    
    /**
     * @covers \Creator::loadCreatorById
     * @covers \Creator::getLastName
     * @covers \Creator::getFirstName
     * @covers \Creator::__construct
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
     * @covers \Creator::loadCreatorById
     * @covers \Creator::__construct
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
     * @covers \Creator::saveCreator
     * @covers \Creator::setLastName
     * @covers \Creator::__construct
     */
    public function testSaveCreatorNewSuccess() {
        global $pdo;
        $creator = new Creator();
        $creator->setFirstName("Delete");
        $creator->setLastName("Me00000");
        $id = $creator->saveCreator($pdo);
        $this->assertTrue(is_int($id));
        return $id;
    }
    
    // id is a string in signature because lastInsertId 
    // returns its value as a string, not an integer
    /**
     * @depends testSaveCreatorNewSuccess
     * @covers \Creator::saveCreator
     * @covers \Creator::loadCreatorById
     * @covers \Creator::getFirstName
     * @covers \Creator::__construct
     */
    public function testSaveCreatorUpdateSuccess(int $id) {
        global $pdo;
        $creator = new Creator();
        $creator->loadCreatorById($pdo, (int)$id);
        $creator->setFirstName("Joe");
        $idPostSave = $creator->saveCreator($pdo);   
        $this->assertTrue(is_int($idPostSave));
        $this->assertEquals("Joe", $creator->getFirstName());
        // reset for another run
        $sql2 = 'DELETE FROM Creators WHERE Id = :Id';
        $stmt = $pdo->prepare($sql2);
        $stmt->execute(array($id));
    }   
    
    /**
     * @covers \Creator::saveCreator
     * @covers \Creator::setLastName
     * @covers \Creator::setFirstName
     * @covers \Creator::deleteCreator
     * @covers \Creator::__construct
     */
    public function testDeleteCreator() {
        global $pdo;
        $creator = new Creator();
        $creator->setFirstName("Bobert");
        $creator->setLastName("Blarghingham");
        $id = $creator->saveCreator($pdo);
        
        Creator::deleteCreator($pdo, $id);
        
        $sql = "SELECT COUNT(*) AS NumRows FROM Creators WHERE LastName='Blarghingham' OR ID = " . $id;
        $rowNum = (int)$pdo->query($sql)->fetchColumn();
        $this->assertEquals(0, $rowNum);     
    }
    
    /**
     * @covers \Creator::getCreatorTable
     * 
     */
    public function testCreatorTable() {
        global $pdo;
        $table = Creator::getCreatorTable($pdo);
        $this->assertStringContainsString("<table id=\"adminCreatorsTable\"", $table);
        $this->assertStringContainsString("</table>", $table);  
    }
}
