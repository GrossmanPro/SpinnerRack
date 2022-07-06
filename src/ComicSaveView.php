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
        </tbody>
    </table>
</div>
<?php
print drawFooter();