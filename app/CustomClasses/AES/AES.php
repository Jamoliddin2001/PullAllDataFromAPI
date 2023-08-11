<?php


namespace App\CustomClasses\AES;

class AES
{
    private static string $key = "8dddefa21cd89f289f4839d465e81d0643bdd34928d43515ed2114d8068a3d57";
    private static string $cipher_method = "aes-128-gcm";
    private static int $options = 0;

    public static function encrypt($text, $iv, &$tag)
    {
        return openssl_encrypt($text, self::$cipher_method, self::$key, self::$options, $iv, $tag);
    }

    public static function decrypt($cipherText, $iv, $tag)
    {
        return openssl_decrypt($cipherText, self::$cipher_method, self::$key, self::$options, $iv, $tag);
    }
}
