<?php

require_once 'Setup.php';

$creatorOptions = getSelectListOptions($pdo, 'Creators', 'OptionText');
$comicId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$comic = new Comic();
$comic->loadComicById($pdo, $comicId);

// get form values for selected comic
$hardCopyChecked = ($comic->getHardCopy()) ? 'checked' : '';
$wantListChecked = ($comic->getWantList()) ? 'checked' : '';
$titleOptions = getSelectListOptions($pdo, 'Titles', 'OptionText', $comic->getTitleId());
$artists = getExistingCreatorDivs($comic, true);
$scripters = getExistingCreatorDivs($comic, false);
$starOptions = getStarOptions($comic->getStars());
$monthOptions = getMonthOptions($comic->getMonth()); 

print drawHeader('Admin: Edit Comic');
?>
<div class="container pt-4">
    <p class="h4">Edit Comic</p>
    <form id="comicInput" method="post" action="/admin/comics/save">
        <?php print $tokenTag; ?>
        <input type="hidden" name="editId" value="<?php print $comicId; ?>">
        <div class="row mb-3">
            <div class="form-floating col-md-6">
                <select class="form-select" id="title" name="title" title="Comic title" autofocus>
                    <?php print $titleOptions; ?>
                </select>
                <label for="title">&nbsp;&nbsp;Title</label>
            </div>
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" id="issue" name="issue" title="Issue number" value="<?php print $comic->getIssue(); ?>" required>
                <label for="issue">&nbsp;&nbsp;Issue No</label>
            </div>  
            <div class="form-floating col-md-2">
                <select class="form-select" id="month" name="month" title="Month of publication">
                    <?php print $monthOptions; ?>
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
                    <?php print $starOptions; ?>
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
                <div id="scripterList"><?php print $scripters; ?></div>
            </div>
            <div class="form-floating col-md-3">
                <select class="form-select" id="artists" name="artists" title="Comic artist or artists">
                    <?php print $creatorOptions; ?>
                </select>
                <label for="title">Artist(s)</label>
                <div id="artistList"><?php print $artists; ?></div>
            </div>
            <div class="col-md-1">
                <input type="button" class="btn btn-primary" id="submitComic" value="Save Comic">
            </div>
        </div>
    </form>
</div>
<?php
print drawFooter(array('ComicFormView-01.js'));
