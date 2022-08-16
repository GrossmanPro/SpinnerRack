<?php

// load after DbConfig.php and DbConn.php and object classes

/**
 * getSelectListOptions
 * Generates select list options from OptionTags views in database.
 * $table and $orderBy are not user controlled, no SQL injection risk.
 * @param object $pdo
 * @param string $table
 * @param string $orderBy
 * @param int $selected
 * @return string
 */
function getSelectListOptions(object $pdo, string $table, string $orderBy, int $selected = 0): string {
    $sql = 'SELECT * FROM ' . $table . 'OptionTags ORDER BY ' . $orderBy;
    $results = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
    $options = '<option value="0">&nbsp;</option>';
    foreach ($results as $result) {
        $selectAttr = ((int)$result['OptionValue'] === $selected)? ' selected ': '';
        $options .= '<option value="' 
                . $result['OptionValue'] . '"' 
                . $selectAttr .'>' 
                . $result['OptionText'] 
                . '</option>';
    }
    return $options;
}

/**
 * getStarOptions
 * @param int $stars
 * @return string
 */
function getStarOptions(int $stars = 0): string {
    $options = '';
    for ($cnt = 1; $cnt <= 5; $cnt++) {
        $selected = ($stars === $cnt) ? ' selected ' : '';
        $options .= '<option value="' . $cnt . '"' . $selected . '>'. $cnt . '</option>';        
    }
    return $options;
}

/**
 * getMonthOptions
 * @param int $month
 * @return string
 */
function getMonthOptions(int $month = 0): string {
    $options = '';
    for ($cnt = 1; $cnt <= 12; $cnt++) {
        $selected = ($month === $cnt) ? ' selected ' : '';
        $monthVal = date('M', strtotime($cnt . '/1/1970'));
        $options .= '<option value="' . $cnt . '"' . $selected . '>'. $monthVal . '</option>';        
    }
    return $options;
}

/**
 * drawHeader
 * Returns markup for standard page header.
 * Optionally adds custom CSS files.
 * @param string $title
 * @param array $cssFiles
 * @return string
 */
function drawHeader(string $title, array $cssFiles = null): string {
    $header = '<!doctype html>';
    $header .= '<html lang="en">';
    $header .= '<head>';
    $header .= '<meta charset="utf-8">';
    $header .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
    $header .= '<title>' . $title . '</title>';
    $header .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">';
    $header .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">';
    $header .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">';
    $header .= '<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">';
    $header .= '<link rel="stylesheet" href="/css/master-01.css">';
    if (!is_null($cssFiles)) {
        foreach ($cssFiles as $file) {
            $header .= '<link src="/css/' . $file . '" rel="stylesheet">';
        }
    }
    $header .= '</head>';
    $header .= '<body>';   
    $header .= '<nav class="navbar bg-light">';
    $header .= '<div class="container-fluid">';
    $header .= '<a class="navbar-brand" href="index.php">';
    $header .= '<img src="/img/brand-01.svg" alt="Grossman Project-SpinnerRack" width="60" height="60">';
    $header .= '</a>';
    
    $header .= '<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">';
    $header .= '<li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>';
    $header .= '<li class="nav-item dropdown">';
    $header .= '<a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>';
    $header .= '<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">';
    $header .= '<li><a class="dropdown-item" href="/admin/comics">Comics</a></li>';
    $header .= '<li><a class="dropdown-item" href="/admin/creators">Creators</a></li>';
    $header .= '<li><a class="dropdown-item" href="/admin/publishers">Publishers</a></li>';
    $header .= '<li><a class="dropdown-item" href="/admin/titles">Titles</a></li>';
    $header .= '</ul>';
    $header .= '</li>';  
    
    $header .= '<li class="nav-item dropdown">';
    $header .= '<a class="nav-link dropdown-toggle" href="#" id="navbarComics" role="button" data-bs-toggle="dropdown" aria-expanded="false">Comics</a>';
    $header .= '<ul class="dropdown-menu" aria-labelledby="navbarComics">';
    $header .= '<li><a class="dropdown-item" href="/search">Search</a></li>';
    $header .= '<li><a class="dropdown-item" href="/comics/view">View</a></li>';
    $header .= '</ul>';
    $header .= '</ul>';
    $header .= '</li>';
       
    $header .= '<form class="d-flex" role="search">';       
    $header .= '<input class="form-control me-2" type="search" placeholder="Find comics" aria-label="Search">';       
    $header .= '<button class="btn btn-outline-success" type="submit">Search</button>';       
    $header .= '</form>';    
    $header .= '</div>';
    $header .= '</nav>';    
    return $header;
}

/**
 * drawFooter
 * Returns markup for standard page footer.
 * Optionally adds custom JavaScript files.
 * @param array $jsFiles
 * @return string
 */
function drawFooter(array $jsFiles = null): string {
    $footer = '<script src="/js/jquery-01.js"></script>';
    $footer .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>';
    $footer .= '<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>';
    $footer .= '<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>';
    if (!is_null($jsFiles)) {
        foreach ($jsFiles as $file) {            
            $footer .= '<script src="/js/' . $file . '"></script>';
        }
    }
    $footer .= '</body>';
    $footer .= '</html>';
    return $footer;
}

/**
 * getExistingCreatorDivs
 * Set up existing creator divs for selected comic.
 * $divCnt starts with time() to avoid name/id conflicts with
 * dynamically created creator divs from ComicFormView-x.js.
 * @param Comic $comic          Comic object
 * @param bool $loadArtists     true = load artists, false = load scripters
 * @return string               div markup w/delete buttons and hidden form fields
 */
function getExistingCreatorDivs (Comic $comic, bool $loadArtists): string {
    $html = '';
    $divCnt = time(); 
    if ($loadArtists) {
        foreach ($comic->artists as $artist) {
            $html .= '<div class="input-group" id="artistDiv_' . $divCnt . '">';
            $html .= '<input '
                    . 'type="text" '
                    . 'class="form-control-plaintext" '
                    . 'value="' . $artist->getFullName() .  '" '
                    . 'title="' . $artist->getFullName() .  '" readonly>';
            $html .= '<input type="button" class="btn btn-danger btn-sm removeCreator" value="Delete">';
            $html .= '<input type="hidden" id="artist_' . $divCnt . '" name="artist_' . $divCnt . '" value="' . $artist->getId() . '">';
            $html .= '</div>';
            $divCnt++;
        }
    } else {
        foreach ($comic->scripters as $scripter) {
            $html .= '<div class="input-group" id="scripterDiv_' . $divCnt . '">';
            $html .= '<input '
                    . 'type="text" '
                    . 'class="form-control-plaintext" '
                    . 'value="' . $scripter->getFullName() . '" '
                    . 'title="' . $scripter->getFullName() . '" readonly>';
            $html .= '<input type="button" class="btn btn-danger btn-sm removeCreator" value="Delete">';
            $html .= '<input type="hidden" id="scripter_' . $divCnt . '" name="scripter_' . $divCnt . '" value="' . $scripter->getId() . '">';
            $html .= '</div>';   
            $divCnt++;
        }
    }    
    return $html;
}