<?php
// this file would more or less be the controller  
// decides what to do, then passes results through ajax back to view
namespace src;
require 'DbConnection.php';
require 'Creator.php';

$dsn = "sqlsrv:Server=DESKTOP-6PN824R\SQLEXPRESS;Database=SpinnerRack;";
$username = "SpinnerRackUser";
$password = "password";

$dbConn = new DbConnection($dsn, $username, $password);
$connected = $dbConn->connect();

if ($connected) {    
    $creator = new Creator($dbConn->connection);
    $creator->setFirstName("John");
    $creator->setLastName("Byrne");
    $creator->saveCreator();
    print "I just saved " . $creator->getFullName();
} else {
    print 'oh, f***';
}