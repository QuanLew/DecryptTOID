<?php

require_once "form.php";

session_start();

displayTransCipher($_SESSION["result"]);
exit;

?>