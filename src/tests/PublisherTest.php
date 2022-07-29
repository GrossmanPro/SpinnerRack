<?php

use PHPUnit\Framework\TestCase;

require_once '../DbConfig.php';
require_once '../DbConn.php';
require_once '../Publisher.php';

class PublisherTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess 
    // beStrictAboutCoversAnnotation="false" in PHPUnit configuration file
    
    /**
     * @covers \Publisher::savePublisher
     * @covers \Publisher::setPublisherName
     * @covers \Publisher::getPublisherName
     * @covers \Publisher::getPublisherId
     * @covers \Publisher::__construct
     */
    public function testSavePublisherNewSuccess() {
        global $pdo;
        $publisher = new Publisher();
        $publisher->setPublisherName("Delete Pub");
        $id = $publisher->savePublisher($pdo);
        $this->assertTrue(is_int($id));
        $this->assertEquals("Delete Pub", $publisher->getPublisherName());
        $this->assertEquals($id, $publisher->getPublisherId());
        return $id;
    }
    
    /**
     * @depends testSavePublisherNewSuccess
     * @covers \Publisher::loadPublisherById
     * @covers \Publisher::savePublisher
     * @covers \Publisher::getPublisherName
     * @covers \Publisher::__construct
     * @covers \Publisher::deletePublisher
     * @covers \Publisher::getPublisherTable
     */
    public function testSavePublisherUpdateSuccess(int $id) { 
        global $pdo;
        $publisher = new Publisher();
        $publisher->loadPublisherById($pdo, (int)$id);
        $publisher->setPublisherName("Delete This Publisher");
        $idPostSave = $publisher->savePublisher($pdo);  
        $this->assertTrue(is_int($idPostSave));    
        $this->assertEquals("Delete This Publisher", $publisher->getPublisherName()); 
        
        // spot check table output
        $table = Publisher::getPublisherTable($pdo);
        $this->assertStringContainsString("<table id=\"adminPublishersTable\"", $table);
        $this->assertStringContainsString("</table>", $table);
        
        // reset for another run / check delete static function
        Publisher::deletePublisher($pdo, $id);
        $delSql = 'SELECT COUNT(*) AS rowCnt FROM Publishers WHERE Id = :id';
        $stmt = $pdo->prepare($delSql);
        $stmt->execute(array($id));
        $result = $stmt->fetchColumn();
        $this->assertEquals(0, $result);  
    }
    
    /**
     * @covers \Publisher::loadPublisherById
     * @covers \Publisher::__construct
     */
    public function testLoadPublisherByIdFail() {
        global $pdo;
        $publisher = new Publisher();
        try {
            $publisher->loadPublisherById($pdo, 0);
        } catch (Exception $e) {
            $this->assertEquals("This publisher does not exist", $e->getMessage());
        }
    }
    
}