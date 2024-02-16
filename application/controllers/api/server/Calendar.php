<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Calendar extends RestController {
	private $_master;
	private $_AuthToken;
    private $_TokenKey;
    private $_ApiKey;
    private $_AuthCheck;
    private $_RsToken;
    function __construct() {
        parent::__construct();
        $this->load->model(['Tables','UploadFile','QrConvert']);
        $this->load->library(['ion_auth','calendar']);
		$this->_master      = new Master();
		$this->_AuthToken   = new AuthToken();
        $this->_AuthCheck   = new AuthCheck();
        $this->_TokenKey    = (empty($this->input->post('token'))) ? null:$this->input->post('token');
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
            $rstoken	= $this->_master->get_row('token',['key'=>$this->_RsToken->apikey])->row();
            $rsgroup	= $this->_master->get_row('users_groups',['user_id'=>$rstoken->user_id])->row();
            if ($keterangan=='bulan_kalender_edit') {
                $rsarticle	= $this->_master->get_row('calendars_month',['idtab'=>$this->input->post('param')])->result();
                $http       = RestController::HTTP_CREATED;
                $output     = $rsarticle;
            }
            if ($keterangan=='bulan_kalender_delete') {
                $this->_master->true_delete('calendars_month',['idtab'=>$this->input->post('paramID')]);
                $output = array(
                    'title'     => 'Story Deleted',
                    'message'   => 'Hapus Story Month Berhasil',
                    'info'		=> 'success',
                    'location'	=> 'dashboard',
                );
                $http       = RestController::HTTP_CREATED;
                $output     = $output;
            }
            if ($keterangan=='search') {
                $sqlcal     = "SELECT * from calendars_article a where a.title LIKE '%".$this->input->post('param')."%' OR a.description LIKE '%".$this->input->post('param')."%' and a.user_entry=".$rstoken->user_id;
                $result     = $this->_master->get_custom_query($sqlcal)->result();
                $http       = RestController::HTTP_CREATED;
                $output     = array('recordTotal'=>$this->_master->get_custom_query($sqlcal)->num_rows(),'data'=>$this->_master->get_custom_query($sqlcal)->result());
            }
            if ($keterangan=='article') {
                $sqlcal     = "SELECT * from calendars_article a where SUBSTRING_INDEX(a.url, '=',-1)='".$this->input->post('param')."' and a.user_entry=".$rstoken->user_id;
                $result     = $this->_master->get_custom_query($sqlcal)->row();
                $http       = RestController::HTTP_CREATED;
                $output     = $result;
            }
            if ($keterangan=='splash') {
                $rsplash	= $this->_master->get_row('splash_screen',['user_entry'=>$rstoken->user_id,'is_active'=>1])->row();
                $http       = RestController::HTTP_CREATED;
                $output     = $rsplash;
            }
            if ($keterangan=='layar_kalender_edit') {
                $rscreen	= $this->_master->get_row('splash_screen',['idtab'=>$this->input->post('param')])->result();
                $http       = RestController::HTTP_CREATED;
                $output     = $rscreen;
            }
            if ($keterangan=='layar_kalender_delete') {
                $this->_master->true_delete('splash_screen',['idtab'=>$this->input->post('paramID')]);
                $output = array(
                    'title'     => 'Screen Deleted',
                    'message'   => 'Hapus Screen Month Berhasil',
                    'info'		=> 'success',
                    'location'	=> 'dashboard',
                );
                $http       = RestController::HTTP_CREATED;
                $output     = $output;
            }
            if ($keterangan=='createScreen') {
                setlocale (LC_ALL, 'id_ID');
                $jsonimg = json_decode($this->input->post('param')['img'],true);
                    if (count($jsonimg)!=0) {
                        for ($i=0; $i < count($jsonimg); $i++) {
                            $articleFoto = $this->UploadFile->photo('img','calendar',['articleid'=>'splash_screen_'.strftime("%B", time()),'img'=>$jsonimg[$i],'table'=>'calendars_article']);
                        }
                    }
                    $datascreen = array(
                        'img'           => base_url().$articleFoto,
                        'is_active'     => (isset($this->input->post('param')['aktif'])) ? '1':'0',
                        'user_entry'    => $rstoken->user_id,
                    );
                    $this->_master->save_data('splash_screen' , $datascreen);
                    $output = array(
                        'title'     => 'Screen Saved',
                        'message'   => 'Tambah Screen Calendar Berhasil',
                        'info'		=> 'success',
                        'location'	=> 'dashboard',
                    );
                    $http       = RestController::HTTP_CREATED;
                    $output     = $output;
            }
            if ($keterangan=='updateScreen') {
                $filefoto   = array();
                $jsonimg    = json_decode($this->input->post('param')['img'],true);
                if (count($jsonimg)!=0) {
                    for ($i=0; $i < count($jsonimg); $i++) {
                        $articleFoto = $this->UploadFile->photo('img','calendar',['articleid'=>'splash_screen_'.strftime("%B", time()),'img'=>$jsonimg[$i],'table'=>'calendars_article']);
                    }
                    $filefoto = array('img' => base_url().$articleFoto);
                }
                $datascreen = array(
                    'is_active'     => (isset($this->input->post('param')['aktif'])) ? '1':'0',
                    'user_entry'    => $rstoken->user_id,
                );
                $this->_master->update_data('splash_screen',['idtab'=>$this->input->post('param')['layar-id']],array_merge($datascreen,$filefoto));
                $output = array(
                    'title'     => 'Screen Saved',
                    'message'   => 'Rubah Screen Calendar Berhasil',
                    'info'		=> 'success',
                    'location'	=> 'dashboard',
                );
                $http       = RestController::HTTP_CREATED;
                $output     = $output;
            }
            if ($keterangan=='createMonth') {
                setlocale (LC_ALL, 'id_ID');
                $jsonimg = json_decode($this->input->post('param')['img'],true);
                    if (count($jsonimg)!=0) {
                        for ($i=0; $i < count($jsonimg); $i++) {
                            $articleFoto = $this->UploadFile->photo('img','calendar',['articleid'=>strftime("%B", time()),'img'=>$jsonimg[$i],'table'=>'calendars_article']);
                        }
                    }
                ($rstoken->user_id==1) ? $url='https://kemenag-calender.vercel.app/':$url='https://calender-ptpn.vercel.app/';
                $storyUrl   = $url.'?month='.strftime("%B", time()).'&year='.strftime("%Y", time());
                $dataQR     = array(
                    'data' => $storyUrl,
                    'title'=> strftime("%B", time()).'-'.strftime("%Y", time()),
                );
                $qrUrl      = $this->QrConvert->createQR($dataQR,'story');
                $datastory = array(
                    'month_name'    => strftime("%m-%Y", time()),
                    'article'       => $this->input->post('param')['article'],
                    'description'   => $this->input->post('param')['article-description'],
                    'img'           => base_url().$articleFoto,
                    'link_qr'       => base_url().$qrUrl,
                    'user_entry'    => $rstoken->user_id,
                );
                $rscek	= $this->_master->get_row('calendars_month',['month_name'=>strftime("%m-%Y", time()),'user_entry'=>$rstoken->user_id])->row();
                if ($rscek!=null) {
                    $output = array(
                        'title'     => 'Story Not Saved',
                        'message'   => 'Sudah Pernah Simpan Bulan '.ucwords(strftime("%B", time())),
                        'info'		=> 'error',
                        'location'	=> 'dashboard',
                    );
                } else {
                    $this->_master->save_data('calendars_month' , $datastory);
                    $output = array(
                        'title'     => 'Story Saved',
                        'message'   => 'Tambah Story Calendar Berhasil',
                        'info'		=> 'success',
                        'location'	=> 'dashboard',
                    );
                }
                $http       = RestController::HTTP_CREATED;
                $output     = $output;
            }
            if ($keterangan=='updateMonth') {
                $filefoto   = array();
                $jsonimg    = json_decode($this->input->post('param')['img'],true);
                if (count($jsonimg)!=0) {
                    for ($i=0; $i < count($jsonimg); $i++) {
                        $articleFoto = $this->UploadFile->photo('img','calendar',['articleid'=>strftime("%B", time()),'img'=>$jsonimg[$i],'table'=>'calendars_article']);
                    }
                    $filefoto = array('img' => base_url().$articleFoto);
                }
                $datastory = array(
                    'article'       => $this->input->post('param')['article'],
                    'description'   => $this->input->post('param')['article-description'],
                    'user_entry'    => $rstoken->user_id,
                );
                $this->_master->update_data('calendars_month',['idtab'=>$this->input->post('param')['article-id']],array_merge($datastory,$filefoto));
                $output = array(
                    'title'     => 'Story Saved',
                    'message'   => 'Rubah Story Calendar Berhasil',
                    'info'		=> 'success',
                    'location'	=> 'dashboard',
                );
                $http       = RestController::HTTP_CREATED;
                $output     = $output;
            }
            if ($keterangan=='create') {
                $end    = date_create(explode('-',$this->input->post('param')['event-date'])[0]);
                $edate  = date_format($end,"Y-m-d");
                $start  = date_create(explode('-',$this->input->post('param')['event-date'])[1]);
                $sdate  = date_format($start,"Y-m-d");
                $datacalendar = array(
                    'month_id'      => date_format($end,"m"),
                    'start_date'    => $sdate,
                    'end_date'      => $edate,
                    'title'         => $this->input->post('param')['event-title'],
                    'category'      => $this->input->post('param')['event-category'],
                    'from_user'     => $rstoken->user_id,
                );
                $this->_master->save_data('calendars_event' , $datacalendar);
                $calendar_id = $this->db->insert_id('calendars_event' . '_id_seq');
                if (isset($this->input->post('param')['artikel'])) {
                    $jsonimg = json_decode($this->input->post('param')['img'],true);
                    for ($i=0; $i < count($jsonimg); $i++) {
                        $articleFoto = $this->UploadFile->photo('img','calendar',['articleid'=>$this->input->post('param')['article-title'],'img'=>$jsonimg[$i],'table'=>'calendars_article']);
                    }
                    ($rstoken->user_id==1) ? $url='https://kemenag-calender.vercel.app/':$url='https://calender-ptpn.vercel.app/';
                    $articleUrl = $url.'?article='.hash('sha1',base64_encode($calendar_id.':'.strtotime(date('d-m-Y H:m:s'))));
                    $dataQR     = array(
                        'data' => $articleUrl,
                        'title'=> hash('sha1',base64_encode($calendar_id.':'.strtotime(date('d-m-Y H:m:s')))),
                    );
                    $articleQR  = $this->QrConvert->createQR($dataQR,'article');
                    $articledata    = array(
                        'calendar_id'   => $calendar_id,
                        'url'           => $articleUrl,
                        'link_qr'       => base_url().$articleQR,
                        'img'           => base_url().$articleFoto,
                        'title'         => $this->input->post('param')['article-title'],
                        'description'   => $this->input->post('param')['article-description'],
                        'user_entry'    => $rstoken->user_id,
                    );
                    $this->_master->save_data('calendars_article' , $articledata);
                }
                $output = array(
                    'title'     => 'Event Saved',
                    'message'   => 'Tambah Event Calendar Berhasil',
                    'info'		=> 'success',
                    'location'	=> 'dashboard',
                );
                $http       = RestController::HTTP_CREATED;
                $output     = $output;
            }
            if ($keterangan=='read') {
                if (explode('-',$this->input->post('param'))[0]==10 || explode('-',$this->input->post('param'))[0]==11 || explode('-',$this->input->post('param'))[0]==12) {
                    $monthID    = explode('-',$this->input->post('param'))[0];
                } else {
                    $monthID    = substr(explode('-',$this->input->post('param'))[0],1);
                }
                $story      = $this->_master->get_row('calendars_month',['month_name'=>$this->input->post('param'),'user_entry'=>$rstoken->user_id])->row();
                $sqlcal     = "SELECT * from calendars_event a where a.month_id='".$monthID."' and (a.from_user=1 or a.from_user='".$rstoken->user_id."')";
                $result     = $this->_master->get_custom_query($sqlcal)->result();
                if (empty($result)) {
                    $data       = array();
                } else {
                    foreach($result as $val) {
                        $rsarticle	= $this->_master->get_row('calendars_article',['calendar_id'=>$val->idtab])->row();
                        $data[]   = array(
                            'id'    => $val->idtab,
                            'title' => $val->title,
                            'start' => date_format(date_create($val->start_date),"Y-m-d"),
                            'end'   => date_format(date_create($val->end_date),"Y-m-d"),
                            'article-title'   => (isset($rsarticle->title))?$rsarticle->title:'',
                            'article-description' => (isset($rsarticle->description))?$rsarticle->description:'',
                            'url'   => (isset($rsarticle->url))?$rsarticle->url:'',
                            'category'  => $val->category,
                            'className' => explode('/',$val->category)[0],
                        );
                    }
                }
                $hasil      = array('story'=>$story,'data'=>$data);
                $http       = RestController::HTTP_CREATED;
                $output     = $hasil;
            }
            if ($keterangan=='update') {
                $end    = date_create(explode('-',$this->input->post('param')['event-date'])[0]);
                $edate  = date_format($end,"Y-m-d");
                $start  = date_create(explode('-',$this->input->post('param')['event-date'])[1]);
                $sdate  = date_format($start,"Y-m-d");
                $datacalendar = array(
                    'start_date'    => $sdate,
                    'end_date'      => $edate,
                    'title'         => $this->input->post('param')['event-title'],
                    'category'      => $this->input->post('param')['event-category'],
                    'from_user'     => $rstoken->user_id,
                );
                $this->_master->update_data('calendars_event',['idtab'=>$this->input->post('param')['event-id']],$datacalendar);
                if (isset($this->input->post('param')['artikel'])) {
                    $filefoto = array();
                    $jsonimg = json_decode($this->input->post('param')['img'],true);
                    if (count($jsonimg)!=0) {
                        for ($i=0; $i < count($jsonimg); $i++) {
                            $articleFoto = $this->UploadFile->photo('img','calendar',['articleid'=>$this->input->post('param')['article-title'],'img'=>$jsonimg[$i],'table'=>'calendars_article']);
                        }
                        $filefoto = array('img' => base_url().$articleFoto);
                    }
                    ($rstoken->user_id==1) ? $url='https://kemenag-calender.vercel.app/':$url='https://calender-ptpn.vercel.app/';
                    $articleUrl = $url.'?article='.hash('sha1',base64_encode($this->input->post('param')['event-id'].':'.strtotime(date('d-m-Y H:m:s'))));
                    $dataQR     = array(
                        'data' => $articleUrl,
                        'title'=> hash('sha1',base64_encode($this->input->post('param')['event-id'].':'.strtotime(date('d-m-Y H:m:s')))),
                    );
                    $articleQR  = $this->QrConvert->createQR($dataQR,'article');
                    $articledata    = array(
                        'url'           => $articleUrl,
                        'link_qr'       => base_url().$articleQR,
                        'title'         => $this->input->post('param')['article-title'],
                        'description'   => $this->input->post('param')['article-description'],
                        'user_entry'    => $rstoken->user_id,
                    );
                    $this->_master->update_data('calendars_article',['calendar_id'=>$this->input->post('param')['event-id']],array_merge($articledata,$filefoto));
                }
                $output = array(
                    'title'     => 'Event Updated',
                    'message'   => 'Rubah Event Calendar Berhasil',
                    'info'		=> 'success',
                    'location'	=> 'dashboard',
                );
                $http       = RestController::HTTP_CREATED;
                $output     = $output;
            }
            if ($keterangan=='delete') {
                $this->_master->true_delete('calendars_event',['idtab'=>$this->input->post('paramID')]);
                $this->_master->true_delete('calendars_article',['calendar_id'=>$this->input->post('paramID')]);
                $output = array(
                    'title'     => 'Event Deleted',
                    'message'   => 'Hapus Event Calendar Berhasil',
                    'info'		=> 'success',
                    'location'	=> 'dashboard',
                );
                $http       = RestController::HTTP_CREATED;
                $output     = $output;
            }
            if ($keterangan=='table') {
                    $key	= $this->input->post('key');
                    $table	= $this->input->post('table');
                    $select = "a.*";
                    $column = "a.idtab";
                    //WHERE
                    if ($rsgroup->group_id==1) {
                        $where	= null;
                    } else {
                        $where['data'][]=array(
                            'column'	=>'a.user_entry',
                            'param'		=> $rstoken->user_id,
                        );
                    }
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