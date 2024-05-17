<?php

class Rc4B64Class {
    private $sbox = array();
    private $key = array();
    private $keyStr = "ABCDEFGHIJKLMNOP" .
                    "QRSTUVWXYZabcdef" .
                    "ghijklmnopqrstuv" .
                    "wxyz0123456789+/" .
                    "=";

    public function __construct() {
        $this->initialize();
    }

    private function initialize() {
        for ($a = 0; $a < 256; $a++) {
            $this->key[] = ord($this->keyStr[$a % strlen($this->keyStr)]) % 256;
            $this->sbox[] = $a;
        }

        $b = 0;
        for ($a = 0; $a < 256; $a++) {
            $b = ($b + $this->sbox[$a] + $this->key[$a]) % 256;
            $tempSwap = $this->sbox[$a];
            $this->sbox[$a] = $this->sbox[$b];
            $this->sbox[$b] = $tempSwap;
        }
    }

    public function encrypt($strTexto, $strClave) {
        return $this->encode64($this->_RC4($strTexto, $strClave));
    }

    public function decrypt($strTexto, $strClave) {
        return $this->_RC4($this->decode64($strTexto), $strClave);
    }

    private function _RC4($strTexto, $strClave) {
        $i = 0;
        $j = 0;
        $cipher = '';

        $this->initializeRC4($strClave);

        for ($a = 0; $a < strlen($strTexto); $a++) {
            $i = ($i + 1) % 256;
            $j = ($j + $this->sbox[$i]) % 256;
            $temp = $this->sbox[$i];
            $this->sbox[$i] = $this->sbox[$j];
            $this->sbox[$j] = $temp;

            $k = $this->sbox[($this->sbox[$i] + $this->sbox[$j]) % 256];

            $cipherby = ord($strTexto[$a]) ^ $k;
            $cipher .= chr($cipherby);
        }
        return $cipher;
    }

    private function initializeRC4($strLlave) {
        for ($a = 0; $a < 256; $a++) {
            $this->key[$a] = ord($strLlave[$a % strlen($strLlave)]) % 256;
            $this->sbox[$a] = $a;
        }

        $b = 0;
        for ($a = 0; $a < 256; $a++) {
            $b = ($b + $this->sbox[$a] + $this->key[$a]) % 256;
            $tempSwap = $this->sbox[$a];
            $this->sbox[$a] = $this->sbox[$b];
            $this->sbox[$b] = $tempSwap;
        }
    }

    private function encode64($input) {
        $output = "";
        $chr1 = $chr2 = $chr3 = "";
        $enc1 = $enc2 = $enc3 = $enc4 = "";
        $i = 0;

        do {
            $chr1 = ord($input[$i++]);
            $chr2 = ord($input[$i++]);
            $chr3 = ord($input[$i++]);

            $enc1 = $chr1 >> 2;
            $enc2 = (($chr1 & 3) << 4) | ($chr2 >> 4);
            $enc3 = (($chr2 & 15) << 2) | ($chr3 >> 6);
            $enc4 = $chr3 & 63;

            if (is_nan($chr2)) {
                $enc3 = $enc4 = 64;
            } else if (is_nan($chr3)) {
                $enc4 = 64;
            }

            $output .= $this->keyStr[$enc1] .
                       $this->keyStr[$enc2] .
                       $this->keyStr[$enc3] .
                       $this->keyStr[$enc4];
            $chr1 = $chr2 = $chr3 = "";
            $enc1 = $enc2 = $enc3 = $enc4 = "";
        } while ($i < strlen($input));

        return $output;
    }

    private function decode64($input) {
        $output = "";
        $chr1 = $chr2 = $chr3 = "";
        $enc1 = $enc2 = $enc3 = $enc4 = "";
        $i = 0;

        $base64test = '/[^A-Za-z0-9\+\/\=]/';
        if (preg_match($base64test, $input)) {
            echo "There were invalid base64 characters in the input text.\n" .
                 "Valid base64 characters are A-Z, a-z, 0-9, '+', '/', and '='\n" .
                 "Expect errors in decoding.";
        }
        $input = preg_replace('/[^A-Za-z0-9\+\/\=]/', "", $input);

        do {
            $enc1 = strpos($this->keyStr, $input[$i++]);
            $enc2 = strpos($this->keyStr, $input[$i++]);
            $enc3 = strpos($this->keyStr, $input[$i++]);
            $enc4 = strpos($this->keyStr, $input[$i++]);

            $chr1 = ($enc1 << 2) | ($enc2 >> 4);
            $chr2 = (($enc2 & 15) << 4) | ($enc3 >> 2);
            $chr3 = (($enc3 & 3) << 6) | $enc4;

            $output .= chr($chr1);

            if ($enc3 != 64) {
                $output .= chr($chr2);
            }
            if ($enc4 != 64) {
                $output .= chr($chr3);
            }

            $chr1 = $chr2 = $chr3 = "";
            $enc1 = $enc2 = $enc3 = $enc4 = "";

        } while ($i < strlen($input));

        return $output;
    }
}

function driveCode($msg, $key){
    // Example usage:
    $rc4B64 = new Rc4B64Class();
    $encryptedText = $rc4B64->Encrypt($msg, $key);
    //echo "Encrypted text he: " . $encryptedText . "\n";
    $decryptedText = $rc4B64->Decrypt($encryptedText, $key);
    //echo "Decrypted text be: " . $decryptedText . "\n";

    return [$encryptedText, $decryptedText];
}

// echo implode(" ",driveCode("hello!","Secret"));


// function rc4($plaintext, $key)
// {
//     $S = range(0, 7); // state vector
//     $T = $key; // temp vector
//     $t = 0; //temp of T

//     // Initial permutation
//     $j = 0;
//     for ($i = 0; $i < 8; $i++) {
//         if($i > 3){
//             $t = $i % 4; 
//         } else{
//             $t = $i;
//         }
//         $j = ($j + $S[$i] + $T[$t]) % 8;
//         [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
//     }

//     $ciphertext = '';

//     // Generating stream and XOR with plaintext
//     $i = $j = 0;
//     foreach ($plaintext as $pt) {
//         $i = ($i + 1) % 8;
//         $j = ($j + $S[$i]) % 8;
//         [$S[$i], $S[$j]] = [$S[$j], $S[$i]];

//         $t = ($S[$i] + $S[$j]) % 8;
//         $k = $S[$t];

//         $ciphertext .= $k ^ $pt;
//     }

//     return $ciphertext;
// }

// // Convert binary string to array of integers
// function binStrToArray($str)
// {
//     return array_map('intval', str_split($str));
// }

// // Convert integer array to binary string
// function arrayToBinStr($arr)
// {
//     return implode('', array_map('strval', $arr));
// }

// function binaryStringToIntegerArray($binaryString) {
//     $chunks = explode(' ', $binaryString); // Split the string by space
//     $integers = array_map('bindec', $chunks); // Convert each chunk to integer
//     return $integers;
// }

// function integerArrayToBinaryString($integers) {
//     // Convert each integer to binary string and pad with zeros to ensure each chunk is 3 bits
//     $chunks = array_map(function($int) {
//         return str_pad(decbin($int), 3, '0', STR_PAD_LEFT);
//     }, $integers);

//     // Join the binary strings with space separator
//     $binaryString = implode(' ', $chunks);
//     return $binaryString;
// }

// function driveCode($msg, $key){
//     $plaintext = binaryStringToIntegerArray($msg); //input binary: 001 010 010 010
//     $key = binaryStringToIntegerArray($key);

//     $encryptedText = rc4($plaintext, $key);
    
//     $my_array1 = str_split($encryptedText);
//     $convertArr = binaryStringToIntegerArray(integerArrayToBinaryString($my_array1));

//     $decryptedText = rc4($convertArr, $key);

//     return [$encryptedText, $decryptedText];
// }

?>