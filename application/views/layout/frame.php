<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard" name="description" />
    <meta content="b46usf" name="author" />
    <meta name="keywords" content="dashboard, kalender, digital, sistem, aplikasi, administrasi">
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $content['csrfHash']; ?>">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.ico">
    <!-- Bootstrap Css -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"> -->
    <link href="<?=base_url()?>assets/css/bootstrap.min.css?v=<?=date('His');?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?=base_url()?>assets/css/icons.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?=base_url()?>assets/libs/jquery-ui-dist/jquery-ui.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/libs/admin-resources/rwd-table/rwd-table.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/libs/metismenu/metisMenu.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/css/app.min.css?v=<?=date('His');?>" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/css/main.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/libs/select2/css/select2.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/libs/dropzone/min/dropzone.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/libs/@fullcalendar/core/main.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/libs/@fullcalendar/daygrid/main.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/libs/@fullcalendar/bootstrap/main.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/libs/@fullcalendar/timegrid/main.min.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
	<!-- Custom Css-->
    <link href="<?=base_url()?>assets/css/custom.css?v=<?=date('His');?>" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark" data-pages="<?=$content['pages'];?>">
    <div class="content" id="content">
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner-chase">
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- JAVASCRIPT -->
    <script src="<?=base_url()?>assets/libs/jquery/jquery.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/bootstrap/js/bootstrap.bundle.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/metismenu/metismenu.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/simplebar/simplebar.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/node-waves/waves.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/moment/min/moment.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/jquery-ui-dist/jquery-ui.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/@fullcalendar/core/main.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/@fullcalendar/bootstrap/main.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/@fullcalendar/daygrid/main.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/@fullcalendar/timegrid/main.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/@fullcalendar/interaction/main.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/parsleyjs/parsley.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/validate/jquery.validate.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/admin-resources/rwd-table/rwd-table.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/select2/js/select2.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/dropzone/min/dropzone.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/jquery-steps/build/jquery.steps.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/apexcharts/apexcharts.min.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/libs/tinymce/tinymce.min.js?v=<?=date('His');?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>
	<!-- <script src="https://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtSAR45TFgZjOs4nBFFZnII-6mMHLfSYI"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <!-- App js -->
    <script src="<?=base_url()?>assets/js/app.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/ajax.js?v=<?=date('His');?>"></script>
    <!-- <script src="<?=base_url()?>assets/js/pages/dashboard.init.js"></script> -->
    <script src="<?=base_url()?>assets/js/pages/form-validation.init.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/pages/sweet-alerts.init.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/pages/table-responsive.init.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/pages/two-step-verification.init.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/pages/modal.init.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/pages/datatables.init.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/pages/apexcharts.init.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/pages/calendars-full.init.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/pages/form-editor.init.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/pages/dropzone.init.js?v=<?=date('His');?>"></script>
    <!-- <script src="<?=base_url()?>assets/js/pages/form-wizard.init.js?v=<?=date('His');?>"></script> -->
</body>

</html>