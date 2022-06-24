<?php
// this file would more or less be the controller  
// decides what to do, then passes results through ajax back to view
namespace src;
require 'DbConfig.php';
require 'DbConnection.php';
require 'Creator.php';



$dbConn = new DbConnection($dsn, $username, $password);
$connected = $dbConn->connect();

if ($connected) {    
    $creator = new Creator($dbConn->connection);
    $creator->setFirstName("Jim");
    $creator->setLastName("Starlin");
    $creator->saveCreator();
    print "I just saved " . $creator->getFullName();
} else {
    print 'oh, f***';
}