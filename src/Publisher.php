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
        $this->publisherName = filter_var($name, FILTER_UNSAFE_RAW);
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
    
    public function savePublisher(object $pdo): int {
        if ($this->id) {
            $sql = 'UPDATE Publishers SET Publisher = :Publisher WHERE Id = :Id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->publisherName, $this->id));
        } else {
            $sql = 'INSERT INTO Publishers (Publisher) VALUES (:Publisher)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->publisherName));
            $this->id = (int)$pdo->lastInsertId();
        }
        return $this->id;  
    }
    
    public static function getPublisherTable(object $pdo): string {
        $table = '<table id="adminPublishersTable" class="table table-sm table-bordered">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th class="actionColumn text-center" data-orderable="false">Actions</th>';
        $table .= '<th>Publisher Name</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        foreach ($pdo->query('SELECT * FROM Publishers ORDER BY Publisher') as $pub) {
            $editBtn = '<a href="/admin/publishers/edit/' . $pub['Id'] . '/" class="btn btn-sm btn-info" id="btnEdit_' . $pub['Id'] . '">Edit</a>';
            $deleteBtn = '<input type="button" class="btn btn-sm btn-danger deletePublisher" id="btnDelete_' . $pub['Id'] . '" value="Delete">';
            $table .= '<tr>';
            $table .= '<td class="text-center">' . $editBtn . '&nbsp;' . $deleteBtn . '</td>';
            $table .= '<td>' . $pub['Publisher'] . '</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }
    
    public static function deletePublisher(object $pdo, int $publisherId): void {
        $sql = 'DELETE FROM Publishers WHERE Id = :Id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($publisherId));
    }
    
}

