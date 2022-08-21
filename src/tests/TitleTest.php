<?php

use PHPUnit\Framework\TestCase;

require_once '../DbConfig.php';
require_once '../DbConn.php';
require_once '../Title.php';

class TitleTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess 
    // beStrictAboutCoversAnnotation="false" in PHPUnit configuration file
    
    /**
     * @covers \Title::setName
     * @covers \Title::getName
     */
    public function testSetNameSuccess() {
        $title = new Title();
        $title->setName("Superman");
        $this->assertEquals("Superman", $title->getName());
    }

    /**
     * @covers \Title::setName
     * @covers \Title::getName
     */
    public function testSetNameFail() {
        $title = new Title();
        $title->setName("Superman");
        $this->assertFalse("Wonder Woman" === $title->getName());
    }
    
    /**
     * @covers \Title::setStartYear
     * @covers \Title::getStartYear
     */
    public function testSetStartYearSuccess() {
        $title = new Title();
        $title->setStartYear(1970);
        $this->assertEquals(1970, $title->getStartYear());
    }

    /**
     * @covers \Title::setStartYear
     * @covers \Title::getStartYear
     */
    public function testSetStartYearFail() {
        $title = new Title();
        $title->setStartYear(1970);
        $this->assertFalse(1971 === $title->getStartYear());
    }
    
    /**
     * @covers \Title::setVolume
     * @covers \Title::getVolume
     */
    public function testSetVolumeSuccess() {
        $title = new Title();
        $title->setVolume(1);
        $this->assertEquals(1, $title->getVolume());
    }

    /**
     * @covers \Title::setVolume
     * @covers \Title::getVolume
     */
    public function testSetVolumeFail() {
        $title = new Title();
        $title->setVolume(1);
        $this->assertFalse(11 === $title->getVolume());
    }
    
    /**
     * @covers \Title::setPublisherId
     * @covers \Title::getPublisherId
     */
    public function testSetPublisherIdSuccess() {
        $title = new Title();
        $title->setPublisherId(1);
        $this->assertEquals(1, $title->getPublisherId());
    }

    /**
     * @covers \Title::setPublisherId
     * @covers \Title::getPublisherId
     */
    public function testSetPublisherIdFail() {
        $title = new Title();
        $title->setPublisherId(1);
        $this->assertFalse(11 === $title->getPublisherId());
    }
    
    /**
     * @covers \Title::__construct
     * @covers \Title::loadTitleById
     */
    public function testLoadTitleByIdSuccess() {
        global $pdo;
        $title = new Title();
        $title->loadTitleById($pdo, 2);
        $this->assertEquals("ROM Spaceknight", $title->getName());
    }
    
    /**
     * @covers \Title::__construct
     * @covers \Title::loadTitleById
     */
    public function testLoadTitleByIdFail() {
        global $pdo;
        $title = new Title();
        try {
            $title->loadTitleById($pdo, 0);
        } catch (Exception $e) {
            $this->assertEquals("This title does not exist", $e->getMessage());
        }
    }
    
    /**
     * @covers \Title::__construct
     * @covers \Title::setName
     * @covers \Title::setPublisherId
     * @covers \Title::setStartYear
     * @covers \Title::setVolume
     * @covers \Title::saveTitle
     * @covers \Title::getId
     */
    public function testSaveNewTitle() {
        global $pdo;
        $title = new Title();
        $title->setName("DELETE THIS TITLE");
        $title->setPublisherId(44);  // Marvel
        $title->setStartYear(1976);
        $title->setVolume(1);
        $id = $title->saveTitle($pdo);
        $this->assertTrue(is_int($id));
        $this->assertEquals($id, $title->getId());
        return $id;        
    }
    
    // id is a string in signature because lastInsertId 
    // returns its value as a string, not an integer
    
    /**
     * @depends testSaveNewTitle
     * @covers \Title::__construct
     * @covers \Title::loadTitleById
     * @covers \Title::setName
     * @covers \Title::saveTitle
     * @covers \Title::getName
     */
    public function testUpdateExistingTitle(int $id) {
        global $pdo;
        $title = new Title();
        $title->loadTitleById($pdo, $id);
        $this->assertEquals("DELETE THIS TITLE", $title->getName());
        $title->setName("CHANGE THIS TITLE'S NAME");
        $title->saveTitle($pdo);
        $title2 = new Title();
        $title2->loadTitleById($pdo, $id);
        // decode from filter_var in setName()
        $this->assertEquals("CHANGE THIS TITLE'S NAME", html_entity_decode($title2->getName()));
    }
    
    
    
    /**
     * @covers \Title::__construct
     * @covers \Title::setName
     * @covers \Title::setPublisherId
     * @covers \Title::setStartYear
     * @covers \Title::setVolume
     * @covers \Title::saveTitle
     * @covers \Title::deleteTitle
     */
    public function testDeleteTitle() {
        global $pdo;
        $title = new Title();
        $title->setName("DELETE TEST 2");
        $title->setPublisherId(44);  // Marvel
        $title->setStartYear(2022);
        $title->setVolume(1);
        $id = $title->saveTitle($pdo);
        
        Title::deleteTitle($pdo, $id);
        
        $sql = 'SELECT COUNT(*) AS RowNum FROM Titles WHERE Id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
        $rowNum = (int)$stmt->fetchColumn();
        $this->assertEquals(0, $rowNum);     
    }    
}

