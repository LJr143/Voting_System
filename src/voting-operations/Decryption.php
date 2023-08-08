<?php
function decryption($encryptionData){

    // Store the cipher method 
    $ciphering = "AES-256-CFB"; 
            
    // Use OpenSSl Encryption method 
    $iv_length = openssl_cipher_iv_length($ciphering); 
    $options = 0; 

    // Non-NULL Initialization Vector for decryption 
    $decryption_iv = "1234567891011121"; 
        
    // Store the decryption key 
    $decryption_key = "KramBangcaya1999"; 

    // Use openssl_decrypt() function to decrypt the data 
    $decryption=openssl_decrypt ($encryptionData, $ciphering,$decryption_key, $options, $decryption_iv); 

    //Return Encrypt
    return $decryption;
}
?>