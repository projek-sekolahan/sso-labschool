<?php
	class ClientAPI extends CI_model {

        private $_client;
        private $_CookieJar;
        public function __construct() {
            parent::__construct();
            $this->_CookieJar   =   new \GuzzleHttp\Cookie\CookieJar();
            $this->_client      =   new \GuzzleHttp\Client([
                'base_uri'          => base_url()."api/server/",
                'cookie'            => true,
                'cookies'           => $this->_CookieJar,
                'verify'            => false,
                'allow_redirects'   => true,
            ]);
        }

        function crToken($url,$authKey) {
            try {
                $response = $this->_client->get($url,
                    [
                        'headers'       => [
                            'Authorization'     => 'Basic '.$authKey,
                            'Cache-Control'     => 'no-cache',
                        ],
                        'query'         =>  [explode('.',$_SERVER['HTTP_HOST'])[0]=>hash('sha1',$authKey)]
                    ],
                );
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                if ($e->hasResponse()) {
                    $response = $e->getResponse();
                }
            }
            $cookieJar      = $this->_client->getConfig('cookies');
            $cookieArray    = $cookieJar->getCookieByName('ci_sso_csrf_cookie')->getValue();
            return $cookieArray;
        }

        function geToken($url,$authKey,$csrf){
            $data = explode(":",base64_decode($authKey));
            $datalogin = array(
                'email'     => $data[0],
                'password'  => $data[1],
                explode('.',$_SERVER['HTTP_HOST'])[0] => hash('sha1',$authKey),
                'csrf_token'=> $csrf,
            );
            try {
                $response = $this->_client->post($url,
                    [
                        'headers'       => [
                            'Authorization'     => 'Basic '.$authKey,
                            'Cache-Control'     => 'no-cache',
                        ],
                        'form_params'   =>  $datalogin,
                    ],
                );
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                if ($e->hasResponse()) {
                    $response = $e->getResponse();
                }
            }
            return $response;
    	}

        function postContent($url,$authKey,$param) {
            try {
                $response = $this->_client->post($url,
                    [
                        'headers'       => [
                            'Authorization'     => 'Basic '.$authKey,
                            'Cache-Control'     => 'no-cache',
                        ],
                        'form_params'   =>  $param,
                    ],
                );
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                if ($e->hasResponse()) {
                    $response = $e->getResponse();
                }
            }
            return $response;
    	}        
        
    }
?>
