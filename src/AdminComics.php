<?php

require_once 'Setup.php';
print drawHeader('Admin: Comics');

$table = Comic::getComicsTable($pdo);

$comicList = <<<EOD
<div class="container pt-4">
<p class="h4">Comics: List</p>
$table
</div>
<form id="comicDelete" method="post" action="/admin/comics/save">
    $tokenTag
    <input type="hidden" id="deleteId" name="deleteId" value="0">
</form>
EOD;

print $comicList;

print drawFooter(array('AdminComics-01.js'));
