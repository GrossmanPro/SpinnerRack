<?php
require_once 'DbConfig.php';
require_once 'DbConn.php';

require_once 'Publisher.php';
require_once 'Title.php';
require_once 'Creator.php';
require_once 'Comic.php';


extract($_POST); // filtered by Comic object methods

try {
    $comic = new Comic();
    $comic->setTitleId($title);
    $comic->setIssue($issue);
    $comic->setMonth($month);
    $comic->setStars($stars);
    $comic->setStory($story);
    $comic->setNotes($notes);
    $comic->saveComic($pdo);

    $scripters = array_unique(array_filter($_POST, function($key) {
        return stripos($key, 'scripter_')!== false;
    }, ARRAY_FILTER_USE_KEY));                           

    if (count($scripters)) {
        foreach ($scripters as $key => $val) {
            $comic->setScripter($pdo, $val);
        }
    }

    $artists = array_unique(array_filter($_POST, function($key) {
        return stripos($key, 'artist_') !== false;
    }, ARRAY_FILTER_USE_KEY));

    if (count($artists)) {
        foreach ($artists as $key => $val) {
            $comic->setArtist($pdo, $val);
        }
    }
} catch (Exception $ex) {
    error_log($ex->getMessage());
    error_log($ex->getTraceAsString());
    header('Location: GeneralError.php');
}
print 'SAVED!';





