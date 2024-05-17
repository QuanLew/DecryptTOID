<?php


require_once '../model/StreamModel.php';

session_start();

if (isset($_POST['operation'])) {
     //Plaintext
    // 1   2   2   2
    // 001 010 010 010

    //Key
    // 1   2   3   6
    // 001 010 011 110

    //Ciphertext
    // 4   3   2   3
    // 100 011 010 011

    // encrypt the plaintext stream P = [1 2 2 2] with key K = [1 2 3 6] using our simplified RC4
    // stream cipher we get Ciphertext(encrypt) = [4 3 2 3].

    $operation = $_POST['operation'];
    $text = $_SESSION['info'];
    $key = "1236";

    $rc4 = driveCode($text,$key);
    $encryptedText = $rc4[0];
    $decryptedText = $rc4[1];

    
    if(strcmp($operation,'encrypt') == 0) {
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