<?php
if (!isset($_SESSION)) {
    session_start();
}

function isLogin() {
    return isset($_SESSION['is_login']) && $_SESSION['is_login'] === true;
}
?>
