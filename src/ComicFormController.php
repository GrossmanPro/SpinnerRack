<?php

require_once 'Setup.php';

// test for csrf
if (requestIsPost() && !csrfTokenIsValid()) {
    error_log('Bad CSRF token in ComicFormController.php');
    header('Location: GeneralError.php');
    exit;    
} 

extract($_POST); // filtered by Comic object methods

try {
    $comic = new Comic();
    $comic->setTitleId($title);
    $comic->setIssue($issue);
    $comic->setMonth($month);
    $comic->setStars($stars);
    $comic->setStory($story);
    $comic->setNotes($notes);
    
    if (array_key_exists('wantList', $_POST)) {
        $comic->setWantList(true);
    } else {
        $comic->setWantList(false);
    }
    
    if (array_key_exists('hardCopy', $_POST)) {
        $comic->setHardCopy(true);
    } else {
        $comic->setHardCopy(false);
    }
    
    $comic->saveComic($pdo);
    
    $scripters = array_unique(array_filter($_POST, function ($key) {
                return stripos($key, 'scripter_') !== false;
            }, ARRAY_FILTER_USE_KEY));

    if (count($scripters)) {
        foreach ($scripters as $key => $val) {
            $comic->setScripter($pdo, $val);
        }
    }

    $artists = array_unique(array_filter($_POST, function ($key) {
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

header("Location: /comics/" . $comic->getId() . "/view");