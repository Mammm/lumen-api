<?php


namespace App\Services\OutApi;


class AESUtils
{
    const CODE = "AES";

    const CIPHER_METHOD = "aes-128-ecb";

    const KEY = 'abcd1234abcd1234';

    /**
     * 加密
     * @param string $data
     * @return string
     */
    public static function encrypt(string $data): string
    {
        $result = openssl_encrypt($data, self::CIPHER_METHOD, self::KEY, OPENSSL_RAW_DATA);
        return strtoupper(bin2hex($result));
    }

    /**
     * 解密
     * @param string $data
     * @return string
     */
    public static function decrypt(string $data): string
    {
        $result = hex2bin(strtolower($data));
        return openssl_decrypt($result, self::CIPHER_METHOD, self::KEY, OPENSSL_RAW_DATA);
    }
}
