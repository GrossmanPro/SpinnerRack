<?php

class Creator {

    private $id;
    private $firstName;
    private $lastName;

    /**
     * __construct
     */
    public function __construct() {
        $this->id = 0;
        $this->firstName = "";
        $this->lastName = "";
    }
    
    /**
     * getId
     * Returns Creators.Id
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * getFirstName
     * @return string
     */
    public function getFirstName(): string {
        return $this->firstName;
    }

    /**
     * setFirstName
     * @param string $firstName
     */
    public function setFirstName(string $firstName) {
        $this->firstName = filter_var($firstName, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * getLastName
     * @return string
     */
    public function getLastName(): string {
        return $this->lastName;
    }

    /**
     * setLastName
     * @param string $lastName
     */
    public function setLastName(string $lastName) {
        $this->lastName = filter_var($lastName, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * getFullName
     * @param bool $lastNameFirst
     * @return string
     */
    public function getFullName(bool $lastNameFirst = false): string {
        if ($lastNameFirst) {
            return $this->lastName . ', ' . $this->firstName;
        } else {
            return $this->firstName . ' ' . $this->lastName;
        }
    }

   /**
    * loadCreatorById
    * @param object $pdo
    * @param int $id
    * @throws Exception
    */
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
            $this->firstName = "";
            $this->lastName = "";
            $this->id = 0;
            throw new Exception("This creator does not exist");
        }
    }

    /**
     * saveCreator
     * Handles edits and inserts to the Creators table
     * @param object $pdo
     * @return type
     */
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
        return (int)$this->id;
    }
    
    /**
     * getCreatorTable
     * Static function to create a table of creator records for 
     * jQuery DataTable.  Placed here to keep methods related to
     * Creators table together.
     * @param object $pdo
     * @return string
     */
    public static function getCreatorTable(object $pdo): string {
        $table = '<table id="adminCreatorsTable" class="table table-sm table-bordered">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th class="actionColumn text-center" data-orderable="false">Actions</th>';
        $table .= '<th>Last Name</th>';
        $table .= '<th>First Name</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        foreach ($pdo->query('SELECT * FROM Creators ORDER BY LastName, FirstName') as $creator) {
            $editBtn = '<a href="/admin/creators/edit/' . $creator['Id'] . '/" class="btn btn-sm btn-info editCreator" id="btnEdit_' . $creator['Id'] . '">Edit</a>';
            $deleteBtn = '<input type="button" class="btn btn-sm btn-danger deleteCreator" id="btnDelete_' . $creator['Id'] . '" value="Delete">';
            $table .= '<tr>';
            $table .= '<td class="text-center">' . $editBtn . '&nbsp;' . $deleteBtn . '</td>';
            $table .= '<td>' . $creator['LastName'] . '</td>';
            $table .= '<td>' . $creator['FirstName'] . '</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }
    
    /**
     * deleteCreator
     * @param object $pdo
     * @param int $creatorId
     * @return void
     */
    public static function deleteCreator(object $pdo, int $creatorId): void {
        $sql = 'DELETE FROM Creators WHERE Id = :Id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($creatorId));
    }

}
