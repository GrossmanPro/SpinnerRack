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
    } else {
        $publisher = new Publisher();
        $publisher->setPublisherName($publisherName);
        $publisher->savePublisher($pdo);
    }
    header('Location: /admin/publishers/ok');
} catch (Exception $e) {
    header('Location: GeneralError.php');
}
