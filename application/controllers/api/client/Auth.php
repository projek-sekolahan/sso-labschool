<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Auth extends RestController {

    private $_clientAPI;
    private $_AuthToken;
    private $_AuthCheck;
    function __construct() {
        parent::__construct();
        $this->load->library(['api_auth']);
        $this->_clientAPI = new ClientAPI();
        $this->_AuthToken = new AuthToken();
        $this->_AuthCheck = new AuthCheck();
    }
    public function index_post($keterangan) {
        if ($this->_AuthCheck->checkTokenApi($keterangan,$this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]),$this->input->post('AUTH_KEY'))) {
            $rscr = null;
            if ($keterangan=='login') {
                if (filter_var($this->input->post('username'), FILTER_VALIDATE_EMAIL)) {
                    $urlAPI	= 'auth/login';
                    $dtAuth = base64_encode($this->api_auth->login($this->input->post('username'),$this->input->post('password')));
                    $rscr   = $this->_clientAPI->crToken($urlAPI,$dtAuth);
                    $result	= $this->_clientAPI->geToken($urlAPI,$dtAuth,$rscr);
                    $dtAPI	= json_decode($result->getBody()->getContents(),true);
                    if ($result->getStatusCode()==400 || $result->getStatusCode()==403) {
                        $http   = RestController::HTTP_BAD_REQUEST;
                        $output = $dtAPI['data'];
                    } else {
                        $decode = $this->_AuthToken->validateTimestamp($dtAPI['data']['token'],$this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]));
                        if (is_object($decode)) {
                            $token_data = array(
                                'authkey'       => $decode->authkey,
                                'apikey'        => $decode->apikey,
                                'last_check'    => $decode->last_check,
                                'session_hash'  => $decode->session_hash,
                                'expired'       => $decode->expired,
                            );
                            $tokenJWT = $this->_AuthToken->generateToken($token_data,$decode->apikey);
                            $identity_data = array(
                                'user_id'       => $decode->user_id,
                                'identity'      => $decode->identity,
                                'token'         => $tokenJWT,
                            );
                            $session_data = array_merge($token_data,$identity_data);
                            $this->session->set_userdata($session_data);
                            $http   = RestController::HTTP_CREATED;
                            $output = array(
                                'title'     => 'Login Success',
                                'message'   => 'Welcome Back',
                                'info'		=> 'success',
                                'Tokenjwt'  => $tokenJWT,
                                'location'	=> $dtAPI['data']['location'],
                            );
                        } else {
                            $http   = RestController::HTTP_BAD_REQUEST;
                            $output = array(
                                'title'     => 'Login Error',
                                'message'   => $decode,
                                'info'		=> 'error',
                                'location'	=> 'login',
                            );
                        }
                    }
                } else {
                    $http   = RestController::HTTP_BAD_REQUEST;
                    $output = array(
                        'title'     => 'Email Not Valid',
                        'message'   => 'Please Check Enter Your Email',
                        'info'		=> 'error',
                        'location'	=> 'login',
                    );
                }
            }
            if ($keterangan=='logout') {
                $urlAPI	= 'auth/logout';
                $rscr   = $this->_clientAPI->crToken($urlAPI,$this->input->post('AUTH_KEY'));
                $param  = array(
                    'token'         => (empty($this->session->userdata('token'))) ? $this->input->post('token'):$this->session->userdata('token'),
                    explode('.',$_SERVER['HTTP_HOST'])[0] => $this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]),
                    'csrf_token'    => $rscr,
                );
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$param);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->session->sess_destroy();
                $http   = RestController::HTTP_CREATED;
                $output = $dtAPI['data'];
            }
            if ($keterangan=='sessTime') {
                $timesesi       = $this->session->userdata('expired');
                $current_time   = time();
                ($timesesi == null) ? $sessiontime = 0:$sessiontime=$timesesi;
                    if($current_time > $sessiontime) {
                        $validtime = $this->_AuthToken->validateTimestamp($this->input->post('token'),$this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]));
                        if (is_object($validtime)) {
                            $http   = RestController::HTTP_OK;
                            $output = array(
                                'title'     => 'Your Session OK',
                                'message'   => 'Thank You!',
                                'info'		=> 'success',
                                'location'	=> 'dashboard',
                            );
                        }
                        else {
                            $this->session->sess_destroy();
                            $http   = RestController::HTTP_CREATED;
                            $output = array(
                                'title'     => 'Your Session Timeout',
                                'message'   => 'Thank You!',
                                'info'		=> 'success',
                                'location'	=> 'login',
                            );
                        }
                    } else {
                        $http   = RestController::HTTP_OK;
                        $output = array(
                            'title'     => 'Your Session OK',
                            'message'   => 'Thank You!',
                            'info'		=> 'success',
                            'location'	=> 'dashboard',
                        );
                    }
            }            
        } else {
            $http   = RestController::HTTP_BAD_REQUEST;
            $output = array(
                'title'     => 'Invalid',
                'message'   => $this->lang->line('text_rest_invalid_credentials'),
                'info'		=> 'error',
                'location'	=> 'login',
            );
        }
        $this->response($this->_AuthCheck->response($output),$http);
    }

}
?>
