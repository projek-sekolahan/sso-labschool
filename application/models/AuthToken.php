<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthToken extends CI_Model {

    public function validateTimestamp($token,$key)
    {
        if ($token==null) {
            $data	= array("apikey"=>$key);
            $token	= $this->generateToken($data,$key);
            $token	= $this->validateToken($token,$key);
            return $token;
        } else {
			// var_dump($token,$key);
            $token = $this->validateToken($token,$key);
			var_dump(is_object($token));
            if (is_object($token)) {
				var_dump($token != false && (now() < isset($token->expired)));
                if ($token != false && (now() < isset($token->expired))) {
                    return $token;
                } else {
					return $this->generateToken(
						$this->decrypt(
							$token->data,
							hash('sha256',explode('.',$_SERVER['HTTP_HOST'])[1]),
							substr(hash('sha256',explode('.',$_SERVER['HTTP_HOST'])[1]), 0, 16)
						),$key
					);
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
