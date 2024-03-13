<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthToken extends CI_Model {

    public function validateTimestamp($token,$key)
    {
		if ($token==NULL) {
			return false;
		}
		$token = $this->validateToken($token,$key);
		if (is_object($token)) {
			if (isset($token->expired)) {
				if (now() < $token->expired) {
					return $token;
				}
				return false;
			}
			else {
				return $this->generateToken(
					$this->decrypt(
						$token->data, 
						hash('sha256',explode('.',$_SERVER['HTTP_HOST'])[1]), 
						substr(hash('sha256',explode('.',$_SERVER['HTTP_HOST'])[1]), 0, 16)),
						$key
					);
			}
		}
		else {
			return $token;
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

	public static function encrypt($value, $key, $iv)
	{
		$encrypted_data = openssl_encrypt($value, 'aes-256-cbc', $key, 0, $iv);
    	return base64_encode($encrypted_data);
	}

	public static function decrypt($value, $key, $iv)
	{
		$value	= base64_decode($value);
		$data	= openssl_decrypt($value, 'aes-256-cbc', $key, 0, $iv);
		return get_object_vars(json_decode($data));
	}

}
?>
