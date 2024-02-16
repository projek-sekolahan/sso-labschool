<div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-6">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Selamat Datang</h5>
                                        <p>Aplikasi Administrasi Kalender</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?=base_url()?>assets/images/calendar.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="#" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?=base_url()?>assets/images/logo-light.svg" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                                <a href="#" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?=base_url()?>assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal custom-validation needs-validation" id="form-register" novalidate action="/input/register" method="post" accept-charset="utf-8">

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="username" name="username" placeholder="Enter Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone" required>
                                    </div>
                                    <div class="mt-4 row justify-content-between">
                                        <div class="col-6 col-xl-8">
                                            <p>
                                                Sudah Punya Akun? 
                                                <a href="javascript:call_ajax_page('login')" class="fw-medium text-primary">Masuk</a> 
                                            </p>
                                        </div>
                                        <div class="col-6 col-xl-4">
                                            <a href="javascript:call_ajax_page('recover')" class="text-muted">
                                                <i class="mdi mdi-lock me-1"></i> Lupa Password?
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light btn-simpan" type="button">Daftar</button>
                                    </div>
                                        
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>