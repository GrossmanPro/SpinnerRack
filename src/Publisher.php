<?php

class Publisher {
    
    private $id;
    private $publisherName;
    
    public function __construct() {
        $this->id = 0;
        $this->publisherName =  "";
    }
    
    public function getPublisherId(): int {
        return $this->id;
    }
    
    public function getPublisherName(): string {
        return $this->publisherName;
    }
    
    public function setPublisherName(string $name) {
        $this->publisherName = filter_var($name, FILTER_SANITIZE_STRING);
    }
    
    public function loadPublisherById(object $pdo, int $id) {
        $sql = 'SELECT * FROM Publishers WHERE Id = :Id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
        $pub = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($pub)) {
            $this->publisherName = $pub[0]['Publisher'];
            $this->id = $id;
        } else {
            $this->publisherName = "";
            $this->id = 0;
            throw new Exception("This publisher does not exist");
        }        
    }
    
    public function savePublisher(object $pdo) {
        if ($this->id) {
            $sql = 'UPDATE Publishers SET Publisher = :Publisher WHERE Id = :Id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->publisherName, $this->id));
        } else {
            $sql = 'INSERT INTO Publishers (Publisher) VALUES (:Publisher)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->publisherName));
            $this->id = $pdo->lastInsertId();
        }
        return $this->id;
    }
    
}

