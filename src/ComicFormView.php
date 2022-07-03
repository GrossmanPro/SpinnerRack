<?php
require_once 'DbConfig.php';
require_once 'DbConn.php';

require_once 'Publisher.php';
require_once 'Title.php';
require_once 'Creator.php';
require_once 'Comic.php';
require_once 'FormHelpers.php';


$titleOptions = getSelectListOptions($pdo, 'Titles', 'OptionText');
$creatorOptions = getSelectListOptions($pdo, 'Creators', 'OptionText');

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Save Comic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
          <form id="comicInput" method="post" action="ComicFormController.php">
              <div class="row mb-3">
                  <div class="form-floating col-md-6">
                      <select class="form-select" id="title" name="title" title="Comic title" autofocus>
                          <?php print $titleOptions; ?>
                      </select>
                      <label for="title">Title</label>
                  </div>
                  <div class="form-floating col-md-2">
                      <input type="text" class="form-control" id="issue" name="issue" title="Issue number" required>
                      <label for="issue">Issue No</label>
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
                      <label for="month">Cover month</label>
                  </div>
                  <div class="form-floating col-md-2">
                      <input type="text" class="form-control" id="year" name="year" maxlength="4" min="1930" max="2100" title="Year of publication" required>
                      <label for="year">Year</label>
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="form-floating col-md-6">
                    <input type="text" class="form-control" id="story" name="story" title="Story" required>
                    <label for="story">Story</label>
                  </div>                  
              </div>
              <div class="row mb-3">
                  <div class="form-floating col-md-6">
                      <textarea class="form-control" rows="4" id="notes" name="notes" title="Story notes"></textarea>
                      <label for="notes">Notes</label>
                  </div>                      
              </div>    
              <div class="row mb-3">
                  <div class="form-floating col-md-4">
                      <select class="form-select" id="scripters" name="scripters" title="Comic scripter or scripters">
                          <?php print $creatorOptions; ?>
                      </select>
                      <label for="title">Writer(s)</label>
                  </div>
                  <div class="form-floating col-md-4">
                      <select class="form-select" id="artists" name="artists" title="Comic artist or artists">
                          <?php print $creatorOptions; ?>
                      </select>
                      <label for="title">Artist(s)</label>
                  </div>
              </div>
                <div class="row">
                  <input type="button" class="btn btn-primary" id="submitComic" value="Save Comic">
                </div>
          </form>
      </div>
    <script src="/js/jquery.js"></script>
    <script src="/js/ComicFormView.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>
