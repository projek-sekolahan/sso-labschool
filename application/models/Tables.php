<?php
class Tables extends CI_Model {
	public $data = [];
	
	function detailTables($select,$tabID,$limit,$like,$order,$join,$where,$where2,$group_by,$key) {
 		$columns = array();
		if ($tabID=='pengguna') {
			$access = 'pengguna';
			$table	= 'users_details a';
		}
		if ($tabID=='pages') {
			$access = 'pages';
			$table	= 'pages a';
		}
		/* if ($tabID=='splash_screen') {
			$access = 'splash_screen';
			$table	= 'splash_screen a';
		}
		if ($tabID=='calendars_month') {
			$access = 'calendars_month';
			$table	= 'calendars_month a';
		} */
		$query_total  = $this->Master->select($select,$table,$limit,$like,$order,$join,$where,$where2,$group_by);
		$query_filter = $this->Master->select($select,$table,$limit,$like,$order,$join,$where,$where2,$group_by);
		$query        = $this->Master->select($select,$table,$limit,$like,$order,$join,$where,$where2,$group_by);
		if ($query<>false) {
			$no		= $limit['start']+1;
		    foreach ($query->result() as $val) {
		        if ($query_total->num_rows()>0) {
					// data
					if ($access=='pengguna') {
						$btn	=	$this->buttonTables($val->email,$access,null);
        			    /* $response['data'][] = array(
                            '#'             =>  $no++,
							'Nomor Induk'	=>  ucwords($val->nomor_induk ?? '---'),
							'Nama'          =>  ucwords($val->nama_lengkap ?? '---'),
							'Bidang'		=>  ucwords($val->bagian_divisi ?? '---'),
							'Action'		=>	$btn
        				); */
					}
					// Dapatkan array dari objek
					$valArray = (array) $val;
					// Buat array baru untuk menyimpan data yang sudah dimodifikasi
					$response['data'][]= array();
					// Iterasi melalui setiap elemen array
					foreach ($valArray as $key => $value) {
						// Ubah kunci menjadi capitalize
						$modifiedKey = ucwords(str_replace('_',' ',$key)?? '---');

						// Ubah nilai menjadi capitalize
						$modifiedValue = ucwords($value?? '---');

						// Tambahkan ke array baru
						$response['data'][$modifiedKey] = $modifiedValue;
					}

					// Menambahkan kunci dan nilai baru
					$response['data']['Action'] = $btn;
					/* if ($access=='calendars_month') {
						$btn	=	$this->buttonTables($val->idtab,$access,null);
        			    $response['data'][] = array(
                            '#'				=>  $no++,
							'Foto'			=>  '<img src="'.$val->img.'" alt="" class="rounded float-start" width="50%">',
							'Bulan'			=>	$val->month_name,
							'Judul Cerita'	=>	ucwords($val->article),
							'Download QR'	=>  '<a href="'.$val->link_qr.'" class="link-info" download>Download link</a>',
							'Action'		=>	$btn
        				);
					}
					if ($access=='splash_screen') {
						$btn	=	$this->buttonTables($val->idtab,$access,null);
						if($val->is_active==1) {
							$ket = 'Activated';
							$txt = 'text-success';
						} else {
							$ket = 'Not Activated';
							$txt = 'text-danger';
						}
        			    $response['data'][] = array(
                            '#'				=>  $no++,
							'Foto'			=>  '<img src="'.$val->img.'" alt="" class="rounded" width="30%">',
							'Aktif'			=>	'<h5 class="'.$txt.'">'.$ket.'</h5>',
							'Action'		=>	$btn
        				);
					} */
					if ($response['data']!="" || $response['data']!=null) {
					// coloumn
						foreach($response['data'][0] as $column=>$relativeValue) {
							$columns[] = array(
								"name"=>$column,
								"data"=>$column
							);
						}
						$response['columns'] = array_unique($columns, SORT_REGULAR);
					}
				}
				else {
					$response['data']		= '';
					$response['columns']	= '';
				}
		    }
		}
		else {
			$response['data']		= '';
			$response['columns']	= '';
		}
		$response['recordsTotal']       = 0;
		if ($query_total<>false) {
			$response['recordsTotal']   = $query_total->num_rows();
		}
		$response['recordsFiltered']    = 0;
		if ($query_filter<>false) {
			$response['recordsFiltered']= $query_filter->num_rows();
		}
		// $response['check_query']		= $this->db->last_query();
		$response['csrfHash']           = $this->security->get_csrf_hash();
		$response['message']            = 'Success Created Data';
	    return $response;
	}

	function buttonTables($paramID,$action,$status) {
		if ($action=='pengguna') {
			$btndet = '
			<a type="button" tabindex="0" class="dropdown-item text-info btn-action" data-view="detail" data-action="/api/client/user/profile_'.$action.'" data-param="'.$paramID.'">
				<i class="align-middle mdi mdi-account-details font-size-18"></i> <span>Detail</span>
			</a>';
			$btn1	= $btndet;
			$btn2 = '';
		}
		if ($action=='splash_screen') {
			$btndet = '
			<a type="button" tabindex="0" class="dropdown-item text-warning btn-action" data-view="detail" data-action="/api/client/calendar/layar_kalender" data-ket="edit" data-param="'.$paramID.'">
				<i class="align-middle mdi mdi-pencil-box font-size-18"></i> <span>Edit</span>
			</a>';
			$btn1	= $btndet;
			$btn2 = '
			<a type="button" tabindex="0" class="dropdown-item text-danger btn-action" data-view="delete" data-action="/api/client/calendar/layar_kalender" data-ket="delete" data-param="'.$paramID.'">
				<i class="align-middle mdi mdi-delete-forever font-size-18"></i> <span>Delete</span>
			</a>';
		}
		if ($action=='calendars_month') {
			$btndet = '
			<a type="button" tabindex="0" class="dropdown-item text-warning btn-action" data-view="detail" data-action="/api/client/calendar/bulan_kalender" data-ket="edit" data-param="'.$paramID.'">
				<i class="align-middle mdi mdi-pencil-box font-size-18"></i> <span>Edit</span>
			</a>';
			$btn1	= $btndet;
			$btn2 = '
			<a type="button" tabindex="0" class="dropdown-item text-danger btn-action" data-view="delete" data-action="/api/client/calendar/bulan_kalender" data-ket="delete" data-param="'.$paramID.'">
				<i class="align-middle mdi mdi-delete-forever font-size-18"></i> <span>Delete</span>
			</a>';
		}
		$button = 
		'<div class="btn-group" role="group">
			<button type="button" class="btn btn-primary text-center">Pilih</button>
			<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
				<i class="mdi mdi-chevron-down"></i>
			</button>
			<div class="dropdown-menu">
				'.$btn1.$btn2.'
			</div>
		</div>';
        return $button;
	}

    function stringToSecret($string) {
        $length = strlen($string);
        $visibleCount = (int) round($length / 4);
        $hiddenCount = $length - ($visibleCount * 2);
        return substr($string, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
    }	
}
?>
