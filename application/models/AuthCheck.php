<?php
#[\AllowDynamicProperties]
	class AuthCheck extends CI_model {
        private $_AuthKey;
        private $_ApiKey;
        function __construct() {
            parent::__construct();
            $this->_master      = new Master();
            $this->_AuthKey     = $this->session->userdata('authkey');
            $this->_ApiKey      = $this->session->userdata('apikey');
        }
        function checkTokenApi($pages,$key,$auth) {
            if ($pages!='login') {
                $users	= $this->_master->get_row('token',['key'=>$key])->row();
                if (($key==$this->_ApiKey) && ($auth==$this->_AuthKey)) {
                    return true;
                } else {
                    if (!empty($users)) {
                        return true;
                    } else {
                        $this->session->sess_destroy();
                        return false;
                    }
                }
            } else {
                return true;
            }
        }
        function response($data) {
            $response = array(
                'data'      => $data,
                'csrfHash'  => $this->security->get_csrf_hash(),
            );
            return $response;
        }
    }
?>
