<?php

function encryptFile($path)
{
    // cipher method
    $method = config('app.cipher');
    $options = 0;

    // Random Vector for encryption
    $iv = openssl_random_pseudo_bytes(16);

    // encryption key
    $key = config('app.key');
    //function to encrypt the data
    $encryption =  openssl_encrypt(
        file_get_contents(url($path)),
        $method,
        $key,
        $options,
        $iv
    );

    return $encryption;
}
function decryptFile($path)
{

    // cipher method
    $method = config('app.cipher');
    $options = 0;

    // Random Vector for encryption
    $iv = openssl_random_pseudo_bytes(16);

    // encryption key
    $key = config('app.key');

    //function to encrypt the data
    $encryption = openssl_encrypt(
        file_get_contents(url($path)),
        $method,
        $key,
        $options,
        $iv
    );

    //function to decrypt the data
    return openssl_decrypt(
        $encryption,
        $method,
        $key,
        $options,
        $iv
    );
}
