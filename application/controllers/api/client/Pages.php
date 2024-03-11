<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
class Pages extends RestController {

    private $_clientAPI;
    private $_AuthToken;
    private $_AuthCheck;
    private $_csrfToken;
    private $_paramToken;
    function __construct() {
        parent::__construct();
		$this->load->model(['Tables','UploadFile']);
        $this->_clientAPI   = new ClientAPI();
        $this->_AuthToken   = new AuthToken();
        $this->_AuthCheck   = new AuthCheck();
        $this->_csrfToken   = $this->_clientAPI->crToken('pages',$this->input->post('AUTH_KEY'));
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
            $urlAPI	= 'pages/'.$keterangan;
            if ($keterangan=='create_update') {
                $dataparam = array_merge($this->input->post(),$this->_paramToken);
            }
            if ($keterangan=='profile' || $keterangan=='profile_pengguna' || $keterangan=='detail_pengguna_edit') {
				$keterangan=='profile' ? $param = $this->_AuthToken->validateToken($this->input->post('param'),$this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0])) : $param = $this->input->post('param');
				is_object($param) ? $param = explode(":",base64_decode($param->authkey))[0] : $param = $param;
				if (filter_var($param, FILTER_VALIDATE_EMAIL)) {
					$paramdata = array(
						'param' => $param,
					);
					$dataparam = array_merge($paramdata,$this->_paramToken);
				}
				else {
					$this->eResponse();
				}
            }
            if ($keterangan=='table') {
                $spolde = explode('-',$this->input->post('table'));
                $table	= strtolower($spolde[1]);
                /* $paramdata = array(
                    'key'   => $this->input->post('key'),
                    'table' => $table,
                );
                $dataparam = array_merge($paramdata,$this->_paramToken); */

				$key	= $this->input->post('key');
                // $table	= $this->input->post('table');
                    $select = "a.nama_menu,a.title,a.url,a.tipe_site";
                    $column = "a.nama_menu,a.title";
                    //WHERE
                    $where	= null;
                    //where2 
                    $where2	= null;
                    //join
                    $join	= null;
                    // group by
                    $group_by   =   NULL;
                    //ORDER
                    $index_order = $this->input->get('order[0][column]');
                    $order['data'][] = array(
                        'column' => $this->input->get('columns['.$index_order.'][name]'),
                        'type'	 => $this->input->get('order[0][dir]')
                    );
                    //LIMIT
                    $limit = array(
                        'start'  => $this->input->get('start'),
                        'finish' => $this->input->get('length')
                    );
                //WHERE LIKE
                $where_like['data'][] = array(
                    'column' => $column,
                    'param'	 => $this->input->get('search[value]')
                );
                $createTables   =   $this->Tables->detailTables($select,$table,$limit,$where_like,$order,$join,$where,$where2,$group_by,$key);
                var_dump($createTables); return false;

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
