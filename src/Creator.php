<?php
// php C:\php\phpunit-9.5.phar --generate-configuration
class Creator {

    private $id;
    private $firstName;
    private $lastName;
    protected $connection;

    public function __construct(object $db, int $id = 0) {
        $this->connection = $db;
        $this->id = $id;
        $this->firstName = "";
        $this->lastName = "";
        if ($this->id) {
            $this->loadCreator();
        }
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

    private function loadCreator() {
        $sql = 'SELECT * FROM Creators WHERE Id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($this->id));
        $creator = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $this->firstName = $creator['FirstName'];
        $this->lastName = $creator['LastName'];
    }
    
    public function loadCreatorById(int $id) {
        $sql = 'SELECT * FROM Creators WHERE Id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($id));
        $creator = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $this->firstName = $creator['FirstName'];
        $this->lastName = $creator['LastName'];
        $this->id = $id;
    }

    public function saveCreator() {
        if ($this->id) {
            $sql = 'UPDATE Creators SET FirstName = :FirstName, LastName = :LastName WHERE Id = :ID';
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array($this->firstName, $this->lastName, $this->id));
        } else {
            $sql = 'INSERT INTO Creators (FirstName, LastName) VALUES (:FirstName, :LastName)';
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array($this->firstName, $this->lastName));
        }
    }

}
