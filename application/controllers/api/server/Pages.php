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
				$hasil_img = NULL;
				$jsonimg = json_decode($this->input->post('img'),true);
                    if (count($jsonimg)!=0) {
                        for ($i=0; $i < count($jsonimg); $i++) {
                            $hasil_img = $this->UploadFile->photo('img','users',['nomor_induk'=>$this->input->post('nomor_induk'),'img'=>$jsonimg[$i],'table'=>'users_img']);
                        }
                    }
					$hasil_img == NULL ? $userimg = NULL: 
					$userimg = array(
						'nomor_induk'	=> $this->input->post('nomor_induk'),
						'img_location'  => $hasil_img,
					);
					$datasosmed = array(
						'user_id'       => $this->input->post('user_id'),
						'link_facebook' => $this->input->post('link_facebook'),
						'link_instagram'=> $this->input->post('link_instagram'),
						'link_twitter'	=> $this->input->post('link_twitter'),
					);
					$userdetail = array(
						'nomor_induk'	=> $this->input->post('nomor_induk'),
						'phone'			=> $this->input->post('phone'),
						'nama_lengkap'	=> $this->input->post('nama_lengkap'),
						'jabatan'		=> $this->input->post('jabatan'),
						'pangkat_golongan'	=> $this->input->post('pangkat_golongan'),
						'bagian_divisi'	=> $this->input->post('bagian_divisi'),
					);
                $users	= $this->_master->get_row('users_sosmed',['user_id'=>$this->input->post('user_id')])->row();
                if ($users) {
					// update data
					$hasil_img==NULL ? '' : $this->_master->update_data('users_img',['nomor_induk'=>$this->input->post('nomor_induk')],$userimg);
					$this->_master->update_data('users_sosmed',['user_id'=>$users->user_id],$datasosmed);
					$this->_master->update_data('users_details',['user_id'=>$users->user_id],$userdetail);
                } else {
					// create data
					$hasil_img==NULL ? '' : $this->_master->save_data('users_img' , $userimg);
					$this->_master->save_data('users_sosmed' , $datasosmed);
					$this->_master->update_data('users_details',['user_id'=>$users->user_id],$userdetail);
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
                $sqluser    = "SELECT a.* from pages a WHERE a.pages_id='".$this->input->post('param')."'";
				$result     = $this->_master->get_custom_query($sqluser)->row();
                if ($result==null) {
                    $http   = RestController::HTTP_CREATED;
                    $output = array(
                        'title'     => 'New Pages Menu',
                        'message'   => 'Pages Menu Created',
                        'info'		=> 'success',
                        'location'	=> 'dashboard',
                    );
                } else {
                    $http       = RestController::HTTP_CREATED;
                    $output     = get_object_vars($result);
                }
            }
            if ($keterangan=='table') {
                $key	= $this->input->post('key');
                $table	= $this->input->post('table');
				$select = "a.id,a.nama_menu,a.title,a.url,a.tipe_site";
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
