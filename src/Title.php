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
        $this->name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS); 
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

    public function saveTitle(object $pdo): int {
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
            $this->id = (int)$pdo->lastInsertId();
        }
        return $this->id;
    }    
    
    /**
     * getTitlesTable
     * 
     * Generates HTML for table of comic titles w/edit and delete controls
     * 
     * @param object $pdo
     * @return string
     */
    public static function getTitlesTable(object $pdo): string {
        $table = '<table id="adminTitlesTable" class="table table-sm table-bordered">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th class="actionColumn text-center" data-orderable="false">Actions</th>';
        $table .= '<th>Title</th>';
        $table .= '<th>Publisher</th>';
        $table .= '<th>Year</th>';
        $table .= '<th>Volume</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        foreach ($pdo->query('SELECT * FROM TitlesView ORDER BY [Name]') as $title) {
            $editBtn = '<a href="/admin/titles/edit/' . $title['Id'] . '/" class="btn btn-sm btn-info" id="btnEdit_' . $title['Id'] . '">Edit</a>';
            $deleteBtn = '<input type="button" class="btn btn-sm btn-danger deleteTitle" id="btnDelete_' . $title['Id'] . '" value="Delete">';
            $table .= '<tr>';
            $table .= '<td class="text-center">' . $editBtn . '&nbsp;' . $deleteBtn . '</td>';
            $table .= '<td>' . $title['Name'] . '</td>';
            $table .= '<td>' . $title['Publisher']. '</td>';
            $table .= '<td>' . $title['StartYear']. '</td>';
            $table .= '<td>' . $title['Volume'] . '</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }
    
    /**
     * deleteTitle
     * 
     * @param object $pdo
     * @param int $titleId  Title.Id (primary key)
     * @return void
     */
    public static function deleteTitle(object $pdo, int $titleId): void {
        $sql = 'DELETE FROM Titles WHERE Id = :Id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($titleId));
    }
    
}
