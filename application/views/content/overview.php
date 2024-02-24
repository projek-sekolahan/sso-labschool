<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <?php
		$sqluser = "select a.name,c.nama_lengkap,c.jabatan,c.nomor_induk from groups a, users_groups b , users_details c where b.user_id=c.user_id and a.id=b.group_id and b.user_id=".$this->session->userdata('user_id');
		$result =   $this->Master->get_custom_query($sqluser)->row();
		var_dump($result); return false;
            if ($this->ion_auth->is_admin()) {
                $this->load->view('content/dashAdmin',$result);
            }
            if ($this->ion_auth->is_user()) {
                $this->load->view('content/dashUser',$this->data['user'] = $result);
            }
        ?>
    </div>
</div>
