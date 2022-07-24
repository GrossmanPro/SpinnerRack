<?php
require_once 'Setup.php';
print drawHeader('Admin: Publisher');  

$addForm = <<< eod
<div class="container pt-4">
<p class="h4">Admin: Publishers</p>
<form id="publisherInput" method="post" action="/admin/publishers/save">
$tokenTag
<div class="row mb-3 align-items-center">
<div class="form-floating col-md-4">
    <input type="text" class="form-control" id="publisherName" name="publisherName" title="Publisher name" required>
    <label for="firstName">Publisher Name</label>
</div>  
<div class="col-md-1">
    <input type="submit" class="btn btn-primary" value="Add" title="Add publisher">
</div>
</div>
</form>
<form id="publisherDelete" method="post" action="/admin/publishers/save">
        $tokenTag
        <input type="hidden" id="deleteId" name="deleteId" value="0">
</form> 
eod;

if (array_key_exists('status', $_GET)) {
    if ($_GET['status']== 'ok') {
        print '<div class="alert alert-success text-center"><strong>Publisher record changed</strong></div>';
    }
}

print $addForm;
print Publisher::getPublisherTable($pdo);
print '</div>';
print drawFooter(array('AdminPublisher-01.js'));