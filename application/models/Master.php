<?php 
	class Master extends CI_model {
	    
        function check_session($tbl_user , $where){
    	    return $this->db->get_where($tbl_user , $where);
    	}
		
		function get_row($tables,$data){
    	    return $this->db->get_where($tables,$data);
    	}
		
		function get_data_pagination($tbl,$where,$limit, $start){
       		$query = $this->db->get($tbl, $limit, $start);
        	return $query;
    	}

    	function true_delete($tbl , $where){
    		$this->db->delete( $tbl ,  $where);
			$this->db->query("ALTER TABLE ".$tbl." AUTO_INCREMENT = 1");
    	}

		function get_data($tbl_name , $where = '' , $order_by = '' , $limit = ''  , $like = '' , $group_by = ''){
			/* Check are the data need to be ordered ? */
			if ($order_by != null) {
				$this->db->order_by($order_by);
			}
			/* Check are the data need to be limit ? */
			if ($limit != null) {
				$this->db->limit($limit);
			}
			if ($like != null) {
				$this->db->like($like);
			}
			if ($group_by != null) {
				$this->db->group_by($group_by);
			}
			$result 	=	$this->db->get_where($tbl_name , $where);
			return $result;
		}

		function get_custom_query($query){
			return $this->db->query($query);
		}

		function save_data($nama_table , $data){
			$this->db->insert($nama_table ,$data);
			$error = $this->db->error();
			$result = new stdclass();
			if ($this->db->affected_rows() > 0) {
				$result->status = true;
            	$result->output = $this->db->insert_id();
			} else {
				$result->status = false;
				$result->output = $error['code'].': '.$error['message'];
			}
			return $result;
		}

		function update_data($nama_table , $where = NULL ,  $data_update = '' ){
			if ($where) {
				$this->db->where($where);
			}
			$this->db->update($nama_table  , $data_update);
			if ($this->db->affected_rows() > 0) {
				return true ;
			} else {
				return false ;
			}
		}

		function get_table_order_limit_1($table , $order , $limit){
			$this->db->order_by($order);
			return $this->db->get($table , $limit);
		}

		/* Dynamis Data Tables */

		function select($select = NULL,$table = NULL,$limit = NULL,$like = NULL,$order = NULL,$join = NULL,$where = NULL,$where2 = NULL,$group_by = NULL) {
		        $this->db->distinct();
		        $this->db->select($select);
		        $this->db->from($table);
		        if ($join) {
		            for ($i=0; $i<sizeof($join['data']) ; $i++) { 
		                $this->db->join($join['data'][$i]['table'],$join['data'][$i]['join'],$join['data'][$i]['type']);
		            }
		        }
		        if ($where) {
		            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
		                $this->db->where($where['data'][$i]['column'],$where['data'][$i]['param']);
		            }
		        }
		        if ($where2) {
		            $this->db->where($where2);
		        }
		        if ($like) {
		            for ($i=0; $i<sizeof($like['data']) ; $i++) { 
		                $this->db->like('lower(CONCAT_WS(" ", '.$like['data'][$i]['column'].'))',strtolower($like['data'][$i]['param'] ? $like['data'][$i]['param'] : ''));
		            }
		        }
		        if ($limit) {
		            $this->db->limit($limit['finish'],$limit['start']);
		        }
		        if ($order) {
		            for ($i=0; $i<sizeof($order['data']) ; $i++) { 
		                $this->db->order_by($order['data'][$i]['column'], $order['data'][$i]['type']);
		            }
		        }
		        if ($group_by) {
		            $this->db->group_by($group_by);
		        }
		        $query  = $this->db->get();
		        if($query->num_rows() > 0) {
		            return $query;
		        } else {
		            return false;
		        }
		}
		
    }
 ?>
