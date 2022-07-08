<?php
if (session_id() == '' || session_id() === false) {
   session_start();
}
require_once 'DbConfig.php';
require_once 'DbConn.php';

require_once 'Publisher.php';
require_once 'Title.php';
require_once 'Creator.php';
require_once 'Comic.php';
require_once 'FormHelpers.php';
require_once 'AntiCsrf.php';

if (empty($_SESSION['csrfToken'])) {
   $token = createCsrfToken();
   $tokenTag = '<input type="hidden" name="csrfToken" value="' . $token . '">'; 
} else {
    $tokenTag = '<input type="hidden" name="csrfToken" value="' . $_SESSION['csrfToken'] . '">';     
}
