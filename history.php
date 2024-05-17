<?php
require_once 'controller.php';
require_once 'form.php';

session_start();

$histories = getAllRecordCipher($_SESSION['username']);

displayHistory($histories);
exit;


?>