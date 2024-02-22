<?php
$sqluser    = "select a.name,c.nama_lengkap,c.jabatan,c.nip,lower(c.email) email from groups a, users_groups b , users_details c where b.user_id=c.user_id and a.id=b.group_id and b.user_id=".$this->session->userdata('user_id');
$result     = $this->Master->get_custom_query($sqluser)->row();
$sqlvehicle = "SELECT a.* from vehicle a, users_vehicle b WHERE b.nopol=a.no_polisi AND b.nip=".$result->nip;
$rsvehicle  = $this->Master->get_custom_query($sqlvehicle)->row();
if ($rsvehicle==null) {
    $merk       = '';
    $tipe       = '';
    $kendraan   = '';
    $thkendaraan= '-';
    $nopol      = '-';
} else {
    $explode    = explode(' ',$rsvehicle->jenis_kendaraan);
    $merk       = $explode[0];
    $tipe       = $explode[1];
    $kendraan   = $rsvehicle->jenis_kendaraan;
    $thkendaraan= $rsvehicle->tahun;
    $nopol      = $rsvehicle->no_polisi;
}
?>
<div class="row">
    <div class="col-xl-5">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-12">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Selamat Datang Kembali <?=ucwords($result->name)?></h5>
                            <p>Aplikasi Administrasi Sekolah</p>
                        </div>
                    </div>
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
                            <button class="btn btn-primary waves-effect waves-light btn-sm btn-action" data-view="detail" data-action="/api/client/user/profile_pengguna" data-param="<?=$result->email?>" type="button">View Profile<i class="mdi mdi-account-arrow-right ms-1"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card overflow-hidden">
            <div class="card-body">
                <h4 class="card-title">Data Kendaraan</h4>
                <div class="row">
                                <div class="col-5">
                                    <p class="text-muted"><h4><?=ucwords(strtolower($kendraan))?></h4></p>
                                    <dl class="row">
                                        <dt class="col-sm-3">Tahun</dt>
                                        <dd class="col-sm-9"><?=ucwords($thkendaraan)?></dd>
                                        <dt class="col-sm-3">Nopol</dt>
                                        <dd class="col-sm-9"><?=ucwords($nopol)?></dd>
                                    </dl>
                                </div>
                                <div class="col-7">
                                    <div class="mb-2 mt-2">
                                        <img src="assets/images/product/radin.jpg" width="70%" class="img-thumbnail">
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <div class="position-absolute bottom-0 start-0">
                                        <?php
                                            if ($nopol!='-') {
                                        ?>
                                            <button class="btn btn-primary waves-effect waves-light btn-sm btn-action" data-view="detail" data-action="/api/client/vehicle/profile_kendaraan" data-param="<?=ucwords($nopol)?>" type="button">View More<i class="mdi mdi-car-arrow-right ms-1"></i></button>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">List Voucher BBM Kendaraan</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0" id="tab-bbm" data-key="dashboard-<?=$result->nip?>" data-action="/api/client/administrasi/table" style="width: 100%;"><thead class="table-light"><tr></tr></thead></table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="text-sm-start">
                                    <h4 class="card-title mb-4">Riwayat Perbaikan & Perawatan Kendaraan</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-sm-end">
                                        <?php
                                            if ($nopol!='-') {
                                        ?>
                                    <button class="btn btn-outline-success btn-rounded waves-effect waves-light mb-2 me-2 btn-sm btn-action" data-view="form" data-action="/api/client/service/ajukan_perbaikan_perawatan" type="button">
                                        <i class="mdi mdi-plus me-1"></i> Ajukan Perbaikan dan Perawatan
                                    </button>
                                        <?php
                                            }
                                        ?>
                                </div>
                            </div><!-- end col-->
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0" id="tab-service" data-key="dashboard-<?=$result->nip?>" data-action="/api/client/service/table" style="width: 100%;"><thead class="table-light"><tr></tr></thead></table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="text-sm-start">
                                    <h4 class="card-title mb-4">Riwayat Administrasi Kendaraan</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-sm-end">
                                        <?php
                                            if ($nopol!='-') {
                                        ?>
                                    <button class="btn btn-outline-success btn-rounded waves-effect waves-light mb-2 me-2 btn-sm btn-action" data-view="form" data-action="/api/client/administrasi/ajukan_administrasi" type="button">
                                        <i class="mdi mdi-plus me-1"></i> Ajukan Administrasi
                                    </button>
                                        <?php
                                            }
                                        ?>
                                </div>
                            </div><!-- end col-->
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0" id="tab-administrasi" data-key="dashboard-<?=$result->nip?>" data-action="/api/client/administrasi/table" style="width: 100%;"><thead class="table-light"><tr></tr></thead></table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
