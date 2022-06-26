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
        $this->assertTrue(ctype_digit($id));
        $this->assertEquals("Delete Pub", $publisher->getPublisherName());
        $this->assertEquals($id, $publisher->getPublisherId());
        return $id;
    }
    
    // id is a string in signature because lastInsertId 
    // returns its value as a string, not an integer
    /**
     * @depends testSavePublisherNewSuccess
     * @covers \Publisher::loadPublisherById
     * @covers \Publisher::savePublisher
     * @covers \Publisher::getPublisherName
     * @covers \Publisher::__construct
     */
    public function testSavePublisherUpdateSuccess(string $id) { 
        global $pdo;
        $publisher = new Publisher();
        $publisher->loadPublisherById($pdo, (int)$id);
        $publisher->setPublisherName("Delete This Publisher");
        $idPostSave = $publisher->savePublisher($pdo);  
        $this->assertTrue(is_int($idPostSave));    
        $this->assertEquals("Delete This Publisher", $publisher->getPublisherName());
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