<?php

class encryption
{
    public function encrypt($str, $secret_key = "mariadb", $secret_iv = "#@$%^&*()_+=-")
    {
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        return str_replace("=", "", base64_encode(openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv)));
    }

    public function decrypt($str, $secret_key = "mariadb", $secret_iv = "#@$%^&*()_+=-")
    {
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        return openssl_decrypt(base64_decode($str), "AES-256-CBC", $key, 0, $iv);
    }
}
?>