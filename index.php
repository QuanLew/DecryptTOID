<?php

require_once "form.php";
require_once "controller.php";

// Create database tables if not exist
createUserTable();
createFileTable();

session_start();

// Prevent session fixation
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = 1;
}


// Check if user already logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    displayWelcomeMessage($username);
} else {
    displayForm();
}

exit;

?>