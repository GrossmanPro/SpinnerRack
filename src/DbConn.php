<?php

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (Exception $e) {
    print $e->getMessage();
    error_log($e->getMessage());
    error_log($e->getTraceAsString());

} catch (PDOException $p) {
    print $p->getMessage();
    error_log($p->getMessage());
    error_log($p->getTraceAsString());

}
        
   

