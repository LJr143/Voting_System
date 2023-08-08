<?php
function encrypt($data){
        // Store the cipher method 
        $ciphering = "AES-256-CFB"; 
        
        // Use OpenSSl Encryption method 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        
        // Non-NULL Initialization Vector for encryption 
        $encryption_iv = "1234567891011121"; 
        
        // Store the encryption key 
        $encryption_key = "KramBangcaya1999"; 
        
        // Use openssl_encrypt() function to encrypt the data 
        $encryption = openssl_encrypt($data, $ciphering, 
                    $encryption_key, $options, $encryption_iv); 
    
        //Return Encrypt
        return $encryption;
    }
?>