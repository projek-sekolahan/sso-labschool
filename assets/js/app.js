/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Version: 3.3.0.
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Main Js File
*/

var url,path,urloc,action,dataParam,param,auth,key,configmsg,title,message,icon,detail,csrf_token,page,pageUrl,calendar,
interval,authkey,tokenkey,options,button,keyname = window.location.host.split(".")[0],lebarDevice = $(window).width();

Dropzone.autoDiscover = false;

function getCookie(o) {
	var t = null;
	if (document.cookie && "" !== document.cookie)
		for (var a = document.cookie.split(";"), n = 0; n < a.length; n++) {
			var i = jQuery.trim(a[n]);
			if (i.substring(0, o.length + 1) == o + "=") {
				t = decodeURIComponent(i.substring(o.length + 1));
				break;
			}
		}
	return t;
}

$(document).ready(function() {
    url = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split("/")[1];
    if ($("#sidebar-menu").length > 0 && $("#sidebar-menu .mm-active .active").length > 0) {
        var activeMenu = $("#sidebar-menu .mm-active .active").offset().top;
        if (activeMenu > 300) {
            activeMenu = activeMenu - 300;
            $(".vertical-menu .simplebar-content-wrapper").animate({ scrollTop: activeMenu }, "slow");
        }
    }
	if (localStorage.getItem('pages')==null) {
		path = $("body").data("pages");
	} 
    else if ((localStorage.getItem('expired')==null || new Date().getTime()>localStorage.getItem('expired')) && localStorage.getItem('token')==null && localStorage.getItem('pages')!='verify') {
        path = 'login';
    } 
    else {
		path = localStorage.getItem('pages');
	}
	call_ajax_page(path);
	interval    = setInterval(function () {
        if (path=='login' || path=='register' || path=='verify' || path=='recover' || path=='setPassword') { return false; } 
        else { checkSession('/api/client/auth/sessTime'); }
    }, 5000);
});

$(document).on("keyup", ".number-input", function (e) {
    e.preventDefault();
    $(this).attr("max").length;
    var a = $(this).val();
    $(this).val(numeral(a).format("0,0"));
});

$(document).on("click", ".adjust", function (e) {
	e.preventDefault();
	$(this).addClass('d-none');
    $(this).addClass('d-none');
    $(this).closest("div.row").find("span").addClass('d-none');
	$(this).closest("div.row").find("input").removeClass('d-none');
});

$(document).on("click", ".btn-simpan", function (e) {
	e.preventDefault();
	var a = $(this).closest("form").attr("id");
	validateForm(e, a, this);
});

$(document).on("click", ".btn-logout", function (event) {
	event.preventDefault(),
    clearInterval(interval);
	swalOption($(this),"Yakin Keluar?","Yes OK!");
});

$(document).on("click", ".btn-action", function (e) {
	e.preventDefault();
    path    = $(this).data("action").split("/");
    action  = $(this).data("action");
    urloc   = "/view/modal/" + path[4];
    param   = $(this).data("param");
    var decodeToken = parseJwt(localStorage.getItem('token'));
    if($(this).data("view")=="activated") {
        var keycode     = CryptoJS.enc.Hex.parse(CryptoJS.SHA1(btoa(param)).toString());
        var authcode    = CryptoJS.enc.Hex.parse(CryptoJS.SHA1(param).toString());
        var hash		= CryptoJS.AES.encrypt(param,keycode,{iv:authcode}).toString().replace(/[^\w\s]/gi,'');
        dataParam = {
            csrf_token: getCookie("ci_sso_csrf_cookie"),
            AUTH_KEY: decodeToken.authkey,
            param:param,
            password:hash,
        };
        dataParam[keyname] = decodeToken.apikey;
        ajaxData(dataParam,action,decodeToken,$(this).data("view"));
    } 
    else if ($(this).data("view")=="delete") {
        swalOption($(this),"Yakin Hapus Item?","Klik Yes Untuk OK!");
    }
    else {
        if($(this).data("view")=="detail") {
            if ($(this).data("ket")=="edit") {
                if (path[4]=="layar_kalender") {
                    pageUrl = '/api/client/calendar/updateScreen';
                }
                if (path[4]=="bulan_kalender") {
                    pageUrl = '/api/client/calendar/updateMonth';
                }
                if (path[4]=="profile_pengguna") {
                    pageUrl = '/api/client/user/profile_pengguna';
                }
				/* if (path[4]=="detail_pengguna") {
                    pageUrl = '/api/client/user/update';
                } */
                action  = action+'_'+$(this).data("ket");
            }
            detail  = "Detail "+path[4].replace('_',' ').replace('_',' ').replace(/\b\w/g, l => l.toUpperCase());
        }
        if($(this).data("view")=="form") {
            if (path[4]=="layar_kalender") {
                pageUrl = '/api/client/calendar/createScreen';
            }
            if (path[4]=="bulan_kalender") {
                pageUrl = '/api/client/calendar/createMonth';
            }
            if (path[4]=="detail_pengguna") {
                pageUrl = '/api/client/user/create';
            }
            detail  = "Form "+path[4].replace('_',' ').replace('_',' ').replace(/\b\w/g, l => l.toUpperCase());
        }
        $(".staticmodal").find(".modal-body").load(url + urloc, function (e) {
            $("#staticmodal").modal("show");
            $("#staticmodalLabel").text(detail);
            $(".modal-body").html(e);
            editorArea();
            dropFile();
            var form = $(".modal-body").find("form").attr("id");
            $("#" + form).attr('action',pageUrl);
            hari();
            jam();
            tanggal();
            dataModal(action,param,urloc.split("/"));
        });
    }
});

$(document).on("click", '#password-addon', function(e) {
    if ($(this).siblings('input').length > 0) {
        $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
    }
});

$(document).on("change", '.checkAll', function(e) {
    if ($(this).prop("checked")==true) {
        $(this).closest('.cek-pilihan').find('.form-check-input').prop('checked', true);
    } else {
        $(this).closest('.cek-pilihan').find('.form-check-input').prop('checked', false);
    }
});

$(document).on("change", '#artikel', function(e) {
    if ($(this).prop("checked")==true) {
        $(".article-section").removeClass("d-none");
        $(".article-section").find("input").prop('required',true);
    } else {
        $(".article-section").addClass("d-none");
        $(".article-section").find("input").prop('required',false);
    }
});

$(document).on("click", '.btn-showdata', function(e) {
    e.preventDefault();
    $(".alert").alert('close');
    $(".table").attr("id","tab-laporanadministrasi");
    $(".table").data("action","/api/client/administrasi/laporanadministrasi");
    var decodeToken = parseJwt(localStorage.getItem('token'));
    loadTable($(".table").attr("id"), $(".table").data("action"), decodeToken, $("form").serializeArray());
});

$(document).on("click", "#vertical-menu-btn", function(event) {
    event.preventDefault();
    $('body').toggleClass('sidebar-enable');
    if ($(window).width() >= 992) {
        $('body').toggleClass('vertical-collpsed');
    } else {
        $('body').removeClass('vertical-collpsed');
    }
});

$(document).on("click", ".metismenu li a, .navbar-nav  li a", function(e) {
	e.preventDefault();
	page = $(this).attr("href");
	action = $(this).data("action");
	if (page == "javascript: void(0);") return false;
	if (action == null) {
		action = page;
	}
	$(".metismenu li, .metismenu li a").removeClass("active");
	$(".metismenu li, .metismenu li a").removeClass("mm-active");
	$(".metismenu ul").removeClass("in");
	menu(action);
});

function initActiveMenu(pageUrl) {
    if (pageUrl == null) return false;
    $("#sidebar-menu a").each(function (e,a) {
        if ($(a).data('action') == pageUrl) {
            $(this).addClass("active");
            $(this).parent().addClass("mm-active"); // add active to li of the current link
            $(this).parent().parent().addClass("mm-show");
            $(this).parent().parent().prev().addClass("mm-active"); // add active class to an anchor
            $(this).parent().parent().parent().addClass("mm-active");
            $(this).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link
            $(this).parent().parent().parent().parent().parent().addClass("mm-active");
        }
    });
}

function parseJwt(token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
    return JSON.parse(jsonPayload);
};

function hashPass() {
    var pass		= $('#password').val();
    var keycode     = CryptoJS.enc.Hex.parse(CryptoJS.SHA1(btoa(pass)).toString());
    var authcode    = CryptoJS.enc.Hex.parse(CryptoJS.SHA1(pass).toString());
    var hash		= CryptoJS.AES.encrypt(pass,keycode,{iv:authcode}).toString().replace(/[^\w\s]/gi,'');
    return hash;
}

function jam() {       
    var d = new Date(), h, m, s;
    h = d.getHours();
    m = d.getMinutes();
    s = d.getSeconds();
	$("#pukul").val(h +':'+ m +':'+ s);
    setTimeout('jam()', 1000);
}

function hari() {       
    const weekday = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
    const d = new Date();
    let day = weekday[d.getUTCDay()];
    $("#hari").val(day);
}

function tanggal() {       
    var d = new Date(), D, M, Y;
    D = d.getDate();
    M = d.getMonth()+1;
    Y = d.getFullYear();
	$("#tanggal").val(D +'/'+ M +'/'+ Y);
}
