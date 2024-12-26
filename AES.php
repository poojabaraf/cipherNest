<?php
    session_start();
    header('Content-Type: text/html');
    date_default_timezone_set('Asia/Kolkata');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST["action"];
        $key = $_POST["key"] ?? '';
        $OldKey = $key; //for validation
        $keySize = $_POST["keySize"];
        $cipherMode = strtolower($_POST["cipherMode"]);
        $outputFormat = $_POST['outputFormat'];
        $email = $_SESSION['email'] ?? '';
        $plaintext = $_POST['orgtext'] ?? '';

        if (empty($key)) {
            die("Invalid key."); 
        }
        if (!in_array($keySize, [128, 192, 256])) {
            die("Invalid key length. Key must be 16, 24, or 32 characters long.");
        }
        if (!in_array($cipherMode, ['cbc', 'ctr', 'gcm', 'ecb'])) {
            die("Invalid cipher mode.");
        }

        $key = adjustKeyLength($key, $keySize);

        require 'DB.php';

        $EncOutput = $DecOutput = null;

        if ($action === 'encrypt') {
            $encryptDateTime = date('Y-m-d H:i:s');
            $plaintext = $_POST["plaintext"] ?? '';

            if (empty($plaintext)) {
                die("Please enter text to encrypt.");
            }

            $EncOutput = encryptData($plaintext, $key, $cipherMode, $keySize, $outputFormat);
            if(isset($_SESSION['email']) && !empty($EncOutput)){
                $q = "insert into tblEncrypt_Decrypt values(null,'$email','$OldKey','$cipherMode','$encryptDateTime','$keySize','$outputFormat','$action')";    
                if(!mysqli_query($mysql,$q))
                    error_log("Database error: " . mysqli_error($mysql));
            }
            echo $EncOutput;
        } elseif ($action === 'decrypt') {
            $decryptDateTime = date('Y-m-d H:i:s');
            $ciphertext = $_POST["ciphertext"] ?? '';
            $originalCipherMode = strtolower($_POST["originalCipherMode"]); //for validation
            $originalkey = $_POST["originalkey"]; //for validation

            if (empty($ciphertext)) {
                die("Please enter text to decrypt.");
            }

            if (!in_array($originalCipherMode, ['cbc', 'ctr', 'gcm', 'ecb'])) {
                die("Invalid cipher mode.");
            }

            if ($originalCipherMode !== $cipherMode) {
                die("The cipher mode used for decryption must match the one used for encryption.");
            }

            if($originalkey !== $OldKey){
                die("The key used for decryption must match the one used for encryption.");
            }

            $DecOutput = decryptData($ciphertext, $key, $cipherMode, $keySize, $outputFormat);
            if(isset($_SESSION['email']) && !empty($DecOutput)){
                $q = "insert into tblEncrypt_Decrypt values(null,'$email','$OldKey','$cipherMode','$decryptDateTime','$keySize','$outputFormat','$action')";    
                if(!mysqli_query($mysql,$q))
                    error_log("Database error: " . mysqli_error($mysql));
            }
            echo $DecOutput;
        } else {
            die("Invalid action.");
        }
        if (isset($_SESSION['email']) && (!empty($EncOutput) || !empty($DecOutput))) {
            $CreatedDateTime = date('Y-m-d H:i:s');
            $q = "insert into tblHistory values (NULL, '$email', '$plaintext', '$EncOutput', '$DecOutput','$CreatedDateTime')";
            if (!mysqli_query($mysql, $q)) {
                error_log("Database error: " . mysqli_error($mysql));
            }
        }
    } else {
        die("Invalid request method.");
    }

    function adjustKeyLength($key, $keySize) {
        $hashedKey = hash('sha256', $key, true);

        switch ($keySize) {
            case 128:
                return substr($hashedKey, 0, 16); // 128 bits = 16 bytes
            case 192:
                return substr($hashedKey, 0, 24); // 192 bits = 24 bytes
            case 256:
                return substr($hashedKey, 0, 32); // 256 bits = 32 bytes
        }
    }

    function encryptData($plaintext, $key, $cipherMode, $keySize, $outputFormat) {
        $cipher = "aes-$keySize-$cipherMode";

        if (!in_array($cipher, openssl_get_cipher_methods())) {
            throw new Exception("Cipher method not supported: " . $cipher);
        }

        $iv = null;
        $tag = null; // When using GCM mode, the openssl_encrypt function automatically generates an authentication tag, which is a critical part of ensuring data integrity. This tag is calculated based on the ciphertext and the associated data.

        if (in_array($cipherMode, ['cbc', 'gcm', 'ctr'])) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
        }

        if ($cipherMode === 'ecb') {
            $ciphertext = openssl_encrypt($plaintext, $cipher, $key); //OPENSSL_RAW_DATA
        } 
        elseif ($cipherMode === 'gcm') {
            $ciphertext = openssl_encrypt($plaintext, $cipher, $key,0, $iv, $tag);
            $ciphertext = $iv . $ciphertext . $tag;
        }
        else { // For CBC and CTR
            $ciphertext = openssl_encrypt($plaintext, $cipher, $key,0, $iv); //OPENSSL_RAW_DATA
            $ciphertext = $iv . $ciphertext; //It ensures that the same plaintext encrypted multiple times results in different ciphertexts, enhancing security.
        }

        return ($outputFormat === 'Hex') ? bin2hex($ciphertext) : base64_encode($ciphertext);
    }

    function decryptData($ciphertext, $key, $cipherMode, $keySize, $outputFormat) {
        $ciphertext = ($_POST['outputFormatEncrypt'] === 'Hex') ? hex2bin($ciphertext) : base64_decode($ciphertext);

        $iv = null;
        $tag = null;

        if (in_array($cipherMode, ['cbc', 'gcm', 'ctr'])) {
            $iv_length = openssl_cipher_iv_length("aes-$keySize-$cipherMode");
            $iv = substr($ciphertext, 0, $iv_length);
    
            if ($cipherMode === 'gcm') {
                $tag_length = 16; // GCM tag is usually 16 bytes
                $tag = substr($ciphertext, -$tag_length);
                $ciphertext = substr($ciphertext, $iv_length, -$tag_length);
            } else {
                $ciphertext = substr($ciphertext, $iv_length);
            }
        }

        if ($cipherMode === 'ecb') {
            $decrypted = openssl_decrypt($ciphertext, "aes-$keySize-ecb", $key); // OPENSSL_RAW_DATA
        }
        elseif ($cipherMode === 'gcm') {
            $decrypted = openssl_decrypt($ciphertext, "aes-$keySize-gcm", $key,0, $iv, $tag);
        }
         else {
            $decrypted = openssl_decrypt($ciphertext, "aes-$keySize-$cipherMode", $key,0, $iv); //OPENSSL_RAW_DATA
        }

        return ($outputFormat === 'PlainText') ? $decrypted : base64_encode($decrypted);
    }
?>