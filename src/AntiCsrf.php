<?php

/**
 * Function requestIsPost
 * Only apply CSRF to postbacks.
 * @return type
 */
function requestIsPost ()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Function createCsrfToken
 * Is what it says, says what it is...
 * @return type
 */
function createCsrfToken ()
{
    $token = base64_encode(random_bytes(14));
    $_SESSION['csrfToken'] = $token;
    $_SESSION['csrfTime'] = time();
    return $token;
}

/**
 * Function deleteCsrfTokenFromSession
 */
function deleteCsrfTokenFromSession ()
{
    $_SESSION['csrfToken'] = null;
    $_SESSION['csrfTime'] = null;
}

/**
 * Function csrfTokenIsValid
 * @return boolean
 */
function csrfTokenIsValid ():bool
{
    if (isset($_SESSION['csrfToken'])) {
        if ($_SESSION['csrfToken'] == $_POST['csrfToken']) {    
            // check expiration
            $exp = checkCsrfTokenTime();
            return $exp;
        } else {  
            return false;
        }
    }
}

/**
 * Function checkCsrfTokenTime
 * @return boolean
 */
function checkCsrfTokenTime ()
{
    if (isset($_SESSION['csrfTime'])) {
        $time = $_SESSION['csrfTime'];
        // 4 hours = 14400 seconds
        $expire = $time * 14400;
        if ($time >= $expire) {
            deleteCsrfTokenFromSession ();
            return false;
        } else {            
            return true;
        }
    } else {
        // no token time
        return false;
    }
}
