<?php

use PHPUnit\Framework\TestCase;

require_once '../DbConfig.php';
require_once '../DbConn.php';
require_once '../Publisher.php';

class PublisherTest extends TestCase {
    
    // remember to use test prefix, e.g. testSetFirstNameSuccess 
    
    /**
     * @covers ::savePublisher
     * @covers ::setPublisherName
     * @covers ::getPublisherName
     */
    public function testSavePublisherNewSuccess() {
        global $pdo;
        $publisher = new Publisher();
        $publisher->setPublisherName("Delete Pub");
        $id = $publisher->savePublisher($pdo);
        $this->assertTrue(ctype_digit($id));
        $this->assertEquals("Delete Pub", $publisher->getPublisherName());
        return $id;
    }
    /**
     * @depends testSavePublisherNewSuccess
     * @covers ::loadPublisherById
     * @covers ::savePublisher
     * @covers ::getPublisherName
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
     * @covers ::loadPublisherById
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