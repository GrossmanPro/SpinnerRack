<?php
require_once 'DbConfig.php';
require_once 'DbConn.php';

require_once 'Publisher.php';
require_once 'Title.php';
require_once 'Creator.php';
require_once 'Comic.php';


// print_r($_POST);
// Array ( 
// [title] => 134 
// [issue] => 2 
// [month] => 1 
// [year] => 1970 
// [story] => Story goes here 
// [stars] => 1 
// [notes] => Notes go here 
// [scripters] => 43 
// [artists] => 43 )
extract($_POST); // filtered by Comic object methods
$comic = new Comic();
$comic->setTitleId($title);
$comic->setIssue($issue);
$comic->setMonth($month);
$comic->setStars($stars);
$comic->setStory($story);
$comic->setNotes($notes);
$comic->saveComic($pdo);
$comic->setScripter($pdo, $artists);
$comic->setArtist($pdo, $artists);
print 'SAVED!';





