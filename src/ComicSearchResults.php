<?php

require_once 'Setup.php';

$keyword = filter_input(INPUT_POST, 'keyword', FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "SELECT * FROM ComicSearchView "
        . "WHERE Story LIKE ? "
        . "OR Notes LIKE ? "
        . "OR Name LIKE ? "
        . "OR Publisher LIKE ?";
$params = array_fill(0, 4, '%' . $keyword . '%');
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

print drawHeader('Results');

print_r($results);


print drawFooter();
