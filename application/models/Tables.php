<?php
class Tables extends CI_Model {
	public $data = [];
	
	function detailTables($select,$tabID,$limit,$like,$order,$join,$where,$where2,$group_by,$key) {
 		$columns = array();
		if ($tabID=='pengguna') {
			$access = '/api/client/user/profile_pengguna';
			$table	= 'users_details a';
		}
		if ($tabID=='pages') {
			$access = '/api/client/pages/menu_akses';
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
			$response['data'] = [];
		    foreach ($query->result() as $val) {
		        if ($query_total->num_rows()>0) {
					// data
					if ($tabID=='pengguna') {
						$btn	=	$this->buttonTables($val->email,$access,null);
					}
					if ($tabID=='pages') {
						$btn	=	$this->buttonTables($val->id,$access,null);
					}
					// Dapatkan array dari objek
					$valArray = (array) $val;
					// Buat array baru untuk menyimpan data yang sudah dimodifikasi
    				$modifiedArray = [];
					// Iterasi melalui setiap elemen array
					foreach ($valArray as $key => $value) {
						// Ubah kunci menjadi capitalize
						$modifiedKey = ucwords(str_replace('_',' ',$key)?? '---');
						// Ubah nilai menjadi capitalize
						$modifiedValue = ucwords($value?? '---');
						// Cek apakah $key mengandung kata "id" atau "_id"
						if (strpos($modifiedKey, 'Id') !== false) {
							// Jika kunci mengandung "Id", lanjut ke iterasi berikutnya
							continue;
						}
						// Ubah nilai untuk key 'tipe_site'
						if ($modifiedKey == 'Tipe Site') {
							// Jika nilai adalah '1', ubah menjadi 'dashboard', jika tidak biarkan nilai yang sama
							$modifiedValue = ($modifiedValue == '1') ? 'Dashboard' : $modifiedValue;
						}
						// Tambahkan ke array baru
						$modifiedArray[$modifiedKey] = $modifiedValue;
					}
					// Menambahkan kunci dan nilai baru di awal array
    				$modifiedArray = array_merge(['No' => $no++], $modifiedArray);
					// Menambahkan kunci dan nilai baru di akhir array
					$modifiedArray['Action'] = $btn;
					$response['data'][] = $modifiedArray;
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
		$response['csrfHash']           = $this->security->get_csrf_hash();
		$response['message']            = 'Success Created Data';
	    return $response;
	}

	function buttonTables($paramID,$action,$status) {
		$btndet = '
			<a type="button" tabindex="0" class="dropdown-item text-info btn-action" data-view="detail" data-action="'.$action.'" data-param="'.$paramID.'">
				<i class="align-middle mdi mdi-account-details font-size-18"></i> <span>Detail</span>
			</a>';
			$btn1	= $btndet;
			$btn2 = '';
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
