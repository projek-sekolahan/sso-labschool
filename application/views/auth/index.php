<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Batching Plant App</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/lib/bootstrap.min.css"/>
	<link rel="stylesheet" href="<?=base_url()?>assets/css/lib/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/lib/dataTables.bootstrap5.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/lib/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/lib/select2.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/lib/daterangepicker.css"/>
	<link href="<?=base_url()?>assets/css/sidebars.css?v=<?=date('His');?>" rel="stylesheet">
    <style>
        .main-content{
            flex: 1;
            overflow: auto;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .select2 {
            width:100%!important;
        }
    </style>
    
</head>

<body style="background-color: rgba(0, 0, 0, .1);">

    <main>
        <div class="flex-shrink-0 p-3 bg-light" style="width: 250px;">
            <a href="<?=base_url()?>" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                <img src="<?=base_url()?>assets/img/logo-ptbt.png" width="30" height="24" style="margin-right: 5px;">
                <span class="fs-5 fw-semibold">Batching Plant App</span>
            </a>
            <p class="h5">Dashboard <?=($this->ion_auth->is_admin()) ? 'Admin':'Operator'?></p>
            <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <!-- <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                        Home
                    </button> -->
                    <a class="btn align-items-center rounded collapsed" href="javascript:menu('welcome');" aria-expanded="false">
                        Home
                    </a>
                    <!-- <div class="collapse" id="home-collapse" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="#" class="link-dark rounded">Overview</a></li>
                            <li><a href="#" class="link-dark rounded">Reports</a></li>
                        </ul>
                    </div> -->
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                        Orders
                    </button>
                    <div class="collapse" id="orders-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="javascript:menu('pesananbaru');" class="link-dark rounded">New Batch</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                        Documents
                    </button>
                    <div class="collapse" id="dashboard-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="javascript:menu('suratjalan');" class="link-dark rounded">Delivery Tickets</a></li>
                        </ul>
                    </div>
                </li>
                <li class="border-top my-3"></li>
				<?php if ($this->ion_auth->is_admin()) { ?>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#master-collapse" aria-expanded="false">
                        Data Master
                    </button>
                    <div class="collapse" id="master-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="javascript:menu('konsumen');" class="link-dark rounded">Customer</a></li>
                            <li><a href="javascript:menu('company');" class="link-dark rounded">Company</a></li>
                            <!-- <li><a href="javascript:menu('konversi');" class="link-dark rounded">Convertion</a></li> -->
                             <li><a href="javascript:menu('material');" class="link-dark rounded">Item Material</a></li>
                            <li><a href="javascript:menu('quality');" class="link-dark rounded">Material Quality</a></li>
                            <li><a href="javascript:menu('vehicle');" class="link-dark rounded">Vehicles Driver</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                        Account
                    </button>
                    <div class="collapse" id="account-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="javascript:menu('setting');" class="link-dark rounded">Settings</a></li>
                            <li><a href="<?=base_url()?>/auth/logout" class="link-dark rounded">Logout</a></li>
                        </ul>
                    </div>
                </li>
				<?php } else { ?>
                <li class="mb-1">
                    <a class="btn align-items-center rounded" href="<?=base_url()?>/auth/logout">Logout</a>
                </li>
                <?php } ?>
            </ul>
        </div>

		<div class="main-content"></div>
    </main>

	<script src="<?=base_url()?>assets/js/lib/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/lib/popper.min.js"></script>
    <script src="<?=base_url()?>assets/js/lib/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/js/lib/jquery.validate.min.js"></script>
	<script src="<?=base_url()?>assets/js/lib/jquery.dataTables.min.js"></script>
	<script src="<?=base_url()?>assets/js/lib/dataTables.responsive.min.js"></script>
    
	<script src="<?=base_url()?>assets/js/lib/responsive.bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/js/lib/jquery-ui.min.js"></script>
	<script src='<?=base_url()?>assets/js/lib/plotly-2.12.1.min.js'></script>
    <script src="<?=base_url()?>assets/js/lib/numeral.min.js"></script>
    <script src="<?=base_url()?>assets/js/lib/select2.min.js"></script>
    <script src="<?=base_url()?>assets/js/lib/moment.min.js"></script>
    <script src="<?=base_url()?>assets/js/lib/daterangepicker.min.js"></script>
    <script src="<?=base_url()?>assets/js/lib/dataTables.editor.min.js"></script>
    <script src="<?=base_url()?>assets/js/sidebars.js?v=<?=date('His');?>"></script>
	<script src="<?=base_url()?>assets/js/layout.js?v=<?=date('His');?>"></script>
    <script src="<?=base_url()?>assets/js/tabData.js?v=<?=date('His');?>"></script>
</body>

</html>