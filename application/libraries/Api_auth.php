<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_auth {

    public function login($username,$password) {
        $dataAuth   =   $username.':'.$password;
        return $dataAuth;
    }

}