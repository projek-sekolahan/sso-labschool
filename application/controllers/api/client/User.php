<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
class User extends RestController {

    private $_clientAPI;
    private $_AuthToken;
    private $_AuthCheck;
    private $_csrfToken;
    private $_paramToken;
    function __construct() {
        parent::__construct();
        $this->_clientAPI   = new ClientAPI();
        $this->_AuthToken   = new AuthToken();
        $this->_AuthCheck   = new AuthCheck();
        $this->_csrfToken   = $this->_clientAPI->crToken('user',$this->input->post('AUTH_KEY'));
        $this->_paramToken  = array(
            'token'     => (empty($this->session->userdata('token'))) ? $this->input->post('token'):$this->session->userdata('token'),
            explode('.',$_SERVER['HTTP_HOST'])[0] => $this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]),
            'AUTH_KEY'  => $this->input->post('AUTH_KEY'),
            'csrf_token'=> $this->_csrfToken,
        );
    }
    
    private function responsejson($result,$dtAPI) {
        if ($result->getStatusCode()==400 || $result->getStatusCode()==403) {
            $http   = RestController::HTTP_BAD_REQUEST;
            $output = $dtAPI['data'];
        } else {
            $http       = RestController::HTTP_CREATED;
            $output = $this->_AuthToken->generateToken($dtAPI['data'],$this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]));
        }
        return $this->response($this->_AuthCheck->response($output),$http);
    }

    private function eResponse() {
        $http   = RestController::HTTP_BAD_REQUEST;
        $output = array(
            'title'     => 'Invalid',
            'message'   => $this->lang->line('text_rest_invalid_credentials'),
            'info'		=> 'error',
            'location'	=> 'dashboard',
        );
        $this->response($this->_AuthCheck->response($output),$http);
    }

    public function index_post($keterangan) {
        if ($this->_AuthCheck->checkTokenApi($keterangan,$this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]),$this->input->post('AUTH_KEY'))) {
            $urlAPI	= 'user/'.$keterangan;
            if ($keterangan=='create' || $keterangan=='update') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
            }
            if ($keterangan=='profile_pengguna') {
                $paramdata = array(
                    'param' => $this->input->post('param'),
                );
                $dataparam = array_merge($paramdata,$this->_paramToken);
            }
            if ($keterangan=='table') {
                $spolde = explode('-',$this->input->post('table'));
                $table	= strtolower($spolde[1]);
                $paramdata = array(
                    'key'   => $this->input->post('key'),
                    'table' => $table,
                );
                $dataparam = array_merge($paramdata,$this->_paramToken);
            }
			$result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
            $dtAPI	= json_decode($result->getBody()->getContents(),true);
            $this->responsejson($result,$dtAPI);
        } else {
            $this->eResponse();
        }
    }

}
?>
