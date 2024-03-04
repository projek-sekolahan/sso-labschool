<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

<div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li>
                <a href="#" data-action="overview" class="waves-effect">
                    <i class="bx bx-home-circle"></i>
                    <span key="t-dashboards">Dashboards</span>
                </a>
            </li>

<!-- <li class="menu-title" key="t-setting">Menu Pengaturan Kalender</li>

<li>
    <a href="#" data-action="layarkalender" class="waves-effect">
        <i class="bx bx-calendar-alt"></i>
        <span key="t-kalender">Layar Pembuka</span>
    </a>
</li>
<li>
    <a href="#" data-action="bulankalender" class="waves-effect">
        <i class="bx bx-calendar"></i>
        <span key="t-kalender">Bulan Kalender</span>
    </a>
</li>
<li>
    <a href="#" data-action="settingkalender" class="waves-effect">
        <i class="bx bx-calendar-event"></i>
        <span key="t-kalender">Kegiatan Kalender</span>
    </a>
</li> -->

<?php
if ($this->ion_auth->is_admin()) {
?>
            <li class="menu-title" key="t-master">Menu Master</li>

            <li>
                <a href="#" data-action="masterpengguna" class="waves-effect">
                    <i class="bx bx-user"></i>
                    <span key="t-pengguna">Users</span>
                </a>
            </li>
			<li>
                <a href="#" data-action="masterpages" class="waves-effect">
                    <i class="bx bx-window"></i>
                    <span key="t-pages">Pages</span>
                </a>
            </li>
			<li>
                <a href="#" data-action="masterakses" class="waves-effect">
                    <i class="bx bx-key"></i>
                    <span key="t-akses">Roles</span>
                </a>
            </li>
<?php
}
?>
        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->
