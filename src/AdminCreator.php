<?php
require_once 'Setup.php';
print drawHeader('Admin: Creators');  

if (array_key_exists('status', $_GET)) {
    // show save ok message
}

$addForm = <<<EOD
<div class="container pt-4">
<p class="h4">Admin: Creators</p>
<form id="comicInput" method="post" action="/admin/save">
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
    <input type="submit" class="btn btn-primary" value="Add" title="Add creator">
</div>
</div>
</form>
EOD;

print $addForm;
print Creator::getCreatorTable($pdo);
print '</div>';
print drawFooter(array('AdminCreator.js'));

