<?php

// this file would more or less be the controller  
// decides what to do, then passes results through ajax back to view
//namespace src;
require_once 'DbConfig.php';
require_once 'DbConn.php';

require_once 'Publisher.php';
require_once 'Title.php';
require_once 'Creator.php';
require_once 'Comic.php';

try {
    $pdo->beginTransaction();

    $pub = new Publisher();
    $pub->setPublisherName('Generic Publisher');
    $pubId = $pub->savePublisher($pdo);

    $title = new Title();
    $title->setName('Captain Generic');
    $title->setPublisherId($pubId);
    $title->setStartYear(2020);
    $title->setVolume(1);
    $titleId = $title->saveTitle($pdo);

    $writers = array(26);
    $artists = array(5, 40);

    $comic = new Comic();
    $comic->setTitleId($titleId);
    $comic->setIssue(507);
    $comic->setMonth(1);
    $comic->setYear(2022);
    $comic->setStory("If This Be Unit Testing!");
    $comic->setHardCopy(false);
    $comic->setWantList(false);
    $comic->setStars(4);

    $comicId = $comic->saveComic($pdo);

    foreach ($writers as $w) {
        $comic->setScripter($pdo, $w);
    }

    foreach ($artists as $a) {
        $comic->setArtist($pdo, $a);
    }

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    print $e->getMessage();
}

print 'ok';

