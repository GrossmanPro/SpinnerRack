<?php

require_once 'Setup.php';

// test for csrf
if (requestIsPost() && !csrfTokenIsValid()) {
    error_log('Bad CSRF token in AdminTitleController.php');
    header('Location: GeneralError.php');
    exit;    
} 

extract($_POST);

try {
    if (array_key_exists('deleteId', $_POST)) {
        $titleId = filter_input(INPUT_POST, 'deleteId', FILTER_SANITIZE_NUMBER_INT);
        Title::deleteTitle($pdo, $titleId);  
        header('Location: /admin/titles/deleted');
    } else if (array_key_exists('editId', $_POST)) {
        $titleId = filter_input(INPUT_POST, 'editId', FILTER_SANITIZE_NUMBER_INT);
        $title = new Title();
        $title->loadTitleById($pdo, $titleId);
        $title->setName($comicTitle);
        $title->setPublisherId($comicPublisher);
        $title->setStartYear($comicYear);
        $title->setVolume($comicVolume);
        $title->saveTitle($pdo);     
        header('Location: /admin/titles/saved');
    } else {
        $title = new Title();
        $title->setName($comicTitle);
        $title->setPublisherId($comicPublisher);
        $title->setStartYear($comicYear);
        $title->setVolume($comicVolume);
        $title->saveTitle($pdo);        
        header('Location: /admin/titles/added');
    }
    
} catch (Exception $e) {
    header('Location: GeneralError.php');
}
