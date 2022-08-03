<?php
require_once 'Setup.php';

$comicId = filter_input(INPUT_GET, 'comicId', FILTER_SANITIZE_NUMBER_INT);
$comic = new Comic();
$comic->loadComicById($pdo, $comicId);
$wantList = ($comic->getWantList()) ? 'YES' : 'NO';
$hardCopy = ($comic->getHardCopy()) ? 'HARD COPY' : 'DIGITAL';

$title = new Title();
$title->loadTitleById($pdo, $comic->getTitleId());

$publisher = new Publisher();
$publisher->loadPublisherById($pdo, $title->getPublisherId());

print drawHeader('Comic Saved');

?>
<div class="container pt-4">
    <p class="h4">Comic Saved!</p>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th colspan="2">Record</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Title</td>
                <td><?php print $title->getName() . ' (' . $publisher->getPublisherName() . ')'; ?></td>
            </tr>
            <tr>
                <td>Issue</td>
                <td><?php $comic->getIssue() . ' (' . $comic->getMonth() . '/' . $comic->getYear() . ')'; ?></td>
            </tr>
            <tr>
                <td>Story</td>
                <td><?php print $comic->getStory(); ?></td>
            </tr>
            <tr>
                <td>Writer(s)</td>
                <td><?php print $comic->getScriptersToString(); ?></td>
            </tr>
            <tr>
                <td>Artist(s)</td>
                <td><?php print $comic->getArtistsToString(); ?></td>
            </tr>
            <tr>
                <td>Rating</td>
                <td><?php print $comic->getStarSvgs(); ?></td>
            </tr>            
            <tr>
                <td>Notes</td>
                <td><?php print $comic->getNotes(); ?></td>
            </tr>
            <tr>
                <td>Want List?</td>
                <td><?php print $wantList; ?></td>
            </tr>
            <tr>
                <td>Format</td>
                <td><?php print $hardCopy; ?></td>
            </tr>
        </tbody>
    </table>    
    <a class="btn btn-primary" href="/admin/comics">Add another comic?</a>
</div>
<?php
print drawFooter();