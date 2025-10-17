<?php
session_start();
session_regenerate_id(true); // regenerates SESSIONID to prevent hijacking

/*
if (!isset($_SESSION['token']) || (isset($_SESSION['token-expire']) && time() > $_SESSION['token-expire'])) {
    $_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    $_SESSION['token-expire'] = time() + 3600;
}
*/   
function isLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}
