<?php

require_once 'Setup.php';
print drawHeader('Admin: Comics');

$table = Comic::getComicsTable($pdo);

if (array_key_exists('status', $_GET)) {
    $action = FILTER_INPUT(INPUT_GET, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
    print '<div class="alert alert-success text-center"><strong>Comic record ' . $action . '</strong></div>';
} 

$titleOptions = getSelectListOptions($pdo, 'Titles', 'OptionText');
$creatorOptions = getSelectListOptions($pdo, 'Creators', 'OptionText');
$starOptions = getStarOptions();
$monthOptions = getMonthOptions();

$comicAddForm = <<<EOFORM
<div class="container pt-4">
    <p class="h4">Add New Comic</p>
    <form id="comicInput" method="post" action="/admin/comics/save">
        $tokenTag
        <div class="row mb-3">
            <div class="form-floating col-md-6">
                <select class="form-select" id="title" name="title" title="Comic title" autofocus>
                    $titleOptions
                </select>
                <label for="title">&nbsp;&nbsp;Title</label>
            </div>
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" id="issue" name="issue" title="Issue number" required>
                <label for="issue">&nbsp;&nbsp;Issue No</label>
            </div>  
            <div class="form-floating col-md-2">
                <select class="form-select" id="month" name="month" title="Month of publication">
                    $monthOptions
                </select>
                <label for="month">&nbsp;&nbsp;Cover month</label>
            </div>
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" id="year" name="year" maxlength="4" min="1930" max="2100" title="Year of publication" required>
                <label for="year">&nbsp;&nbsp;Year</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-floating col-md-6">
              <input type="text" class="form-control" id="story" name="story" title="Story" req uired>
              <label for="story">&nbsp;&nbsp;Story</label>
            </div>              
            <div class="form-floating col-md-2">
                <select class="form-select" id="stars" name="stars" title="Comic rating">
                    $starOptions
                </select>
                <label for="stars">&nbsp;&nbsp;Rating</label>
            </div>
            <div class="form-check col-md-2">
                <input class="form-check-input" type="checkbox" value="" id="wantList" name="wantList">
                <label class="form-check-label" for="wantList">
                  Add to want list?
                </label>
            </div>
            <div class="form-check col-md-2">
                <input class="form-check-input" type="checkbox" value="" id="hardCopy" name="hardCopy">
                <label class="form-check-label" for="hardCopy">
                  Hard copy?
                </label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-floating col-md-6">
                <textarea class="form-control" rows="4" id="notes" name="notes" title="Story notes"></textarea>
                <label for="notes">&nbsp;&nbsp;Notes</label>
            </div>                      
        </div>    
        <div class="row mb-3">
            <div class="form-floating col-md-3">
                <select class="form-select" id="scripters" name="scripters" title="Comic scripter or scripters">
                    $creatorOptions
                </select>
                <label for="title">&nbsp;&nbsp;Writer(s)</label>
                <div id="scripterList"></div>
            </div>
            <div class="form-floating col-md-3">
                <select class="form-select" id="artists" name="artists" title="Comic artist or artists">
                    $creatorOptions 
                </select>
                <label for="title">&nbsp;&nbsp;Artist(s)</label>
                <div id="artistList"></div>
            </div>
            <div class="col-md-1">
                <input type="button" class="btn btn-primary" id="submitComic" value="Save Comic">
            </div>
        </div>
    </form>
</div>
EOFORM;

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

print $comicAddForm;
print $comicList;

print drawFooter(array('AdminComics-01.js', 'ComicFormView-01.js'));
