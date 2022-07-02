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
//
//try {
//    $pdo->beginTransaction();
//
//    $pub = new Publisher();
//    $pub->setPublisherName('Generic Publisher');
//    $pubId = $pub->savePublisher($pdo);
//
//    $title = new Title();
//    $title->setName('Captain Generic');
//    $title->setPublisherId($pubId);
//    $title->setStartYear(2020);
//    $title->setVolume(1);
//    $titleId = $title->saveTitle($pdo);
//
//    $writers = array(26);
//    $artists = array(5, 40);
//
//    $comic = new Comic();
//    $comic->setTitleId($titleId);
//    $comic->setIssue(507);
//    $comic->setMonth(1);
//    $comic->setYear(2022);
//    $comic->setStory("If This Be Unit Testing!");
//    $comic->setHardCopy(false);
//    $comic->setWantList(false);
//    $comic->setStars(4);
//
//    $comicId = $comic->saveComic($pdo);
//
//    foreach ($writers as $w) {
//        $comic->setScripter($pdo, $w);
//    }
//
//    foreach ($artists as $a) {
//        $comic->setArtist($pdo, $a);
//    }
//
//    $pdo->commit();
//} catch (Exception $e) {
//    $pdo->rollBack();
//    print $e->getMessage();
//}
//
//print 'ok';

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
          <form id="comicInput" method="post" action="index.php">
              <div class="row">
                  <div class="form-floating col">
                      <input type="text" class="form-control" id="title" name="title">
                      <label for="title">Title</label>
                  </div>
                  <div class="form-floating col">
                      <input type="text" class="form-control" id="issue" name="issue">
                      <label for="issue">Issue No</label>
                  </div>
                  <div class="form-floating col">
                      <select class="form-select" id="month" name="month">
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
                      <label for="month">Cover month</label>
                  </div>
                  <div class="form-floating col">
                      <input type="text" class="form-control" id="year" name="year">
                      <label for="year">Year</label>
                  </div>
              </div>
          </form>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>

