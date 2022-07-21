<?php
//TODO Remove code island and organize like AdminPublisher.php
require_once 'Setup.php';
print drawHeader('Admin: Titles');  
print '<div class="container pt-4">';
    
if (array_key_exists('status', $_GET)) {
    if ($_GET['status']== 'ok') {
        print '<div class="alert alert-success text-center"><strong>Title record changed</strong></div>';
    }
    if ($_GET['status'] == 'okNew') {
        print '<div class="alert alert-success text-center"><strong>Title record added</strong></div>';        
    }
}    
?>
    <p class="h4">Admin: Titles</p>
    <form id="titleInput" method="post" action="/admin/titles/save"> 
        <?php print $tokenTag; ?>
        <div class="row mb-3">
            <div class="form-floating col-md-6">
                  <input type="text" class="form-control" id="comicTitle" name="comicTitle" title="Title of comic" required>
                  <label for="comicTitle">&nbsp;&nbsp;Comic Title</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-floating col-md-3">
                <select class="form-select" id="comicPublisher" name="comicPublisher" title="Publisher">
                    <?php print getSelectListOptions($pdo, 'Publishers', 'OptionText'); ?>
                </select>
                <label for="comicPublisher">&nbsp;&nbsp;Publisher</label>
            </div>
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" id="comicYear" name="comicYear" maxlength="4" min="1930" max="2100" title="Year of first publication" required>
                <label for="comicYear">&nbsp;&nbsp;Start Year</label>
            </div>
            <div class="form-floating col-md-1">
                <input type="text" class="form-control" id="comicVolume" name="comicVolume" maxlength="2" min="1" max="10" title="Volume of comic title" required>
                <label for="comicVolume">&nbsp;&nbsp;Volume</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-1">
                <input type="submit" class="btn btn-primary" value="Add" title="Add title">   
            </div>
        </div>
    </form>
    <form id="titleDelete" method="post" action="/admin/titles/save">
        <?php print $tokenTag; ?>
        <input type="hidden" id="deleteId" name="deleteId" value="0">
    </form>
<?php
print Title::getTitlesTable($pdo);
print '</div>';
print drawFooter(array('AdminTitle.js'));
