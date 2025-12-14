<?php
session_start();
if (isset($_SESSION['user'])) {
    include 'header_user.php';
} else {
    include 'header_guest.php';
}
?>
