/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Material design Init Js File
*/

function dataModal(action,param,form) {
    var decodeToken = parseJwt(localStorage.getItem('token'));
    dataParam = {
		csrf_token: getCookie("ci_sso_csrf_cookie"),
		AUTH_KEY: decodeToken.authkey,
        param:param,
	};
	dataParam[keyname] = decodeToken.apikey;
    ajaxData(dataParam,action,decodeToken,form);
}

function ajaxSwal(event) {
	var decodeToken = parseJwt(localStorage.getItem('token'));
	dataParam = {
		csrf_token: getCookie("ci_sso_csrf_cookie"),
		AUTH_KEY: decodeToken.authkey,
	};
	($(event).data('id')) ? param = $(event).data('id'):param = $(event).data('param');
	action = $(event).data('action');
	dataParam[keyname] = decodeToken.apikey;
	if ($(event).children('span').text()!='Logout') {
		if ($(event).data("ket")!='calendar') {
			action = action+'_'+$(event).data("ket");
		}
		dataParam["paramID"] = param;
	}
	ajaxData(dataParam,action,decodeToken,event);
}

function checkSession(action) {
	var decodeToken = parseJwt(localStorage.getItem('token'));
    dataParam = {
		csrf_token: getCookie("ci_sso_csrf_cookie"),
		AUTH_KEY: decodeToken.authkey,
	};
	dataParam[keyname] = decodeToken.apikey;
	ajaxData(dataParam,action,decodeToken,null);
}
