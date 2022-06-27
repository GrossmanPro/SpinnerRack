<?php

class Title {
    
    private $id;
    private $name;
    private $startYear;
    private $volume;
    private $publisherId;
    
    public function __construct() {
        $this->id = 0;
        $this->publisherId = 0;
        $this->name = "";
        $this->volume = 0;
        $this->startYear = 0;
    }
    
    public function getId() : int {
        return $this->id;
    }
    
    public function getName(): string {
        return $this->name;
    }
    
    public function setName(string $name) {
        $this->name = filter_var($name, FILTER_SANITIZE_STRING); 
    }
    
    public function getStartYear(): int {
        return $this->startYear;
    }
    
    public function setStartYear(int $year) {
        $this->startYear = filter_var($year, FILTER_SANITIZE_NUMBER_INT);
    }
    
    public function getVolume(): int {
        return $this->volume;
    }
    
    public function setVolume(int $volume) {
        $this->volume = filter_var($volume, FILTER_SANITIZE_NUMBER_INT);
    } 
    
    public function getPublisherId(): int {
        return $this->publisherId;
    }
    
    public function setPublisherId(int $pubId) {
        $this->publisherId = filter_var($pubId, FILTER_SANITIZE_NUMBER_INT);
    }
    
    public function loadTitleById(object $pdo, int $id) {
        $sql = 'SELECT * FROM Titles WHERE Id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
        $title = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($title)) {
            $this->name = $title[0]['Name'];
            $this->startYear = $title[0]['StartYear'];
            $this->volume = $title[0]['Volume'];
            $this->publisherId = $title[0]['PublisherId'];
            $this->id = $id;
        } else {
            $this->name = "";
            $this->startYear = 0;
            $this->volume = 0;
            $this->publisherId = 0;
            $this->id = 0;
            throw new Exception("This title does not exist");
        }
        
    }

    public function saveTitle(object $pdo) {
        if ($this->id) {
            $sql = 'UPDATE Titles SET '
                    . 'Name = :Name, '
                    . 'StartYear = :StartYear, '
                    . 'Volume = :Volume, '
                    . 'PublisherId = :PublisherId '
                    . 'WHERE Id = :Id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                $this->name, 
                $this->startYear, 
                $this->volume,
                $this->publisherId,
                $this->id));
        } else {
            $sql = 'INSERT INTO Titles (Name, StartYear, Volume, PublisherId) '
                    . 'VALUES (:Name, :StartYear, :Volume, :PublisherId)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                $this->name, 
                $this->startYear, 
                $this->volume,
                $this->publisherId));
            $this->id = $pdo->lastInsertId();
        }
        return $this->id;
    }    
    
}
