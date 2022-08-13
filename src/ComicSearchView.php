<?php

require_once 'Setup.php';

$titleOptions = getSelectListOptions($pdo, 'Titles', 'OptionText');
$creatorOptions = getSelectListOptions($pdo, 'Creators', 'OptionText');

print drawHeader('Find a Comic');
?>
<div class="container pt-4">
    <p class="h4">Add New Comic</p>
    <form id="comicInput" method="post" action="/added">

    </form>
</div>
<?php
print drawFooter();