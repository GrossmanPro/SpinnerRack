<?php

require_once 'Setup.php';

print drawHeader('Admin: Edit Title'); 

$titleId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$title = new Title();
$title->loadTitleById($pdo, $titleId);
$name = $title->getName();
$year = $title->getStartYear();
$volume = $title->getVolume();
$selectListOptions = getSelectListOptions($pdo, 'Publishers', 'OptionText', $title->getPublisherId());

$editForm = <<< eod
<div class="container pt-4">
<p class="h4">Admin: Titles</p>
<form id="titleInput" method="post" action="/admin/titles/save">
$tokenTag
<input type="hidden" name="editId" value="$titleId">
        <div class="row mb-3">
            <div class="form-floating col-md-6">
                  <input type="text" class="form-control" id="comicTitle" name="comicTitle" title="Title of comic" value="$name" required>
                  <label for="comicTitle">&nbsp;&nbsp;Comic Title</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-floating col-md-3">
                <select class="form-select" id="comicPublisher" name="comicPublisher" title="Publisher">
                    $selectListOptions
                </select>
                <label for="comicPublisher">&nbsp;&nbsp;Publisher</label>
            </div>
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" id="comicYear" name="comicYear" maxlength="4" min="1930" max="2100" title="Year of first publication" value="$year" required>
                <label for="comicYear">&nbsp;&nbsp;Start Year</label>
            </div>
            <div class="form-floating col-md-1">
                <input type="text" class="form-control" id="comicVolume" name="comicVolume" maxlength="2" min="1" max="10" title="Volume of comic title" value="$volume" required>
                <label for="comicVolume">&nbsp;&nbsp;Volume</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-1">
                <input type="submit" class="btn btn-primary" value="Save" title="Edit title">   
            </div>
        </div>
</form>
eod;

print $editForm;
print drawFooter();
