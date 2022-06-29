<?php
// Initialize the session
session_start();

// check untuk login session, jika tidak akan dibuang ke halaman login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}