/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Form validation Js File
*/

$.validator.addMethod(
	"strongePassword",
	function (a) {
		return (
			/^[A-Za-z0-9\d=!\-@._*]*$/.test(a) &&
			/[a-z]/.test(a) &&
			/\d/.test(a) &&
			/[A-Z]/.test(a)
		);
	},
	"Minimal 1 Number, 1 Huruf Kecil, dan 1 Huruf Besar"
);

$.validator.setDefaults({
	ignore: ":hidden",
});

function validForm(a) {
	$("#" + a).validate({
		rules: {
			phone: {
				required    : true,
				number      : true
			},
			username: {
				required    : true,
				email       : true
			},
			password: {
				required: true,
				minlength: 6,
				maxlength: 20,
				strongePassword: false,
			},
			confirmpassword: {
				required: true,
				minlength: 6,
				maxlength: 20,
				equalTo: "#password",
			},
		},
		messages: {
			phone: "Silakan Isi No.HP Valid",
			username: "Silakan Isi Email Valid",
			password: {
				required: "Silakan Isi Password",
				minlength: "Password Min 6 karakter",
				maxlength: "Password Max 20 karakter",
			},
			confirmpassword: {
				required: "Ulangi Password Anda",
				minlength: "Password Min 6 karakter",
				maxlength: "Password Max 20 karakter",
				equalTo: "Password Tidak Cocok",
			},
		},
		errorPlacement: function (a, t) {
			a.addClass("invalid-feedback");
			if ("checkbox" === t.prop("type")) {
				a.insertAfter(t.next("label"));
			} else if ("password" === t.prop("name")) {
				a.insertAfter(t.next("button"));
			} else {
				a.insertAfter(t);
			}
		},
		highlight: function (a, t) {
			$(a).addClass("is-invalid").removeClass("is-valid");
		},
		unhighlight: function (a, t) {
			$(a).addClass("is-valid").removeClass("is-invalid");
		},
	});
}

function validateForm(a, t, i) {
	"form-register" == t || "form-recover" == t || "form-setpassword" == t || "form-reset" == t || "form-login" == t
		? (validForm(t), $("#" + t).valid() && save(t, a, i))
		: (!1 === $("#" + t)[0].checkValidity()
				? (a.preventDefault(), a.stopPropagation())
				: (a.preventDefault(), save(t, a, i)),
		$("#" + t).addClass("was-validated")
	);
}

function save(a, e, i) {
	e.preventDefault();
	if (a=='form-login') {
		var hash = hashPass();
		key			= btoa($("#username").val() + ":" + hash);
		authkey		= key;
		dataParam	= new FormData();
		tokenkey	= CryptoJS.SHA1(key).toString();
		dataParam.append("username", $("#username").val());
		dataParam.append("password", hash);
	} else if (a=='form-setpassword') {
		var hash = hashPass();
		key			= btoa($("#username").val() + ":" + hash);
		authkey		= key;
		dataParam	= new FormData();
		tokenkey	= localStorage.getItem('token');
		dataParam.append("password", hash);
	} else if (a=='form-verify' || a=='form-recover' || a=='form-register') {
		dataParam	= new FormData($("#" + a)[0]);
	}
	else {
		var decodeToken = parseJwt(localStorage.getItem('token'));
		dataParam	= new FormData($("#" + a)[0]);
		tokenkey	= decodeToken.apikey;
		authkey		= decodeToken.authkey;
		dataParam.append("AUTH_KEY", authkey);
		if (a=='form-createUser' || a=='form-event' || a=='form-createMonth' || a=='form-createScreen') {
			/* if (a=='form-createUser') {
				var keycode     = CryptoJS.enc.Hex.parse(CryptoJS.SHA1(btoa($("#nip").val())).toString());
				var authcode    = CryptoJS.enc.Hex.parse(CryptoJS.SHA1($("#nip").val()).toString());
				var hash		= CryptoJS.AES.encrypt($("#nip").val(),keycode,{iv:authcode}).toString().replace(/[^\w\s]/gi,'');
				dataParam.append("password", hash);
			}
			if (a=='form-event' || a=='form-createMonth') {
				tinymce.triggerSave();
				dataParam.append("article-description", tinymce.activeEditor.getContent());
			} */
			img = new Array();
			$(".dz-preview").each(function (e,a) {
				img.push($(a).find('.dz-image>img').attr('src'),)
			});
			dataParam.append("img", JSON.stringify(img));
		}
	}

	dataParam.append("csrf_token", getCookie("ci_sso_csrf_cookie"));
	dataParam.append(window.location.host.split(".")[0], tokenkey);
	action = $("#" + a).attr("action");
	$("#" + a +" input").prop("disabled", !0);
	$("#" + a +" button").prop("disabled", !0);
	$(i).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
	ajaxSave(dataParam,action,authkey,a);
}
