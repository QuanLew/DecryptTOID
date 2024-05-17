<?php 
// decrypytoid.php, handle case from input or file txt and direction to pages of ciphers

require_once 'form.php';
require_once 'utility.php';
require_once 'upload.php';
require_once 'controller.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputtext = $filename = "";

    // get content from file or input-text
    if(isset($_POST["input-text"])) {
        $inputtext = $_POST['input-text'];
    }
    if(isset($_POST['filename'])) {
        $filename = $_POST['filename'];
    }
    
    // get options: encrypt or decrypt
    if (isset($_POST['option'])) {
        // Get the value of 'option'
        $option = $_POST['option'];
        
        // Check the value of 'option' to determine if it's 'decrypt-text' or 'encrypt-text'
        if ($option === 'decrypt-text') {
            // Decrypt text logic here
            echo "Decrypting text...";
        } elseif ($option === 'encrypt-text') {
            // Encrypt text logic here
            echo "Encrypting text...";
        } else {
            // Handle other cases where 'option' has unexpected values
            echo "Invalid option value";
        }
    }

    if (empty(($inputtext))){
        //$fileofcontent = file_get_contents($fileofcontent);
        $info = handleFile($filename); 
    }else {
        $info = $_POST['input-text'];
    }

    storeInfoCipher($info);

    $selected_cipher = filter_input(// RC4, Subs, Des, ....
        INPUT_POST,
        'ciphers',
        FILTER_SANITIZE_STRING,
        FILTER_REQUIRE_ARRAY
    );
    if ($selected_cipher){
        foreach ($selected_cipher as $cipher) {
            $selected_cipher[] = $cipher;
        }
    }

    switch ($selected_cipher[0]) {
        case "Substitution":
            $location = "CipherCaesar.php";
            require_once "./model/CaesarModel.php";
            break;
        case "Transposition":
            $location = "CipherTrans.php";
            require_once "./model/TranspositionModel.php";
            break;
        case "Stream": //RC4
            $location = "CipherStream.php";
            require_once "./model/StreamModel.php";
            break;
        case "DES":
            $location = "CipherDes.php";
            require_once "./model/DesModel.php";
            break;
        default:
            $location = "CipherError.php";
            break;
    }

    $t=time();
    $result = getCipherContent($info, $selected_cipher[0], $option);
    $encrypt_content = $result[0];
    $decrypt_content = $result[1];
    
    if(empty($encrypt_content)){
        $encrypt_content = "N/A";
        storeResultCipher($decrypt_content);
    }elseif (empty($decrypt_content)){
        $decrypt_content = "N/A";
        storeResultCipher($encrypt_content);
    }
    
    $cipherId = createCipher($info, $selected_cipher[0], $encrypt_content, $decrypt_content, date("Y-m-d",$t) . " " . date("h:i:sa"));

    if (is_string($cipherId)) {
        echo "fail cipher info!\n";
        $fail .= $cipherId;
        displayForm($fail);
        exit;
    }

    //handle direction to type of selected-cipher
    header('Location: ' . $location);
    exit;
}

function getCipherContent($cipher_content, $selected_cipher, $option) {
    $plainText = $cipherText = "";

    switch ($selected_cipher) {
        case "Substitution":
            if ($option === 'decrypt-text') {
                $plainText  = Decipher(str_replace("_", " ", $cipher_content), 5);
            } elseif ($option === 'encrypt-text') {
                $cipherText = Encipher(str_replace(" ", "_", $cipher_content), 5);
            }
            
            // $cipherText = Encipher(str_replace(" ", "_", $cipher_content), 5);
            // $plainText  = Decipher(str_replace("_", " ", $cipherText), 5);
            break;
        case "Transposition":
            $key = "Secret";
            if ($option === 'decrypt-text') {
                $plainText = Decipher($cipher_content, $key);
            } elseif ($option === 'encrypt-text') {
                $cipherText = Encipher($cipher_content, $key, '-');
            }

            // $cipherText = Encipher($cipher_content, $key, '-');
            // $plainText = Decipher($cipherText, $key);
            break;
        case "Stream": //RC4
            $key = "Secret";
            $rc4B64 = new Rc4B64Class();

            if ($option === 'decrypt-text') {
                $plainText = $rc4B64->Decrypt($cipher_content, $key);
            } elseif ($option === 'encrypt-text') {
                $cipherText = $rc4B64->Encrypt($cipher_content, $key);
            }

            // $rc4 = driveCode($cipher_content, $key);
            // $cipherText = $rc4[0];
            // $plainText = $rc4[1];
            break;
        case "DES":
            $key = "Secret";
            $des = new CryptoDES();

            if ($option === 'decrypt-text') {
                $plainText = $des->dekripsiDES($cipher_content, $key);
            } elseif ($option === 'encrypt-text') {
                $cipherText = $des->enkripsiDES($cipher_content, $key);
            }

            // $des = driveCode($cipher_content, $key);
            // $cipherText = $des[0];
            // $plainText = $des[1];
            break;
        default:
            $cipherText = "";
            $plainText = "";
            break;
    }

    return [$cipherText,$plainText];
}

?>
