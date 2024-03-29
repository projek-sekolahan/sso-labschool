<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthToken extends CI_Model {

    public function validateTimestamp($token,$key)
    {
        if ($token==null) {
            $data = array("apikey"=>$key);
            $token = $this->generateToken($data,$key);
            $token = $this->validateToken($token,$key);
            return $token;
        } else {
            $token = $this->validateToken($token,$key);
            if (is_object($token)) {
                if ($token != false && (now() < $token->expired)) {
                    return $token;
                } else {
                    return $token;
                }
            } else {
                return $token;
            }
        }
    }

    public function validateToken($token,$key)
    {
        try {
            return JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function generateToken($data,$key)
    {
        try {
            return JWT::encode($data, $key, 'HS256');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
?>