<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pages extends RestController {
	private $_master;
	private $_AuthToken;
    private $_TokenKey;
    private $_ApiKey;
    private $_AuthCheck;
    private $_RsToken;
    function __construct() {
        parent::__construct();
        $this->load->model(['Tables','UploadFile']);
        $this->load->library(['ion_auth']);
		$this->_master      = new Master();
		$this->_AuthToken   = new AuthToken();
        $this->_AuthCheck   = new AuthCheck();
        $this->_TokenKey    = $this->input->post('token');
        $this->_ApiKey      = $this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]);
        $this->_RsToken     = $this->_AuthToken->validateTimestamp($this->_TokenKey,$this->_ApiKey);
    }

	public function index_get() {
		$this->response([
			'status'    => true,
			'csrfHash'  => $this->security->get_csrf_hash(),
			'info'      => 'csrf token created',
		], RestController::HTTP_CREATED);
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
        if (is_object($this->_RsToken)) {
            if ($keterangan=='create_update') {
				$menus = array(
					'id'		=> $this->input->post('id'),
					'nama_menu'	=> $this->input->post('nama_menu'),
					'title'		=> $this->input->post('title'),
					'url'		=> $this->input->post('url'),
					'tipe_site'	=> $this->input->post('tipe_site'),
					'is_execute'=> ($this->input->post('is_execute')=='on') ? 1:0,
					'icon'		=> $this->input->post('icon'),
					'menu_groupid'	=> $this->input->post('menu_groupid'),
					'is_child'		=> ($this->input->post('is_child')=='on') ? 1:0,
				);
				$pages	= $this->_master->get_row('pages',['id'=>$this->input->post('id')])->row();
				if ($pages) {
					// update data
					$this->_master->update_data('pages',['id'=>$pages->id],$menus);
                } else {
					// create data
					$this->_master->save_data('pages' , $menus);
                }
				$output = array(
					'title'     => 'Data Updated',
					'message'   => 'Success Updated',
					'info'		=> 'success',
					'location'	=> 'dashboard',
				);
				$http       = RestController::HTTP_CREATED;
				$output     = $output;
            }
            if ($keterangan=='menu_akses') {
                $sqlpages   = "SELECT a.* from pages a WHERE a.id='".$this->input->post('param')."'";
				$result     = $this->_master->get_custom_query($sqlpages)->result();
				$rsrow		= $this->_master->get_row('pages',['is_child'=>0])->result();
				$http		= RestController::HTTP_CREATED;
				$output		= array('result'=>$result,'menu'=>$rsrow);
            }
            if ($keterangan=='table') {
                $key	= $this->input->post('key');
                $table	= $this->input->post('table');
				$select = "a.id,a.nama_menu,a.title,a.url,a.is_child";
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
                $http   = RestController::HTTP_CREATED;
                $output = $createTables;
            }
			$this->response($this->_AuthCheck->response($output),$http);
        } else {
            $this->eResponse();
        }
    }
}
?>
