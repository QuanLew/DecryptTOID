<?php

require_once "form.php";

session_start();

displayRC4Cipher($_SESSION["result"]);
exit;


?>