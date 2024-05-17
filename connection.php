<?php

function getConnection()
{
    $hn = 'localhost';
    $un = 'root';
    $pw = '';
    $db = 'decryptoid';

    // Attempt to connect to the database
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) {
        echo ''. $conn->connect_error;
        die("Error Connecting to Database");
    }
    return $conn;
}

?>