<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Auth extends RestController {
	private $_master;
	private $_AuthToken;
	private $_TokenKey;
    private $_ApiKey;
	private $_RsToken;
	private $_AuthCheck;
	
    function __construct() {
        // Construct the parent class
        parent::__construct();
		$this->load->library(['ion_auth']);
		$this->lang->load('auth');
		$this->_master		= new Master();
		$this->_AuthToken	= new AuthToken();
		$this->_AuthCheck	= new AuthCheck();
		$this->_TokenKey	= $this->input->post('token');
        $this->_ApiKey		= $this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]);
    }

	public function index_get() {
		$this->response([
			'status'    => true,
			'csrfHash'  => $this->security->get_csrf_hash(),
			'info'      => 'csrf token created',
		], RestController::HTTP_CREATED);
	}

    public function index_post($keterangan) {
        if ($keterangan=='login') {
			// check to see if the user is logging in
				if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'))) {
					//if the login is successful redirect them back to the home page
					$rsGetKey	=   $this->_master->get_row('token',['user_id'=>$this->session->userdata('user_id')])->row();
					if ($rsGetKey==null || $rsGetKey->key!=$this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0])) { // Check hit by postman
						$http   = RestController::HTTP_BAD_REQUEST;
                        $output = array(
                            'title'     => 'User Login Not Verified',
							'message'   => 'Remember Your Email and Password',
							'info'		=> 'error',
                            'location'	=> 'login',
                        );
					} else {
						// create token
						$tokenData = array(
							'user_id'				=> $this->session->userdata('user_id'),
							'authkey'				=> base64_encode($this->input->post('email').':'.$this->input->post('password')),
							'apikey'				=> $rsGetKey->key,
							'identity'				=> $this->session->userdata('identity'),
							'last_check'			=> $this->session->userdata('last_check'),
							'session_hash'			=> $this->session->userdata('session_hash'),
							'expired'				=> $this->session->userdata('expired'),
						);
						$this->session->set_userdata('user_token', $this->_AuthToken->generateToken($tokenData,$rsGetKey->key));
						$http   = RestController::HTTP_CREATED;
						$output = array(
							'token'		=> $this->session->userdata('user_token'),
							'location'	=> 'dashboard',
						);
					}
				} else {
					// if the login was un-successful redirect them back to the login page
					$http   = RestController::HTTP_BAD_REQUEST;
                    $output = array(
                        'title'     => 'User Login Not Found',
						'message'   => 'Remember your email and password',
						'info'		=> 'error',
                        'location'	=> 'login',
                    );
				}
        }
		if ($keterangan=='logout') {
			// log the user out
			// var_dump($this->_TokenKey,$this->_ApiKey); return false;
			$this->_RsToken		= $this->_AuthToken->validateTimestamp($this->_TokenKey,$this->_ApiKey);
			var_dump($this->_RsToken); return false;
			if (is_object($this->_RsToken)) {
				$this->ion_auth->logout($this->_RsToken->apikey);
				$http   = RestController::HTTP_CREATED;
                $output = array(
                    'title'		=> $this->ion_auth->messages(),
					'message'   => 'Thank You',
					'info'		=> 'success',
                    'location'	=> 'login',
                );
			} else {
				$http   = RestController::HTTP_BAD_REQUEST;
                $output = array(
                	'title'     => 'Login Error',
                    'message'   => $this->_RsToken,
                    'info'		=> 'error',
                    'location'	=> 'login',
                );
			}
		}
		$this->response($this->_AuthCheck->response($output),$http);
    }
	
}
?>
