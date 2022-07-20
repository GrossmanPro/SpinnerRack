<?php

// load after DbConfig.php and DbConn.php and object classes

/**
 * Function getSelectListOptions
 * Generates select list options from *OptionTags views in database.
 * $table and $orderBy are not user controlled, no SQL injection risk.
 * @param object $pdo
 * @param string $table
 * @param string $orderBy
 * @return string
 */
function getSelectListOptions(object $pdo, string $table, string $orderBy): string {
    $sql = 'SELECT * FROM ' . $table . 'OptionTags ORDER BY ' . $orderBy;
    // remove trailing comma and get results  
    $results = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
    $options = '<option value="0">&nbsp;</option>';
    foreach ($results as $result) {
        $options .= '<option value="' . $result['OptionValue'] . '">' . $result['OptionText'] . '</option>';
    }
    return $options;
}

/**
 * Function drawHeader
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
    $header .= '<link rel="stylesheet" href="/css/master.css">';
    if (!is_null($cssFiles)) {
        foreach ($cssFiles as $file) {
            $header .= '<link src="/css/' . $file . '" rel="stylesheet">';
        }
    }
    $header .= '</head>';
    $header .= '<body>';   
    $header .= '<nav class="navbar bg-light">';
    $header .= '<div class="container">';
    $header .= '<a class="navbar-brand" href="index.php">';
    $header .= '<img src="/img/brand.svg" alt="Grossman Project-SpinnerRack" width="60" height="60">';
    $header .= '</a>';
    
    $header .= '<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">';
    $header .= '<li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>';
    $header .= '<li class="nav-item dropdown">';
    $header .= '<a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>';
    $header .= '<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">';
    $header .= '<li><a class="dropdown-item" href="/admin/creators">Creators</a></li>';
    $header .= '<li><a class="dropdown-item" href="/admin/publishers">Publishers</a></li>';
    $header .= '<li><a class="dropdown-item" href="/admin/titles">Titles</a></li>';
    $header .= '</ul>';
    $header .= '</ul>';
    $header .= '</li>';
    $header .= '</div>';
    $header .= '</nav>';    
    return $header;
}

/**
 * Function drawFooter
 * Returns markup for standard page footer.
 * Optionally adds custom JavaScript files.
 * @param array $jsFiles
 * @return string
 */
function drawFooter(array $jsFiles = null): string {
    $footer = '<script src="/js/jquery.js"></script>';
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
