<?php
require_once 'Setup.php';
print drawHeader('Admin: Creators');  

$addForm = <<<EOD
<div class="container pt-4">
<p class="h4">Admin: Creators</p>
<form id="creatorInput" method="post" action="/admin/creators/save">
$tokenTag
<div class="row mb-3 align-items-center">
<div class="form-floating col-md-4">
    <input type="text" class="form-control" id="firstName" name="firstName" title="Creator first name" required>
    <label for="firstName">&nbsp;&nbsp;First Name</label>
</div>  
<div class="form-floating col-md-4">
    <input type="text" class="form-control" id="lastName" name="lastName" title="Creator last name" required>
    <label for="lasttName">&nbsp;&nbsp;Last Name</label>
</div>  
<div class="col-md-1">
    <input type="submit" class="btn btn-primary" value="Save" title="Save creator">
</div>
</div>
</form>
<form id="creatorDelete" method="post" action="/admin/creators/save">
        $tokenTag
        <input type="hidden" id="deleteId" name="deleteId" value="0">
</form>
<form id="creatorEdit" method="post" action="/admin/creators/save">
    $tokenTag
    <input type="hidden" id="editId" name="editId" value="0">
</form>
EOD;

if (array_key_exists('status', $_GET)) {
    if ($_GET['status']== 'ok') {
        print '<div class="alert alert-success text-center"><strong>Creator record changed</strong></div>';
    }
}

print $addForm;
print Creator::getCreatorTable($pdo);
print '</div>';
print drawFooter(array('AdminCreator.js'));

