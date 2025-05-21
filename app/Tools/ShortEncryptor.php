<?php
namespace App\Tools;
class ShortEncryptor
{
    private string $key = 'dkeidkcjsuejdkfo'; // 必须为 16 / 24 / 32 字节
    private string $iv = 'aksixkdjrnvjdk3x';  // 16 字节初始化向量
    private string $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function encrypt(array $data): string
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $encrypted = openssl_encrypt($json, 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);
        return $this->base62Encode($encrypted);
    }

    public function decrypt(string $data): ?array
    {
        $binary = $this->base62Decode($data);
        $json = openssl_decrypt($binary, 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);
        return json_decode($json, true);
    }

    private function base62Encode(string $binary): string
    {
        $hex = bin2hex($binary);
        $decimal = $this->hexToDec($hex);
        return $this->decToBase62($decimal);
    }

    private function base62Decode(string $base62): string
    {
        $decimal = $this->base62ToDec($base62);
        $hex = $this->decToHex($decimal);
        if (strlen($hex) % 2 !== 0) $hex = '0' . $hex;
        return hex2bin($hex);
    }

    private function hexToDec(string $hex): string
    {
        $dec = '0';
        $len = strlen($hex);
        for ($i = 0; $i < $len; $i++) {
            $current = hexdec($hex[$i]);
            $dec = bcmul($dec, '16');
            $dec = bcadd($dec, (string)$current);
        }
        return $dec;
    }

    private function decToHex(string $dec): string
    {
        $hex = '';
        while (bccomp($dec, '0') > 0) {
            $rem = bcmod($dec, '16');
            $hex = dechex($rem) . $hex;
            $dec = bcdiv($dec, '16', 0);
        }
        return $hex === '' ? '0' : $hex;
    }

    private function decToBase62(string $dec): string
    {
        $base = strlen($this->chars);
        $res = '';
        while (bccomp($dec, '0') > 0) {
            $rem = bcmod($dec, (string)$base);
            $res = $this->chars[(int)$rem] . $res;
            $dec = bcdiv($dec, (string)$base, 0);
        }
        return $res === '' ? '0' : $res;
    }

    private function base62ToDec(string $base62): string
    {
        $base = strlen($this->chars);
        $dec = '0';
        $len = strlen($base62);
        for ($i = 0; $i < $len; $i++) {
            $pos = strpos($this->chars, $base62[$i]);
            $dec = bcmul($dec, (string)$base);
            $dec = bcadd($dec, (string)$pos);
        }
        return $dec;
    }
}
