<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController {
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
            if ($keterangan=='create') {
                $users	= $this->_master->get_row('users_details',['nomor_induk'=>$this->input->post('nip')])->row();
                if (empty($users->email)) {
                    $jsonimg = json_decode($this->input->post('img'),true);
                    if (count($jsonimg)!=0) {
                        for ($i=0; $i < count($jsonimg); $i++) {
                            $hasil_img = $this->UploadFile->photo('img','users',['nomor_induk'=>$this->input->post('nip'),'img'=>$jsonimg[$i],'table'=>'users_img']);
                        }
                        $userimg = array(
                            'nomor_induk'           => $this->input->post('nip'),
                            'img_location'  => $hasil_img,
                        );
                        $this->_master->save_data('users_img' , $userimg);
                    }
                    $hash = $this->ion_auth_model->hash_password($this->input->post('password'));
                    $userlogin = array(
                        'username'		=> explode('@',$this->input->post('email'))[0],
                        'password'      => $hash,
                        'ip_addresses'	=> $this->input->ip_address(),
                        'created_on'	=> time(),
                        'active'		=> 1
                    );
                    $this->_master->save_data('users_login' , $userlogin);
                    $id = $this->db->insert_id('users_login' . '_id_seq');
                    $tokenkey	= hash('sha1',base64_encode($this->input->post('email').':'.$this->input->post('password')));
                    $usergroup = array(
                        'user_id'	=> $id,
                        'group_id'	=> 2,
                    );
                    $this->_master->save_data('users_groups' , $usergroup);
                    $datatoken = array(
                        'user_id'		=> $id,
                        'key'			=> $tokenkey,
                        'level'			=> 2,
                        'ip_addresses'	=> $this->input->ip_address(),
                        'date_created'	=> time(),
                    );
                    $this->_master->save_data('token' , $datatoken);
                    $datasosmed = array(
                        'user_id'       => $id,
                        'link_facebook' => $this->input->post('link_facebook'),
                        'link_instagram'=> $this->input->post('link_instagram'),
                        'link_twitter'	=> $this->input->post('link_twitter'),
                    );
                    $this->_master->save_data('users_sosmed' , $datasosmed);
                    $userdetail = array(
                        'user_id'		=> $id,
                        'email'			=> $this->input->post('email'),
                        'nomor_induk'	=> $this->input->post('nip'),
                        'phone'			=> $this->input->post('phone'),
                        'nama_lengkap'	=> $this->input->post('nama_lengkap'),
                        'jabatan'		=> $this->input->post('jabatan'),
                        'pangkat_golongan'	=> $this->input->post('pangkat_golongan'),
                        'bagian_divisi'	=> $this->input->post('bagian_divisi'),
                    );
                    $this->_master->save_data('users_details' , $userdetail);
                    $output = array(
                        'title'     => 'Data Activated',
                        'message'   => 'Login Activated',
                        'info'		=> 'success',
                        'location'	=> 'dashboard',
                    );
                    $http       = RestController::HTTP_CREATED;
                    $output     = $output;

                } else {
                    $this->eResponse();
                }
            }
            if ($keterangan=='update') {
                $users	= $this->_master->get_row('users_details',['user_id'=>$this->input->post('user_id')])->row();
                if (!empty($users)) {
                    $jsonimg = json_decode($this->input->post('img'),true);
                    if (count($jsonimg)!=0) {
                        for ($i=0; $i < count($jsonimg); $i++) {
                            $hasil_img = $this->UploadFile->photo('img','users',['nomor_induk'=>$this->input->post('nip'),'img'=>$jsonimg[$i],'table'=>'users_img']);
                        }
                        $userimg = array(
                            'nomor_induk'	=> $this->input->post('nip'),
                            'img_location'  => $hasil_img,
                        );
                        $this->_master->update_data('users_img',['nomor_induk'=>$users->nomor_induk],$userimg);
                    }
                    $datasosmed = array(
                        'link_facebook' => $this->input->post('link_facebook'),
                        'link_instagram'=> $this->input->post('link_instagram'),
                        'link_twitter'	=> $this->input->post('link_twitter'),
                    );
                    $this->_master->update_data('users_sosmed',['user_id'=>$users->user_id],$datasosmed);
                    $userdetail = array(
                        'email'			=> $this->input->post('email'),
                        'nomor_induk'	=> $this->input->post('nip'),
                        'phone'     	=> $this->input->post('phone'),
                        'nama_lengkap'  => $this->input->post('nama_lengkap'),
                        'jabatan'   	=> $this->input->post('jabatan'),
                        'pangkat_golongan'  => $this->input->post('pangkat_golongan'),
                        'bagian_divisi' => $this->input->post('bagian_divisi'),
                    );
                    $this->_master->update_data('users_details',['user_id'=>$users->user_id],$userdetail);
                    $output = array(
                        'title'     => 'Data Updated',
                        'message'   => 'Success Updated',
                        'info'		=> 'success',
                        'location'	=> 'dashboard',
                    );
                    $http       = RestController::HTTP_CREATED;
                    $output     = $output;
                } else {
                    $this->eResponse();
                }
            }
            if ($keterangan=='profile_pengguna') {
                $sqluser    = "SELECT a.*,b.*,c.* from users_details a,users_sosmed b,users_img c WHERE a.user_id=b.user_id AND a.nomor_induk=c.nomor_induk AND a.email='".$this->input->post('param')."'";
                $result     = $this->_master->get_custom_query($sqluser)->row();
                if ($result==null) {
                    $http   = RestController::HTTP_BAD_REQUEST;
                    $output = array(
                        'title'     => 'Data Not Found',
                        'message'   => 'Profile Not Found',
                        'info'		=> 'error',
                        'location'	=> 'dashboard',
                    );
                } else {
                    $http       = RestController::HTTP_CREATED;
                    $output     = $result;
                }
            }
            if ($keterangan=='table') {
                $key	= $this->input->post('key');
                $table	= $this->input->post('table');
                    $select = "a.*";
                    $column = "a.nomor_induk,a.nama_lengkap";
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
        } else {
            $http   = RestController::HTTP_BAD_REQUEST;
            $output = array(
                'title'     => 'Invalid Token API',
                'message'   => $this->_RsToken,
                'info'		=> 'error',
                'location'	=> 'dashboard',
            );
        }
        $this->response($this->_AuthCheck->response($output),$http);
    }
}
?>
