<?php

require_once 'Setup.php';

$titleOptions = getSelectListOptions($pdo, 'Titles', 'OptionText');
$creatorOptions = getSelectListOptions($pdo, 'Creators', 'OptionText');

print drawHeader('Find a Comic');
?>
<div class="container pt-4">
    <p class="h4">Find a Comic</p>
    <form id="comicSearch" method="post" action="/search/results"> 
        <div class="row mb-3">
            <div class="form-floating col-md-4">
                <input type="text" class="form-control" id="keyword" name="keyword" title="Enter a keyword">
                <label for="issue">Keyword</label>
            </div>  
            <div class="col-md-1">
                <input type="submit" class="btn btn-primary" id="submitComic" value="Find">
            </div>
        </div>
    </form>
</div>
<?php
print drawFooter();