<?php

// load after DbConfig.php and DbConn.php




function getSelectListOptions(object $pdo, string $table, string $orderBy): string {
    $sql = 'SELECT * FROM ' . $table . 'OptionTags ORDER BY ' . $orderBy;
    // remove trailing comma and get results  
    $results = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
    $options = '';
    foreach ($results as $result) {
        $options .= '<option value="' . $result['OptionValue'] . '">' . $result['OptionText'] . '</option>';
    }
    return $options;
}

