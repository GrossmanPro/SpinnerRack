<?php

require_once 'Setup.php';

$comicId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$comic = new Comic();
$comic->loadComicById($pdo, $comicId);

$hardCopyChecked = ($comic->getHardCopy()) ? 'checked' : '';
$wantListChecked = ($comic->getWantList()) ? 'checked' : '';

$titleOptions = getSelectListOptions($pdo, 'Titles', 'OptionText', $comic->getTitleId());


print drawHeader('Admin: Edit Comic');
?>
<div class="container pt-4">
    <p class="h4">Edit Comic</p>
    <form id="comicInput" method="post" action="/added">
        <?php print $tokenTag; ?>
        <div class="row mb-3">
            <div class="form-floating col-md-6">
                <select class="form-select" id="title" name="title" title="Comic title" autofocus>
                    <?php print $titleOptions; ?>
                </select>
                <label for="title">&nbsp;&nbsp;Title</label>
            </div>
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" id="issue" name="issue" title="Issue number" required>
                <label for="issue">&nbsp;&nbsp;Issue No</label>
            </div>  
            <div class="form-floating col-md-2">
                <select class="form-select" id="month" name="month" title="Month of publication">
                    <option value="1">JAN</option>
                    <option value="2">FEB</option>
                    <option value="3">MAR</option>
                    <option value="4">APR</option>
                    <option value="5">MAY</option>
                    <option value="6">JUN</option>
                    <option value="7">JUL</option>
                    <option value="8">AUG</option>
                    <option value="9">SEP</option>
                    <option value="10">OCT</option>
                    <option value="11">NOV</option>
                    <option value="12">DEC</option>
                </select>
                <label for="month">&nbsp;&nbsp;Cover month</label>
            </div>
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" id="year" name="year" maxlength="4" min="1930" max="2100" title="Year of publication" value="<?php print $comic->getYear(); ?>" required>
                <label for="year">&nbsp;&nbsp;Year</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-floating col-md-6">
                <input type="text" class="form-control" id="story" name="story" title="Story" value="<?php print $comic->getStory(); ?>" required>
              <label for="story">&nbsp;&nbsp;Story</label>
            </div>              
            <div class="form-floating col-md-2">
                <select class="form-select" id="stars" name="stars" title="Comic rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <label for="stars">&nbsp;&nbsp;Rating</label>
            </div>
            <div class="form-check col-md-2">
                <input class="form-check-input" type="checkbox" value="" id="wantList" name="wantList" <?php print $wantListChecked; ?>>
                <label class="form-check-label" for="wantList">&nbsp;&nbsp;Add to want list?</label>
            </div>
            <div class="form-check col-md-2">
                <input class="form-check-input" type="checkbox" value="" id="hardCopy" name="hardCopy" <?php print $hardCopyChecked; ?>>
                <label class="form-check-label" for="hardCopy">&nbsp;&nbsp;Hard copy?</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-floating col-md-6">
                <textarea class="form-control" rows="4" id="notes" name="notes" title="Story notes"><?php print $comic->getNotes(); ?></textarea>
                <label for="notes">&nbsp;&nbsp;Notes</label>
            </div>                      
        </div>    
        <div class="row mb-3">
            <div class="form-floating col-md-3">
                <select class="form-select" id="scripters" name="scripters" title="Comic scripter or scripters">
                    <?php print $creatorOptions; ?>
                </select>
                <label for="title">Writer(s)</label>
                <div id="scripterList"></div>
            </div>
            <div class="form-floating col-md-3">
                <select class="form-select" id="artists" name="artists" title="Comic artist or artists">
                    <?php print $creatorOptions; ?>
                </select>
                <label for="title">Artist(s)</label>
                <div id="artistList"></div>
            </div>
            <div class="col-md-1">
                <input type="button" class="btn btn-primary" id="submitComic" value="Save Comic">
            </div>
        </div>
    </form>
</div>
<?php
print drawFooter(array('ComicFormView-01.js'));
