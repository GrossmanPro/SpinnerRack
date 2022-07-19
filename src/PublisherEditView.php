<?php
require_once 'Setup.php';

print drawHeader('Admin: Publishers'); 

$publisherId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$pub = new Publisher();
$pub->loadPublisherById($pdo, $publisherId);
$pubName = $pub->getPublisherName();

$editForm = <<< eod
<div class="container pt-4">
<p class="h4">Admin: Publishers</p>
<form id="publisherInput" method="post" action="/admin/publishers/save">
$tokenTag
<input type="hidden" name="editId" value="$publisherId">
<div class="row mb-3 align-items-center">
<div class="form-floating col-md-4">
    <input type="text" class="form-control" id="publisherName" name="publisherName" title="Publisher name" value="$pubName" required>
    <label for="publisherName">Publisher Name</label>
</div>  
<div class="col-md-1">
    <input type="submit" class="btn btn-primary" value="Add" title="Add publisher">
</div>
</div>
</form>
eod;

print $editForm;
print drawFooter();
