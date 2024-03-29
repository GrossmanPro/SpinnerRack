<?php
require_once 'Setup.php';

// test or csrf
if (requestIsPost() && !csrfTokenIsValid()) {
    error_log('Bad CSRF token in AdminPublisherController.php');
    header('Location: GeneralError.php');
    exit;    
} 

$publisherName = filter_input(INPUT_POST, 'publisherName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

try {
    if (array_key_exists('deleteId', $_POST)) {
        $publisherId = filter_input(INPUT_POST, 'deleteId', FILTER_SANITIZE_NUMBER_INT);
        Publisher::deletePublisher($pdo, $publisherId);
        header('Location: /admin/publishers/deleted');
    } else if (array_key_exists('editId', $_POST)) {
        $publisherId = filter_input(INPUT_POST, 'editId', FILTER_SANITIZE_NUMBER_INT);
        $publisher = new Publisher();
        $publisher->loadPublisherById($pdo, $publisherId);
        $publisher->setPublisherName($publisherName);
        $publisher->savePublisher($pdo);
        header('Location: /admin/publishers/saved');
    } else {
        $publisher = new Publisher();
        $publisher->setPublisherName($publisherName);
        $publisher->savePublisher($pdo);
        header('Location: /admin/publishers/added');

    }
    } catch (Exception $e) {
    header('Location: GeneralError.php');
}
