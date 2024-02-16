<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Calendar extends RestController {
    private $_master;
    private $_clientAPI;
    private $_AuthToken;
    private $_AuthCheck;
    private $_csrfToken;
    private $_paramToken;
    function __construct() {
        parent::__construct();
        $this->_master      = new Master();
        $this->_clientAPI   = new ClientAPI();
        $this->_AuthToken   = new AuthToken();
        $this->_AuthCheck   = new AuthCheck();
        // $this->_csrfToken   = $this->_clientAPI->crToken('calendar',$this->input->post('AUTH_KEY'));
        $this->_paramToken  = array(
            'token'     => (empty($this->session->userdata('token'))) ? $this->input->post('token'):$this->session->userdata('token'),
            explode('.',$_SERVER['HTTP_HOST'])[0] => $this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]),
            'AUTH_KEY'  => $this->input->post('AUTH_KEY'),
            'csrf_token'=> $this->_csrfToken,
        );
    }
    
    private function responsejson($result,$dtAPI) {
        if ($result->getStatusCode()==400 || $result->getStatusCode()==403 || $result->getStatusCode()==500) {
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
            $urlAPI	= 'calendar/'.$keterangan;
            if ($keterangan=='createScreen') {
                $paramdata = array(
                    'param' => $this->input->post(),
                    'user'  => $this->session->userdata('user_id'),
                );
                $dataparam = array_merge($paramdata,$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='updateScreen') {
                $paramdata = array(
                    'param' => $this->input->post(),
                    'user'  => $this->session->userdata('user_id'),
                );
                $dataparam = array_merge($paramdata,$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='createMonth') {
                $paramdata = array(
                    'param' => $this->input->post(),
                    'user'  => $this->session->userdata('user_id'),
                );
                $dataparam = array_merge($paramdata,$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='updateMonth') {
                $paramdata = array(
                    'param' => $this->input->post(),
                    'user'  => $this->session->userdata('user_id'),
                );
                $dataparam = array_merge($paramdata,$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='search') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='article') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='splash') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='layar_kalender_edit') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='layar_kalender_delete') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='bulan_kalender_edit') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='bulan_kalender_delete') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='create') {
                $paramdata = array(
                    'param' => $this->input->post(),
                    'user'  => $this->session->userdata('user_id'),
                );
                $dataparam = array_merge($paramdata,$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='read') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='update') {
                $paramdata = array(
                    'param' => $this->input->post(),
                    'user'  => $this->session->userdata('user_id'),
                );
                $dataparam = array_merge($paramdata,$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='delete') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$dataparam);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
            if ($keterangan=='table') {
                $table	= strtolower(explode('-',$this->input->post('table'))[1]);
                $paramdata = array(
                    'key'   => $this->input->post('key'),
                    'table' => $table,
                );
                $tabledata = array_merge($paramdata,$this->_paramToken);
                $result	= $this->_clientAPI->postContent($urlAPI,$this->input->post('AUTH_KEY'),$tabledata);
                $dtAPI	= json_decode($result->getBody()->getContents(),true);
                $this->responsejson($result,$dtAPI);
            }
        } else {
            $this->eResponse();
        }
    }

}
?>