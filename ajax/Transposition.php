<?php

require_once '../model/TranspositionModel.php';

session_start();

if (isset($_POST['operation'])) {

    $operation = $_POST['operation'];
    $text = $_SESSION['info'];

    $key = "Secret";

    // key = Secret => length == 6 (6 x 6) and arrange plain text following order of alphabet, space/null replace by -
    // plaintext: ABCDEFGHIJKLMNOPQR
    //    S   e  c  r   e  t (key)
    //    19  5  3  18  5  20 (order of alphabet)
    //->  A   B  C  D   E  F  |
    //    G   H  I  J   K  L  |
    //    M   N  O  P   Q  R  v

    // print order of alphabet (acsending): 19(priority Uppercase) 3 5 5 18 20.
    //-> AGM CIO BHN EKQ DJP FLR
    $cipherText = Encipher($text, $key, '-');
    $plainText = Decipher($cipherText, $key);

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