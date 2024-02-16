        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <!-- <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5 text-muted">
                            <a href="index.html" class="d-block auth-logo">
                                <img src="<?=base_url()?>assets/images/logo-dark.png" alt="" height="20" class="auth-logo-dark mx-auto">
                                <img src="<?=base_url()?>assets/images/logo-light.png" alt="" height="20" class="auth-logo-light mx-auto">
                            </a>
                            <p class="mt-3">Responsive Bootstrap 5 Admin Dashboard</p>
                        </div>
                    </div>
                </div> -->
                <!-- end row -->
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body">

                                <div class="p-2">
                                    <div class="text-center">

                                        <div class="avatar-md mx-auto">
                                            <div class="avatar-title rounded-circle bg-light">
                                                <i class="bx bxs-envelope h1 mb-0 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="p-2 mt-4">

                                            <h4>Verify your email</h4>
                                            <p class="mb-5">Please enter the 4 digit code sent to<br /><span class="fw-semibold">your inbox/spam email</span></p>
                                            <form autocomplete="off" class="form-horizontal custom-validation needs-validation" id="form-verify" novalidate action="/input/verify" method="post" accept-charset="utf-8">
                                                <div class="row">
                                                    <?php
                                                        for($i=1;$i<=4;$i++) {
                                                    ?>
                                                        <div class="col-3">
                                                            <div class="mb-3">
                                                                <label for="digit<?=$i?>-input" class="visually-hidden">Digit1</label>
                                                                <input autocomplete="off" type="text" class="form-control form-control-lg text-center two-step" data-value="<?=$i?>" required maxLength="1" id="digit<?=$i?>-input" name="digit-input[]">
                                                            </div>
                                                        </div>
                                                    <?php 
                                                        }
                                                    ?>
                                                    <div class="mt-4">
                                                        <button class="btn btn-success w-md btn-simpan" type="button">Confirm</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>