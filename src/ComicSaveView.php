<?php
require_once 'DbConfig.php';
require_once 'DbConn.php';

require_once 'Publisher.php';
require_once 'Title.php';
require_once 'Creator.php';
require_once 'Comic.php';
require_once 'FormHelpers.php';

$comicId = filter_input(INPUT_GET, 'comicId', FILTER_SANITIZE_NUMBER_INT);
$comic = new Comic();
$comic->loadComicById($pdo, $comicId);

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
        </tbody>
    </table>
</div>
<?php
print drawFooter();