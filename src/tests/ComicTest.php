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
     * @covers \Comic::setStory
     */
    public function testSetStoryFail() {
        $comic = new Comic();
        $title = str_repeat("Story", 201);
        try {
            $comic->setStory($title);
        } catch (Exception $e) {
            $this->assertEquals("Story title too long--must be 1,000 characters or less", $e->getMessage());
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
    public function testCreateNewComic(): int {
        global $pdo;
        $comic = new Comic();
        $comic->setTitleId(2);
        $comic->setIssue(246);
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
     * @covers \Comic::setArtist
     * @covers \Comic::setScripter
     * @covers \Comic::deleteCreators
     * @covers \Comic::deleteComic
     */
    public function testDeleteCreators() {
        global $pdo;
        $comic = new Comic();
        $comic->setTitleId(2);
        $comic->setIssue(245);
        $comic->setMonth(11);
        $comic->setYear(1978);
        $comic->setStars(3);
        $comic->setHardCopy(false);
        $comic->setWantList(true);
        $comic->setStory("Generic Story");
        $comic->setNotes("Notes go here");
        $id = $comic->saveComic($pdo);
        $comic->setArtist($pdo, 1);
        $comic->setScripter($pdo, 1);
        $comic->deleteCreators($pdo);
        
        $sql1 = 'SELECT COUNT(*) AS RowNum FROM ScriptBy WHERE ComicId = ' . $id;
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute(array($id));
        $result1 = $stmt1->fetchColumn();
        $this->assertEquals(0, $result1);
        
        $sql2 = 'SELECT COUNT(*) AS RowNum FROM ArtBy WHERE ComicId = ' . $id;
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute(array($id));
        $result2 = $stmt2->fetchColumn();
        $this->assertEquals(0, $result2);
        
        $comic::deleteComic($pdo, $id);
    }

    /**
     * @covers \Comic::__construct
     * @covers \Comic::loadComicById
     * @covers \Comic::getScriptersToString
     * @covers \Comic::getArtistsToString
     */
    public function testGetArtistAndWriterByString() {
        global $pdo;
        $comic = new Comic();
        $comic->setTitleId(2);
        $comic->setIssue(1001);
        $comic->setMonth(12);
        $comic->setYear(1979);
        $comic->setStars(3);
        $comic->setHardCopy(false);
        $comic->setWantList(true);
        $comic->setStory("Generic Storyx");
        $comic->setNotes("Notes go here");
        $id = $comic->saveComic($pdo);
        $this->assertTrue(is_int($comic->getId()));
        $comic->setArtist($pdo, 1);
        $comic->setScripter($pdo, 1);
        $this->assertEquals("John Byrne", $comic->getScriptersToString());
        $this->assertEquals("John Byrne", $comic->getArtistsToString());

        // reset for another run
        $sql = 'DELETE FROM Comics WHERE Id = :Id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
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
    public function testCheckSavedComicValues(int $id): Comic {
        global $pdo;
        $comic = new Comic();
        $comic->loadComicById($pdo, $id);
        $this->assertEquals(2, $comic->getTitleId());
        $this->assertEquals(246, $comic->getIssue());
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
     * @covers \Comic::getComicsTable
     * @covers \Comic::getStarSvgs
     * @covers \Comic::deleteComic
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

        // spot check table output
        $table = $updatedComic->getComicsTable($pdo);
        $this->assertStringContainsString("<table id=\"comicsListTable\"", $table);
        $this->assertStringContainsString("</table>", $table);

        // check svg string
        $svgs = $updatedComic->getStarSvgs();
        $this->assertStringContainsString("bi-star-fill", $svgs);

        // reset for another run / check delete static function
        Comic::deleteComic($pdo, $updatedComic->getId());
        $delSql = 'SELECT COUNT(*) AS rowCnt FROM Comics WHERE ID = :id';
        $stmt = $pdo->prepare($delSql);
        $stmt->execute(array($id));
        $result = $stmt->fetchColumn();
        $this->assertEquals(0, $result);
    }

}