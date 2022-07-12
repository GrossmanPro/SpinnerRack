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
    $creator = new Creator();
    $creator->setFirstName($firstName);
    $creator->setLastName($lastName);
    $creator->saveCreator($pdo);
    header('Location: /admin/creators/');
} catch (Exception $e) {
    header('Location: GeneralError.php');
}
