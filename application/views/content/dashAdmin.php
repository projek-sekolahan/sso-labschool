    	<?php
		var_dump($user); return false;
		?>
		<div class="row">
            <div class="col-xl-12">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Selamat Datang Kembali <?=$result->name?></h5>
                                    <p>Aplikasi Administrasi Sekolah</p>
                                </div>
                            </div>
                            <!-- <div class="col-5 align-self-end">
                                <img src="<?=base_url()?>assets/images/calendar.png" alt="" class="img-fluid">
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="<?=base_url()?>assets/images/user_icon.png" alt="" class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate"><?=ucwords($result->nama_lengkap)?></h5>
                                <p class="text-muted mb-0 text-truncate"><?=ucwords($result->jabatan)?></p>
                            </div>

                            <div class="position-relative">
                                <div class="position-absolute bottom-0 end-0">
                                    <button class="btn btn-primary waves-effect waves-light btn-sm btn-action" data-view="detail" data-action="/api/client/user/profile" type="button">
                                        View Profile
                                        <i class="mdi mdi-account-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap">
                            <h4 class="card-title mb-4">Data Agenda</h4>
                            <div class="ms-auto">
                                <h5 class="text-muted">Total 252</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="pie_chart" data-key="dashboard" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                        <div class="position-relative">
                            <div class="position-absolute bottom-0 end-0">
                                <button class="btn btn-primary waves-effect waves-light btn-sm btn-action" data-view="detail" data-action="/api/client/vehicle/profile" type="button">View More<i class="mdi mdi-arrow-right ms-1"></i></button>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <!-- <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap">
                            <h4 class="card-title mb-4">Data Agenda Kegiatan</h4>
                        </div>
                        <div id="bar_chart" data-key="dashboard_admin" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div> -->
        </div>
        <!-- end row -->
