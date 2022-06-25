<?php
// this file would more or less be the controller  
// decides what to do, then passes results through ajax back to view

//namespace src;
require_once 'DbConfig.php';
require_once 'DbConn.php';
require_once 'Creator.php';

$dbConn = new DbConn($dsn, $username, $password);
$connected = $dbConn->connect();

if ($connected) {    
    $creator = new Creator($dbConn->connection);
    $creator->setFirstName("Stan");
    $creator->setLastName("Lee");
    $creator->saveCreator();
    print "I just saved " . $creator->getFullName();
} else {
    print 'oh, f***';
}