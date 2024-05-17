<?php

require_once '../model/DesModel.php';

session_start();

if (isset($_POST['operation'])) {

    $operation = $_POST['operation'];
    $text = $_SESSION['info'];
    $key = "Secret"; // DES key

    $des = driveCode($text,$key);
    $encryptedText = $des[0];
    $decryptedText = $des[1];

    if(strcmp($operation,'encrypt') == 0){
        $result = $encryptedText;
    }else{
        $result = $decryptedText;
    }

    // Output the result
    echo '<h3>' . "Result from your prompt: $result" . '</h3>';
} else {
    echo '<h3>' . "Error: Missing parameters." . '</h3>';
}

?>