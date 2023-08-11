<?php


namespace App\CustomClasses\AES;



use App\Models\Key;

class GetKey
{
    public static function get($key_id)
    {
        $key = Key::where('id', $key_id)->first();
        if ($key == '') return '';

        $key_cipher = $key->key;
        $tag_cipher = base64_decode($key->tag_key);

        $hash_key = hash('sha256', '4bcfa16885bc2cde6c1fd0f759dece07407c20ca18cdcbc5f5cb4e333b4e3477');

        return AES::decrypt($key_cipher, $hash_key, $tag_cipher);
    }
}
