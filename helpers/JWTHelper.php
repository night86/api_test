<?php
namespace Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper {
    private static $secret_key = 'FJ3498y5nhertui743hf';
    private static $issuer = 'http://localhost';
    private static $audience = 'http://localhost';
    private static $issuedAt;
    private static $expire;

    public static function generateToken($userId, $email) {

        self::$issuedAt = time();
        self::$expire = self::$issuedAt + 3600; // Token valid for 1 hour

        $token = [
            'iss' => self::$issuer,
            'aud' => self::$audience,
            'iat' => self::$issuedAt,
            'exp' => self::$expire,
            'data' => [
                'id' => $userId,
                'email' => $email
            ]
        ];

        return JWT::encode($token, self::$secret_key, 'HS256');
    }

    public static function validateToken($jwt) {
        try {
            $decoded = JWT::decode($jwt, new Key(self::$secret_key, 'HS256'));
            return (array) $decoded->data;
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>
