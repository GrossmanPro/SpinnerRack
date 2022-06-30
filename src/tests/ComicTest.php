<?php
use PHPUnit\Framework\TestCase;

require_once '../DbConfig.php';
require_once '../DbConn.php';
require_once '../Comic.php';

class ComicTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess   
    // beStrictAboutCoversAnnotation="false" in PHPUnit configuration file
    
    /**
     * @covers \Comic::setStars
     */
    public function testSetStarsFail() {
        $comic = new Comic();
        try {
            $comic->setStars(10);
        } catch (OutOfBoundsException $o) {
            $this->assertEquals("This is not a valid rating", $o->getMessage());
        }
    }
    
    /**
     * @covers \Comic::setIssue
     */
    public function testSetIssueFail() {
        $comic = new Comic();
        try {
            $comic->setIssue(-9);
        } catch (OutOfBoundsException $o) {
            $this->assertEquals("This is not a valid issue number", $o->getMessage());            
        }
    }
    
    /**
     * @covers \Comic::setMonth
     */
    public function testSetMonthFail() {
        $comic = new Comic();
        try {
            $comic->setMonth(-9);
        } catch (OutOfBoundsException $o) {
            $this->assertEquals("This is not a valid month", $o->getMessage());            
        }
    }
    
    /**
     * @covers \Comic::setYear
     */
    public function testSetYearFail() {
        $comic = new Comic();
        try {
            $comic->setYear(2300);
        } catch (OutOfBoundsException $o) {
            $this->assertEquals("This is not a valid year", $o->getMessage());            
        }
    }
    
    /**
     * @covers \Comic::setScripter
     */
    public function testSetScripterFail() {
        global $pdo;
        $comic = new Comic();
        try {            
            $comic->setScripter($pdo, 1);
        } catch (Exception $e) {
            $this->assertEquals("Comic must be saved before assigning creators", $e->getMessage());
        }
    }
    
    /**
     * @covers \Comic::setArtist
     */
    public function testSetArtistFail() {
        global $pdo;
        $comic = new Comic();
        try {            
            $comic->setArtist($pdo, 1);
        } catch (Exception $e) {
            $this->assertEquals("Comic must be saved before assigning creators", $e->getMessage());
        }
    }
    
    /**
     * @covers \Comic::loadComicById
     */
    public function testLoadComicByIdFail() {
        global $pdo;
        $comic = new Comic();
        try {
            $comic->loadComicById($pdo, 999999);
        } catch (Exception $e) {
            $this->assertEquals("This comic does not exist", $e->getMessage());
        }
    }
    
    /**
     * @covers \Comic::__construct
     * @covers \Comic::saveComic
     * @covers \Comic::setTitleId
     * @covers \Comic::setIssue
     * @covers \Comic::setMonth
     * @covers \Comic::setYear
     * @covers \Comic::setStars
     * @covers \Comic::setHardCopy
     * @covers \Comic::setWantList
     * @covers \Comic::setStory
     * @covers \Comic::setNotes
     * @covers \Comic::getId
     * @covers \Comic::setArtist
     * @covers \Comic::setScripter
     */
    public function testCreateNewComic(): int{
        global $pdo;
        $comic = new Comic();
        $comic->setTitleId(2); 
        $comic->setIssue(239);
        $comic->setMonth(12);
        $comic->setYear(1979);
        $comic->setStars(3);
        $comic->setHardCopy(false);
        $comic->setWantList(true);
        $comic->setStory("Generic Story");
        $comic->setNotes("Notes go here");
        $id = $comic->saveComic($pdo);
        $this->assertTrue(is_int($comic->getId()));   
        $comic->setArtist($pdo, 1);
        $comic->setScripter($pdo, 1);        
        return $id;
    }
     
    /**
     * @depends testCreateNewComic
     * @covers \Comic::loadComicById
     * @covers \Comic::getTitleId
     * @covers \Comic::getIssue
     * @covers \Comic::getMonth
     * @covers \Comic::getYear
     * @covers \Comic::getStars
     * @covers \Comic::getWantList
     * @covers \Comic::getHardCopy 
     * @covers \Comic::getNotes
     * @covers \Comic::getStory
     */
    public function testCheckSavedComicValues(int $id): Comic
    {
        global $pdo;    
        $comic = new Comic();       
        $comic->loadComicById($pdo, $id);
        $this->assertEquals(2, $comic->getTitleId());
        $this->assertEquals(239, $comic->getIssue());
        $this->assertEquals(12, $comic->getMonth());
        $this->assertEquals(1979, $comic->getYear());
        $this->assertFalse($comic->getHardCopy());
        $this->assertTrue($comic->getWantList());
        $this->assertEquals(3, $comic->getStars());
        $this->assertEquals("Notes go here", $comic->getNotes());
        $this->assertEquals("Generic Story", $comic->getStory());     
        $this->assertEquals(1, $comic->artists[0]->getId());
        $this->assertEquals(1, $comic->scripters[0]->getId());        
        return $comic; 
    }
    
    /**
     * @depends testCheckSavedComicValues
     * @covers \Comic::setStory
     * @covers \Comic::setStars
     * @covers \Comic::saveComic
     * @covers \Comic::getId
     * @covers \Comic::loadComicById
     * @covers \Comic::getStars
     */
    function testUpdateComicValues(Comic $comic) {
        global $pdo;  
        $comic->setStory("Crisis On Infinite Jupiters");
        $comic->setStars(1);
        $comic->saveComic($pdo);
        $id = $comic->getId();    
        unset($comic);      
        // reload and check new values 
        $updatedComic = new Comic();
        $updatedComic->loadComicById($pdo, $id);
        // new values
        $this->assertEquals(1, $updatedComic->getStars());
        $this->assertEquals("Crisis On Infinite Jupiters", $updatedComic->getStory());
        // still the same value
        $this->assertEquals(1979, $updatedComic->getYear());  
        
        // reset for another run
        $sql = 'DELETE FROM Comics WHERE Id = :Id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
        $sql2 = 'DELETE FROM ArtBy WHERE ComicId = :Id';
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute(array($id));
        $sql3 = 'DELETE FROM ScriptBy  WHERE ComicId = :Id';
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute(array($id));
    }
    
    
    
   
    
}
