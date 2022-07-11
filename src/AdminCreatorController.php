<?php
require_once 'Setup.php';

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
