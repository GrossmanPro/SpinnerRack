<?php

require_once 'Setup.php';
print drawHeader('Collection View');

$table = Comic::getComicsTable($pdo);

$comicList = <<<EOD
<div class="container pt-4">
<p class="h4">Comics: List</p>
$table
</div>
EOD;

print $comicList;

print drawFooter(array('ComicList.js'));