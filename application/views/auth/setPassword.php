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
                                <form class="form-horizontal custom-validation needs-validation" id="form-setpassword" novalidate action="/input/setpassword" method="post" accept-charset="utf-8">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup has-validation">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" required>
                                            <button class="btn btn-light " type="button" id="password-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group auth-pass-inputgroup has-validation">
                                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Enter Confirm password" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light btn-simpan" type="button">Set Password</button>
                                    </div>
                                        
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>