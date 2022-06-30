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
     * @covers /Comic::setIssue
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
     */
    public function testCreateNewComic(): int{
        global $pdo;
        $comic = new Comic();
        $comic->setTitleId(2); 
        $comic->setIssue(228);
        $comic->setMonth(12);
        $comic->setYear(1979);
        $comic->setStars(3);
        $comic->setHardCopy(false);
        $comic->setWantList(true);
        $comic->setStory("Generic Story");
        $comic->setNotes("Notes go here");
        $id = $comic->saveComic($pdo);
        $this->assertTrue(is_int($id));     
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
     */
    public function testCheckSavedComicValues(int $id)
    {
        global $pdo;    
        $comic = new Comic();
        $comic->loadComicById($pdo, $id);
        $this->assertEquals(2, $comic->getTitleId());
        $this->assertEquals(228, $comic->getIssue());
        $this->assertEquals(12, $comic->getMonth());
        $this->assertEquals(1979, $comic->getYear());
        $this->assertFalse($comic->getHardCopy());
        $this->assertTrue($comic->getWantList());
        $this->assertEquals(3, $comic->getStars());
        
        // reset for another run
        $sql = 'DELETE FROM Comics WHERE Id = :Id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
    }
    
   
    
}
