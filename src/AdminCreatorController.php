<?php
require_once 'Setup.php';

// test or csrf
if (requestIsPost() && !csrfTokenIsValid()) {
    error_log('Bad CSRF token in AdminCreatorController.php');
    header('Location: GeneralError.php');
    exit;    
} 

$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

try {
    if (array_key_exists('deleteId', $_POST)) {
        $creatorId = filter_input(INPUT_POST, 'deleteId', FILTER_SANITIZE_NUMBER_INT);
        Creator::deleteCreator($pdo, $creatorId);
        header('Location: /admin/creators/deleted');
    } else if (array_key_exists('editId', $_POST)) {
        $creatorId = filter_input(INPUT_POST, 'editId', FILTER_SANITIZE_NUMBER_INT);
        $creator = new Creator();
        $creator->loadCreatorById($pdo, $creatorId);
        $creator->setFirstName($firstName);
        $creator->setLastName($lastName);
        $creator->saveCreator($pdo);
        header('Location: /admin/creators/saved');
    } else {
        $creator = new Creator();
        $creator->setFirstName($firstName);
        $creator->setLastName($lastName);
        $creator->saveCreator($pdo);    
        header('Location: /admin/creators/added');    
    }
} catch (Exception $e) {
    header('Location: GeneralError.php');
}
