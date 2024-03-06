<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends CI_Controller {

	public $data = [];
	private $_client;
	private $_CookieJar;
	public function __construct() {
		parent::__construct();
		$this->load->library(['ion_auth']);
        $this->load->helper('cookie');
		$this->lang->load('auth');
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->getURL = $_SERVER['REQUEST_URI'];
		$this->_CookieJar   =   new \GuzzleHttp\Cookie\CookieJar();
		$this->_client      =   new \GuzzleHttp\Client([
			'base_uri'          => base_url()."view/",
			'cookie'            => true,
			'cookies'           => $this->_CookieJar,
			'verify'            => false,
			'allow_redirects'   => true,
		]);
	}

	public function tokenCsrf() {
		echo json_encode(
            [
            'status'    => true,
			'csrfHash'  => $this->security->get_csrf_hash(),
			'info'      => 'csrf cookie created',
            ]
        );
	}

	public function tokenGetCsrf() {
		try {
			$response = $this->_client->get('tokenCsrf');
		} catch (\GuzzleHttp\Exception\RequestException $e) {
			if ($e->hasResponse()) {
				$response = $e->getResponse();
			}
		}
		$result			= json_decode($response->getBody()->getContents(),true);
		$cookieJar      = $this->_client->getConfig('cookies');
		$cookieArray    = $cookieJar->getCookieByName('ci_sso_csrf_cookie')->getValue();
		var_dump($result->csrfHash);
		/* echo json_encode(
            [
            'status'    => true,
			'csrfHash'  => $this->security->get_csrf_hash(),
			'cookiesJar'=> $cookieArray,
			'info'      => 'csrf cookie hash created '.$this->input->cookie('ci_sso_csrf_cookie'),
            ]
        ); */
	}

	public function index() {
        // $this->session->sess_destroy();
        if (!$this->ion_auth->logged_in()) {
            $pages  = 'login';
        } else {
            $pages  = 'dashboard';
        }
        $this->data['content'] = [
            'csrfHash'	=>	$this->security->get_csrf_hash(),
            'pages'     =>  $pages,
        ];
        $this->load->view('layout/'.'frame',$this->data);
    }

    public function content($pages) {
        if($this->method != 'POST' || $pages=='undefined') { 
            redirect('dashboard/404','location', 404);
        } else {
            if (!$this->ion_auth->logged_in()) {
                $view   = 'auth/'.$pages;
            } else {
                $pages  = 'dashboard';
                $view   = 'layout/'.$pages;
            }
            $this->data['content'] = [
                'csrfHash'	=>	$this->security->get_csrf_hash(),
                'pages'     =>  $pages,
            ];
            $this->load->view($view,$this->data);
        }
    }

    public function subcontent($pages) {
        if ($pages=='header') {
            $this->load->view('layout/header',$this->data);
        }
        if ($pages=='leftSidebar') {
            $this->load->view('layout/left-sidebar',$this->data);
        }
        if ($pages=='content') {
            $this->load->view($pages.'/overview',$this->data);
        }
        if ($pages=='rightSidebar') {
            $this->load->view('layout/right-sidebar',$this->data);
        }
        if ($pages=='footer') {
            $this->load->view('layout/footer',$this->data);
        }
    }

    public function menu($pages) {
        $this->load->view('content/'.$pages,$this->data);
    }

    public function modal($pages) {
        $this->load->view('modal/'.$pages,$this->data);
    }

}
