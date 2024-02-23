<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->load->library(['ion_auth']);
        $this->load->model(['Master']);
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->getURL = $_SERVER['REQUEST_URI'];
		if($this->method != 'POST') {
			redirect('dashboard/404','location', 404);
		}
	}
	
	public function recover() {
		$identity_column = $this->config->item('identity', 'ion_auth');
		$identity = $this->ion_auth->where($identity_column, $this->input->post('username'))->users()->row();
		if (empty($identity)) {
			$this->ion_auth->set_error('forgot_password_email_not_found');
			echo json_encode([
				'success'	=> 'Error',
				'status'    => False,
				'title'		=> 'Recover Gagal',
				'info'		=> 'error',
				'message'   => $this->ion_auth->errors(),
				'location'	=> 'recover',
				'csrfHash'  => $this->security->get_csrf_hash()
			]);
		} else {
			// run the forgotten password method to email an activation code to the user
			if($this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')})) {
				$output = array(
					'title'		=> 'Recover Success',
					'info'		=> 'success',
					'message'   => $this->ion_auth->messages(),
					'location'	=> 'verify',
				);
				echo json_encode([
					'success'	=> 'success',
					'status'    => True,
					'data'      => $output,
					'csrfHash'  => $this->security->get_csrf_hash()
				]);
			}
		}
	}

	public function setpassword() {
		$code	= $this->input->post(explode('.',$_SERVER['HTTP_HOST'])[0]);
		$user	= $this->ion_auth->forgotten_password_check($code);
		// var_dump($user); die;
		if ($user) {
			$tokenkey	= hash('sha1',base64_encode($user->email.':'.$this->input->post('password')));
			$user_group = $this->ion_auth_model->get_users_groups($user->id)->row();
			$change		= $this->ion_auth_model->reset_password($user->email,$this->input->post('password'));
			if ($change) {
				$data_token = array(
					'user_id'		=> $user->id,
					'key'			=> $tokenkey,
					'level'			=> $user_group->id,
					'ip_addresses'	=> $this->input->ip_address(),
					'date_created'	=> time(),
				);
				if ($this->Master->get_row('token',['user_id'=>$user->id])->row()) {
					$this->Master->update_data('token',['user_id'=>$user->id],$data_token);
				} else {
					$this->Master->save_data('token' , $data_token);
				}
				$this->ion_auth_model->clear_forgotten_password_code($user->id);
				$output = array(
					'title'		=> 'Set Password Success',
					'info'		=> 'success',
					'message'   => $this->ion_auth->messages(),
					'location'	=> 'login',
				);
				echo json_encode([
					'success'	=> 'success',
					'status'    => True,
					'data'      => $output,
					'csrfHash'  => $this->security->get_csrf_hash()
				]);
			} else {
				echo json_encode([
					'success'	=> 'Error',
					'status'    => False,
					'title'		=> 'Set Password Gagal',
					'info'		=> 'error',
					'message'   => $this->ion_auth->errors(),
					'location'	=> 'setPassword',
					'csrfHash'  => $this->security->get_csrf_hash()
				]);
			}
		} else {
			echo json_encode([
				'success'	=> 'Error',
				'status'    => False,
				'title'		=> 'Set Password Gagal',
				'info'		=> 'error',
				'message'   => $this->ion_auth->errors(),
				'location'	=> 'setPassword',
				'csrfHash'  => $this->security->get_csrf_hash()
			]);
		}
	}

	public function verify() {
		$code = "";
		$data = $this->input->post('digit-input');
		for($i=0;$i<count($data);$i++) {
			$code .= $data[$i];
		}
		$valid_code	=	$this->Master->get_row('users_login',['SUBSTR(mail_code,-4)'=>$code])->row();
		if ($valid_code) {
			if($valid_code->activation_selector) {
				// var_dump($valid_code->activation_selector);die;
				$this->ion_auth->activate($valid_code->id,$valid_code->mail_code);
			}
			$user		= $this->Master->get_row('users_details',['user_id'=>$valid_code->id])->row();
			$setpass	= $this->ion_auth_model->forgotten_password($user->email);
			/* if ($this->ion_auth->activate($valid_code->id,$valid_code->mail_code)) {
				// run the forgotten password method to email an activation code to the user
				$user		= $this->Master->get_row('users_details',['user_id'=>$valid_code->id])->row();
				$setpass	= $this->ion_auth_model->forgotten_password($user->email);
			} else {
				$setpass	= $valid_code->mail_code;
			} */
			$output = array(
				'title'		=> 'Verify Success',
				'info'		=> 'success',
				'message'   => $this->ion_auth->messages(),
				'location'	=> 'setPassword',
				'token'		=> $setpass,
			);
			echo json_encode([
				'success'	=> 'success',
				'status'    => True,
				'data'      => $output,
				'csrfHash'  => $this->security->get_csrf_hash()
			]);
		} else {
			echo json_encode([
				'success'	=> 'Error',
				'status'    => False,
				'title'		=> 'Verify Gagal',
				'info'		=> 'error',
				'message'   => 'Kode Salah Cek Inbox/Spam Email',
				'location'	=> 'verify',
				'csrfHash'  => $this->security->get_csrf_hash()
			]);
		}
	}

	public function register() {
			$email			= strtolower($this->input->post('username'));
			$checkidentity	= $this->ion_auth->email_check($email);
			if (!$checkidentity) {
				// save new user
				// Users password default
				$hash				= $this->ion_auth_model->hash_password('User@12345');
				$tokenkey			= hash('sha1',base64_encode($email.':'.'User@12345'));
				$identity_column	= $this->config->item('identity', 'ion_auth');
				$identity			= ($identity_column === 'email') ? $email : strtolower($this->input->post('username'));
				$ip_address			= $this->input->ip_address();
				$additional_data	= ['key'=>$tokenkey,'ip_addresses'=>$ip_address,'password'=>$hash,'phone'=>$this->input->post('phone'),'nama_lengkap'=>ucwords(strtolower($this->input->post('namaLengkap')))];
				$additional_group	= ['id'=>$this->input->post('sebagai')];
				if ($this->ion_auth->register($identity, $email, $additional_data, $additional_group)) {
					$output = array(
						'title'		=> 'Register Success',
						'info'		=> 'success',
						'message'   => $this->ion_auth->messages(),
						'location'	=> 'verify',
					);
					echo json_encode([
						'success'	=> 'success',
						'status'    => True,
						'data'      => $output,
						'csrfHash'  => $this->security->get_csrf_hash()
					]);
				}
			} else {
				echo json_encode([
					'success'	=> 'Error',
					'status'    => False,
					'title'		=> 'Register Gagal',
					'info'		=> 'error',
					'message'   => $this->ion_auth->errors(),
					'location'	=> 'register',
					'csrfHash'  => $this->security->get_csrf_hash()
				]);
			}
    }
}
