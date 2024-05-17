<?php

require_once '../model/CaesarModel.php';

session_start();

if (isset($_POST['operation'])) {

    $operation = $_POST['operation'];
    $text = $_SESSION['info'];

    // 1 2 3 4 5 6 7 8 9
    // A B C D E F G H I (24 alphabet)
    //Shift 5 letter: start from 6th letter (encrypt)
    //EX: A B C D (decrypt)
    //->  F G H I (encrypt)

    $cipherText = Encipher(str_replace(" ", "_", $text), 5);
    $plainText  = Decipher(str_replace("_", " ", $cipherText), 5);

    if(strcmp($operation,'encrypt') == 0){
        $result = $cipherText;
    }else{
        $result = $plainText;
    }

    // Output the result
    echo '<h3>' . "Result from your prompt: $result" . '</h3>';
} else {
    echo '<h3>' . "Error: Missing parameters." . '</h3>';
}

?>