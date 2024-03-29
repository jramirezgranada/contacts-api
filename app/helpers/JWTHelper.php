<?php

namespace App\Helpers;

use Firebase\JWT\JWT;

class JWTHelper
{
    private static $secret_key;
    private static $encrypt;
    private static $aud = null;

    public function __construct()
    {
        self::$secret_key = getenv("SECRETKEY");
        self::$encrypt = getenv("ENCRYPT");
    }

    public static function signIn($data)
    {
        $time = time();

        $token = [
            'exp' => $time + (60 * 60),
            'aud' => self::Aud(),
            'data' => $data
        ];

        return JWT::encode($token, self::$secret_key);
    }

    public static function check($token)
    {
        if (empty($token)) {
            throw new Exception("Invalid token supplied.");
        }

        $decode = JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        );

        if ($decode->aud !== self::Aud()) {
            throw new Exception("Invalid user logged in.");
        }
    }

    public static function getData($token)
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        )->data;
    }

    private static function aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}