<?php

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
    
    public function __construct()
    {
        $id = 0;
        $titleId = 0;
        $year = 0;
        $month = 0;
        $issue = 0;
        $story = "";
        $notes = "";
        $stars = 0;
        $hardCopy = 1; // default to physical (vs digital)
        $wantList = 0; // default to owned comic
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getTitleId(): int {
        return $this->getTitleId();
    }
    
    public function setTitleId(int $titleId) {
        $this->titleId = filter_var($titleId, FILTER_SANITIZE_NUMBER_INT);
    }
    
    public function getYear(): int {
        return $this->year;
    }
    
    public function setYear(int $year) {
        $saveYear = filter_var($year, FILTER_SANITIZE_NUMBER_INT);
        // comic industry probably won't exist in 2100--I know I won't
        if ($saveYear >= 1930 && $saveYear <= 2100) {
            $this->year = $saveYear;
        } else {
            throw new OutOfBoundsException("This is not a valid year");
        }
    }
    
    public function getMonth(): int {
        return $this->month;
    }
    
    public function setMonth(int $month) {
        $saveMonth = filter_var($month, FILTER_SANITIZE_NUMBER_INT);
        if ($saveMonth >= 1 && $saveYear <= 12) {
            $this->month = $saveMonth;
        } else {
            throw new OutOfBoundsException("This is not a valid month");
        }
    }
    
    public function getIssue(): int {
        return $this->issue;
    }
    
    public function setIssue(int $issue) {
        $saveIssue= filter_var($issue, FILTER_SANITIZE_NUMBER_INT);
        if ($saveIssue >= 0) {
            $this->issue = $saveIssue;
        } else {
            throw new OutOfBoundsException("This is not a valid issue number");
        }
    }
    
    public function getStory(): string {
        return $this->story;
    }
    
    public function setStory(string $story) {
        if (strlen($story) <= 1000) {
            $this->story = filter_var($story, FILTER_SANITIZE_STRING);
        } else {
            throw new OutOfBoundsException("Story title too long--must be 1,000 characters or less");
        }
    }
    
    public function getNotes(): string {
        return $this->notes;
    }
    
    public function setNotes(string $notes) {
        $this->notes = filter_var($notes, FILTER_SANITIZE_STRING);
    }   
    
    public function getStars(): int {
        return $this->stars;
    }
    
    public function setStars(int $stars) {
        $saveStars = filter_var($stars, FILTER_SANITIZE_NUMBER_INT);
        if ($saveStars >= 0 && $saveStars <= 5) {
            $this->stars = $saveStars;
        } else {
            throw new OutOfBoundsException("This is not a valid rating");
        }
    }
    
    public function setHardCopy(bool $hardCopy) {
        $this->hardCopy = $hardCopy;
    }
    
    public function getHardCopy(): bool {
        return $this->hardCopy;
    }
    
    public function setWantList(bool $wantList) {
        $this->wantList = $wantList;
    }
    
    public function getWantList(): bool {
        return $this->wantList;
    }
    
   public function loadComicById(object $pdo, int $id) {
       $sql = 'SELECT * FROM Comics WHERE Id = :Id';
       $stmt = $pdo->prepare($sql);
       $stmt->execute(array($id));
       $comic = $stmt->fetchAll(PDO::FETCH_ASSOC);
       if (count($comic)) {           
           $this->id = $id;
           $this->titleId = $comic[0]['TitleId'];
           $this->issue = $comic[0]['Issue'];
           $this->month = $comic[0]['Month'];
           $this->year = $comic[0]['Year'];
           $this->story = $comic[0]['Story'];
           $this->notes = $comic[0]['Notes'];
           $this->hardCopy = $comic[0]['HardCopy'];
           $this->wantList = $comic[0]['WantList'];
       } else {
           throw new Exception("This comic does not exist");
       }
   }
   
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
       if ($this->id) {
           $sql = 'UPDATE Comics SET '
                   . 'TitleId = :TitleId, '
                   . 'Issue = :Issue, '
                   . 'Month = :Month, '
                   . 'Year = :Year, '
                   . 'Story = :Story, '
                   . 'Notes = :Notes, '
                   . 'HardCopy = :HardCopy, '
                   . 'WantList = :WantList '
                   . 'WHERE Id = :Id';
           $params[] = $this->id;
       } else {
           $sql = 'INSERT INTO Comics ('
                   . 'TitleId, '
                   . 'Issue, '
                   . 'Month, '
                   . 'Year, '
                   . 'Story, '
                   . 'Notes, '
                   . 'HardCopy, '
                   . 'WantList) VALUES ('
                   . ':TitleId, '
                   . ':Issue, '
                   . ':Month, '
                   . ':Year, '
                   . ':Story, '
                   . ':Notes, '
                   . ':HardCopy, '
                   . ':WantList)';
       }
       $stmt= $pdo->prepare($sql);
       $stmt->execute($params);
       return $this->id;
   }
    
    
}

