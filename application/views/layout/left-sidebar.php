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

			<li>
                                <a href="#" class="has-arrow waves-effect">
                                    <i class="bx bx-store"></i>
                                    <span key="t-ecommerce">Ecommerce</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="ecommerce-products.html" key="t-products">Products</a></li>
                                    <li><a href="ecommerce-product-detail.html" key="t-product-detail">Product Detail</a></li>
                                    <li><a href="ecommerce-orders.html" key="t-orders">Orders</a></li>
                                    <li><a href="ecommerce-customers.html" key="t-customers">Customers</a></li>
                                    <li><a href="ecommerce-cart.html" key="t-cart">Cart</a></li>
                                    <li><a href="ecommerce-checkout.html" key="t-checkout">Checkout</a></li>
                                    <li><a href="ecommerce-shops.html" key="t-shops">Shops</a></li>
                                    <li><a href="ecommerce-add-product.html" key="t-add-product">Add Product</a></li>
                                </ul>
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
<li>
    <a href="#" class="has-arrow waves-effect">
        <i class="bx bx-database"></i>
        <span key="t-master">Menu Master</span>
    </a>
	<ul class="sub-menu" aria-expanded="false">
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
	</ul>
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
