<?php
include_once 'Creator.php';

class Comic {

    private $id;
    private $titleId;
    private $issue;
    private $year;
    private $month;
    private $story;
    private $notes;
    private $stars;
    private $hardCopy;
    private $wantList;
    public $scripters;
    public $artists;

    public function __construct() {
        $this->id = 0;
        $this->titleId = 0;
        $this->year = 0;
        $this->month = 0;
        $this->issue = 0;
        $this->story = "";
        $this->notes = "";
        $this->stars = 0;
        $this->hardCopy = 1; // default to physical (vs digital)
        $this->wantList = 0; // default to owned comic
        $this->scripters = array();
        $this->artists = array();
    }

    /**
     * getID
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * getTitleId
     * @return int
     */
    public function getTitleId(): int {
        return $this->titleId;
    }

    /**
     * setTitleId
     * @param int $titleId
     */
    public function setTitleId(int $titleId) {
        $this->titleId = filter_var($titleId, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * getYear
     * @return int
     */
    public function getYear(): int {
        return $this->year;
    }

    /**
     * setYear
     * @param int $year
     * @throws OutOfBoundsException
     */
    public function setYear(int $year) {
        $saveYear = filter_var($year, FILTER_SANITIZE_NUMBER_INT);
        // comic industry probably won't exist in 2100--I know I won't
        if ($saveYear >= 1930 && $saveYear <= 2100) {
            $this->year = $saveYear;
        } else {
            throw new OutOfBoundsException("This is not a valid year");
        }
    }

    /**
     * getMonth
     * @return int
     */
    public function getMonth(): int {
        return $this->month;
    }

    /**
     * setMonth
     * @param int $month
     * @throws OutOfBoundsException
     */
    public function setMonth(int $month) {
        $saveMonth = filter_var($month, FILTER_SANITIZE_NUMBER_INT);
        if ($saveMonth >= 1 && $saveMonth <= 12) {
            $this->month = $saveMonth;
        } else {
            throw new OutOfBoundsException("This is not a valid month");
        }
    }

    /**
     * getIssue
     * @return int
     */
    public function getIssue(): int {
        return $this->issue;
    }

    /**
     * setIssue
     * @param int $issue
     * @throws OutOfBoundsException
     */
    public function setIssue(int $issue) {
        $saveIssue = filter_var($issue, FILTER_SANITIZE_NUMBER_INT);
        if ($saveIssue >= 0) {
            $this->issue = $saveIssue;
        } else {
            throw new OutOfBoundsException("This is not a valid issue number");
        }
    }
    
    /**
     * getStory
     * @return string
     */
    public function getStory(): string {
        return $this->story;
    }

    /**
     * setStory
     * @param string $story
     * @throws OutOfBoundsException
     */
    public function setStory(string $story) {
        if (strlen($story) <= 1000) {
            $this->story = htmlspecialchars(strip_tags(trim($story)));
        } else {
            throw new OutOfBoundsException("Story title too long--must be 1,000 characters or less");
        }
    }

    /**
     * getNotes
     * @return string
     */
    public function getNotes(): string {
        return $this->notes;
    }

    /**
     * setNotes
     * @param string $notes
     */
    public function setNotes(string $notes) {
        $this->notes = htmlspecialchars(strip_tags(trim($notes)));
    }

    /**
     * getStars
     * @return int
     */
    public function getStars(): int {
        return $this->stars;
    }
    
    /**
     * getStarSvgs
     * @return string
     */
    public function getStarSvgs(): string {
        $filled = str_repeat('<i class="bi bi-star-fill"></i>', $this->getStars());
        $unfilled = str_repeat('<i class="bi bi-star"></i>', 5 - ($this->getStars()));
        return $filled . $unfilled;
    }
    
    /**
     * setStars
     * @param int $stars
     * @throws OutOfBoundsException
     */
    public function setStars(int $stars) {
        $saveStars = filter_var($stars, FILTER_SANITIZE_NUMBER_INT);
        if ($saveStars >= 0 && $saveStars <= 5) {
            $this->stars = $saveStars; // 0 = not rated            
        } else {
            throw new OutOfBoundsException("This is not a valid rating");
        }
    }

    /**
     * setHardCopy
     * @param bool $hardCopy
     */
    public function setHardCopy(bool $hardCopy) {
        $this->hardCopy = $hardCopy;
    }

    /**
     * getHardCopy
     * @return bool
     */
    public function getHardCopy(): bool {
        return $this->hardCopy;
    }

    /**
     * setWantList
     * @param bool $wantList
     */
    public function setWantList(bool $wantList) {
        $this->wantList = $wantList;
    }

    /**
     * getWantList
     * @return bool
     */
    public function getWantList(): bool {
        return $this->wantList;
    }

    /**
     * loadComicById
     * @param object $pdo
     * @param int $id
     * @throws Exception
     */
    public function loadComicById(object $pdo, int $id) {
        $sql = 'SELECT * FROM Comics WHERE Id = :Id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($id));
        $comic = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($comic)) {
            $this->id = $comic[0]['Id'];
            $this->titleId = $comic[0]['TitleId'];
            $this->issue = $comic[0]['Issue'];
            $this->month = $comic[0]['Month'];
            $this->year = $comic[0]['Year'];
            $this->story = $comic[0]['Story'];
            $this->notes = $comic[0]['Notes'];
            $this->hardCopy = $comic[0]['HardCopy'];
            $this->wantList = $comic[0]['WantList'];
            $this->stars = $comic[0]['Stars'];
            $this->loadScripters($pdo, $id);
            $this->loadArtists($pdo, $id);
        } else {
            throw new Exception("This comic does not exist");
        }
    }
    
    /**
     * setScripter
     * May be called multiple times for books with > 1 writer
     * @param object $pdo
     * @param int $creatorId
     * @throws Exception
     */
    public function setScripter(object $pdo, int $creatorId) {
        if ($this->id) {
            $sql = 'INSERT INTO ScriptBy (ComicId, CreatorId) VALUES (:ComicId, :CreatorId)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->id, $creatorId));
            // reload
            $this->loadScripters($pdo, $this->id);
        } else {
            throw new Exception ("Comic must be saved before assigning creators");
        }
    }
    
    /**
     * setArtist
     * @param object $pdo
     * @param int $creatorId
     * @throws Exception
     */
    public function setArtist(object $pdo, int $creatorId) {
        if ($this->id) {
            $sql = 'INSERT INTO ArtBy (ComicId, CreatorId) VALUES (:ComicId, :CreatorId)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->id, $creatorId));
            // reload
            $this->loadArtists($pdo, $this->id);
        } else {
            throw new Exception ("Comic must be saved before assigning creators");
        }        
    }
    
    /**
     * loadScripters
     * @param object $pdo
     * @param int $comicId
     */
    private function loadScripters(object $pdo, int $comicId) {
        $this->scripters = array();  // reset and reload
        $sql = 'SELECT CreatorId FROM ScriptBy WHERE ComicId = :ComicId';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($comicId));
        $scripters = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($scripters as $scripter) {
            $scriptBy = new Creator();
            $scriptBy->loadCreatorById($pdo, $scripter['CreatorId']);
            $this->scripters[] = $scriptBy;
        }
    }
    
    /**
     * getScriptersToString
     * Returns scripter names as comma-delimited string for screen display.
     * @return string
     */
    public function getScriptersToString(): string {
        $list = '';
        foreach ($this->scripters as $scripter) {
            $list .= $scripter->getFullName() . ', ';
        }
        return substr($list, 0, -2);
    }
    
    /**
     * getArtistsToString
     * Returns artist names as comma-delimited string for screen display.
     * @return string
     */
    public function getArtistsToString(): string {
        $list = '';
        foreach ($this->artists as $artist) {
            $list .= $artist->getFullName() . ', ';
        }
        return substr($list, 0, -2);
    }
    
    /**
     * loadArtists
     * @param object $pdo
     * @param int $comicId
     */
    private function loadArtists(object $pdo, int $comicId) {
        $this->artists = array();  // reset
        $sql = 'SELECT CreatorId FROM ArtBy WHERE ComicId = :ComicId';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($comicId));
        $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($artists as $artist) {
            $artBy = new Creator();
            $artBy->loadCreatorById($pdo, $artist['CreatorId']);
            $this->artists[] = $artBy;
        }
    }    
    
    /**
     * saveComic
     * Handles INSERTS and UPDATES To Comics table
     * @param object $pdo
     * @return type
     */
    public function saveComic(object $pdo) {
        $params = array();
        $params[] = $this->titleId;
        $params[] = $this->issue;
        $params[] = $this->month;
        $params[] = $this->year;
        $params[] = $this->story;
        $params[] = $this->notes;
        $params[] = $this->hardCopy;
        $params[] = $this->wantList;
        $params[] = $this->stars;
        if ($this->id) {        
            $sql = 'UPDATE Comics SET '
                    . 'TitleId = :TitleId, '
                    . 'Issue = :Issue, '
                    . 'Month = :Month, '
                    . 'Year = :Year, '
                    . 'Story = :Story, '
                    . 'Notes = :Notes, '
                    . 'HardCopy = :HardCopy, '
                    . 'WantList = :WantList , '
                    . 'Stars = :Stars '
                    . 'WHERE Id = :Id';
                $params[] = $this->id;
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
        } else {            
            $sql = 'INSERT INTO Comics ('
                    . 'TitleId, '
                    . 'Issue, '
                    . 'Month, '
                    . 'Year, '
                    . 'Story, '
                    . 'Notes, '
                    . 'HardCopy, '
                    . 'WantList, '
                    . 'Stars) VALUES ('
                    . ':TitleId, '
                    . ':Issue, '
                    . ':Month, '
                    . ':Year, '
                    . ':Story, '
                    . ':Notes, '
                    . ':HardCopy, '
                    . ':WantList, '
                    . ':Stars)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $this->id = (int)$pdo->lastInsertId();
        }        
        return $this->id;  // don't really need to return this if it's in the object...
    }
    
    /**
     * getComicsTable
     * 
     * Generates HTML for table of comics w/edit and delete controls
     * 
     * @param object $pdo
     * @return string
     */
    public static function getComicsTable(object $pdo): string {
        $table = '<table id="comicsListTable" class="table table-sm table-bordered">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th class="actionColumn text-center" data-orderable="false">Actions</th>';
        $table .= '<th>Name</th>';
        $table .= '<th class="text-center">Issue</th>';
        $table .= '<th class="text-center">Year</th>';
        $table .= '<th class="text-center">Volume</th>';
        $table .= '<th>Publisher</th>';
        $table .= '<th class="text-center">Want List?</th>';
        $table .= '<th class="text-center">Format</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        foreach ($pdo->query('SELECT * FROM vwComicInfo ORDER BY [Name], Year, Issue ASC') as $comic) {
            $editBtn = '<a href="/admin/comics/edit/' . $comic['Id'] . '/" class="btn btn-sm btn-info" id="btnEdit_' . $comic['Id'] . '">Edit</a>';
            $deleteBtn = '<input type="button" class="btn btn-sm btn-danger deleteComic" id="btnDelete_' . $comic['Id'] . '" value="Delete">';
            $table .= '<tr>';
            $table .= '<td class="text-center">' . $editBtn . '&nbsp;' . $deleteBtn . '</td>';
            $table .= '<td>' . $comic['Name'] . '</td>';
            $table .= '<td class="text-center">' . $comic['Issue']. '</td>';
            $table .= '<td class="text-center">' . $comic['Year']. '</td>';
            $table .= '<td class="text-ceneter">' . $comic['Volume'] . '</td>';
            $table .= '<td>' . $comic['Publisher'] . '</td>';
            $table .= '<td class="text-center">' . $comic['WantListYN'] . '</td>';
            $table .= '<td class="text-center">' . $comic['FormatType'] . '</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }
    
    /**
     * deleteComic
     * 
     * @param object $pdo
     * @param int $comicId  Comic.Id (primary key)
     * @return void
     */
    public static function deleteComic(object $pdo, int $comicId): void {
        $sql = 'DELETE FROM Comics WHERE Id = :Id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($comicId));
    }
    
    /**
     * deleteCreators
     * @param object $pdo
     * @param int $comicId
     * @return void
     */
    public function deleteCreators(object $pdo, int $comicId): void {
        // reset object arrays
        $this->scripters = array();
        $this->artists = array();
        $sql1 = 'DELETE FROM ScriptBy WHERE ComicId = ?';
        $sql2 = 'DELETE FROM ArtBy WHERE ComicId = ?';
        $stmt1 = $pdo->prepare($sql1);
        $stmt2 = $pdo->prepare($sql2);
        $stmt1->execute(array($comicId));
        $stmt2->execute(array($comicId));
    }
}
