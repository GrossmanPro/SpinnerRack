<?php

class Creator {

    private $id;
    private $firstName;
    private $lastName;

    public function __construct() {
        $this->id = 0;
        $this->firstName = "";
        $this->lastName = "";
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName) {
        $this->firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setLastName(string $lastName) {
        $this->lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
    }

    public function getFullName(bool $lastNameFirst = false): string {
        if ($lastNameFirst) {
            return $this->lastName . ', ' . $this->firstName;
        } else {
            return $this->firstName . ' ' . $this->lastName;
        }
    }

   public function loadCreatorById(object $pdo, int $id) {
        $sql = 'SELECT * FROM Creators WHERE Id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
        $creator = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($creator)) {
            $this->firstName = $creator[0]['FirstName'];
            $this->lastName = $creator[0]['LastName'];
            $this->id = $id;
        } else {
            throw new Exception("This creator does not exist");
        }
    }

    public function saveCreator(object $pdo) {
        if ($this->id) {
            $sql = 'UPDATE Creators SET FirstName = :FirstName, LastName = :LastName WHERE Id = :ID';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->firstName, $this->lastName, $this->id));
        } else {
            $sql = 'INSERT INTO Creators (FirstName, LastName) VALUES (:FirstName, :LastName)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->firstName, $this->lastName));
            $this->id = $pdo->lastInsertId();
        }
        return $this->id;
    }

}
