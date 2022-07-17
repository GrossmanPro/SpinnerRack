<?php
require_once 'Setup.php';

print drawHeader('Admin: Creators'); 


$creatorId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$creator = new Creator();
$creator->loadCreatorById($pdo, $creatorId);
 

$addForm = <<<EOD
<div class="container pt-4">
<p class="h4">Admin: Creators</p>
<form id="creatorInput" method="post" action="/admin/creators/save">
$tokenTag
<div class="row mb-3 align-items-center">
<div class="form-floating col-md-4">
    <input type="text" class="form-control" id="firstName" name="firstName" title="Creator first name" required>
    <label for="firstName">First Name</label>
</div>  
<div class="form-floating col-md-4">
    <input type="text" class="form-control" id="lastName" name="lastName" title="Creator last name" required>
    <label for="lasttName">Last Name</label>
</div>  
<div class="col-md-1">
    <input type="submit" class="btn btn-primary" value="Save" title="Save creator">
</div>
</div>
</form>
EOD;

print drawFooter();
