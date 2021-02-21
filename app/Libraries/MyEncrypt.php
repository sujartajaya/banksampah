<?php

namespace App\Libraries;

class MyEncrypt
{

    /** Class MyEncrypt */
    /* 
     *  Oleh: I Putu Gede Sujarta Jaya
     *  2021
     *    
    */
    //Key encryption diisi manual saat kelas dipanggil
    private $key = 'aBigsecret_ofAtleast32Characters';

    //IV dibuat automatis
    private $iv;

    //hasil encrypt
    private $encrypt;

    public function setKey($nkey)
    {
        $this->key = $nkey;
    }

    public function setIv($niv)
    {
        $this->iv = $niv;
    }

    public function setEncrypt($enc)
    {
        $this->encrypt = $enc;
    }

    public function Encrypt($text)
    {
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($text, 'AES-256-CBC', $this->key, 0, $iv);
        $this->iv = $iv;
        $this->encrypt = $encrypted;
        return bin2hex($iv) . ":" . $encrypted;
    }

    private function ExtractEncrypt($qrencrypt)
    {
        $data = explode(":", $qrencrypt);
        $this->iv = hex2bin($data[0]);
        $this->encrypt = $data[1];
    }

    public function Decrypt($qrencrypt)
    {
        $this->ExtractEncrypt($qrencrypt);
        return openssl_decrypt($this->encrypt, 'AES-256-CBC', $this->key, 0, $this->iv);
    }
}
