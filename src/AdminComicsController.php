<?php
require_once 'Setup.php';

//Array ( [csrfToken] => XonZ8NUvfs8oaQm0w3A= 
//[title] => 149 [issue] => [month] => 1 
//[year] => 1970 [story] => The Coming of Blargh [stars] => 1 
//[hardCopy] => [notes] => [scripters] => 242 [scripter_1659307738] => 37 
//[artists] => 40 [artist_1659307738] => 6 )

// test for csrf
if (requestIsPost() && !csrfTokenIsValid()) {
    error_log('Bad CSRF token in AdminComicController.php');
    header('Location: GeneralError.php');
    exit;    
} 

extract($_POST);

try {
    if (array_key_exists('deleteId', $_POST)) {
        $id = filter_input(INPUT_POST, 'deleteId', FILTER_SANITIZE_NUMBER_INT);
        Comic::deleteComic($pdo, $id);        
        header('Location: /admin/comics/deleted');
    } else if (array_key_exists('editId', $_POST)) {
        $comicId = filter_input(INPUT_POST, 'editId', FILTER_SANITIZE_NUMBER_INT);
        $comic = new Comic();
        $comic->loadComicById($pdo, $comicId);
        $comic->setTitle($title);
        $comic->setIssue($issue);
        $comic->setMonth($month);
        $comic->setStory($story);
        $comic->setStars($stars);
        $comic->setNotes($notes);
        $comic->setWantList(array_key_exists('wantList', $_POST));
        $comic->setHardCopy(array_key_exists('hardCopy', $_POST));    
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
        header('Location: /admin/comics/saved');
    } else {
        $title = new Title();
        $title->setName($comicTitle);
        $title->setPublisherId($comicPublisher);
        $title->setStartYear($comicYear);
        $title->setVolume($comicVolume);
        $title->saveTitle($pdo);        
        header('Location: /admin/comics/added');
    }    
} catch (Exception $e) {
    header('Location: GeneralError.php');
}