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
    
    
}

