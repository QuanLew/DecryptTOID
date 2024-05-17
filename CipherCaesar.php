<?php

require_once "form.php";
require_once 'controller.php';

session_start();

displayCaesarCipher($_SESSION["result"]);
// echo "hello ." . $_SESSION['result'];
exit;


?>