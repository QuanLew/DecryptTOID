<?php

$_SESSION = array();
setcookie(session_name(), '', time() + 60 * 60 * 24 * 7, '/');
session_destroy();

header('Location: index.php');
exit;

?>