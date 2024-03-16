/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Datatables Js File
*/

function loadTable(e, a, b, t) {
	var s,
		o = { table: e, key: t, csrf_token: getCookie("ci_sso_csrf_cookie"), AUTH_KEY: b.authkey};
		o[keyname] = b.apikey;
	var n = "#" + e,
		l = $.ajax({ url: url+a, data: o, type: "post", dataType: "json", headers: {
		    "Authorization": "Basic " + b.authkey,
		}}).done(
			function (t) {
				var hasil = parseJwt(t.data);
				hasil = decrypt(hasil,'fromResponse');
				if (0 == hasil.recordsTotal || hasil.columns == 0) {
					$("#" + e)
						.parent()
						.append(
							'<div class="alert alert-danger" role="alert" id="alert-'+e+'">Data Belum Ada!</div>'
						);
					$("#" + e).addClass("d-none");
				} else {
					$("#alert-" + e).alert('close');
                    $("#" + e).removeClass("d-none");
					$("#" + e)
						.next(".img-err")
						.remove();
					$.each(hasil.columns, function (e, a) {
						(s = "<th>" + a.name + "</th>"), $(s).appendTo(n + ">thead>tr");
					});
					hasil.columns[0].render = function (e, a, t) {
						return e;
					};
						$(n).DataTable({
							data: hasil.data,
							columns: hasil.columns,
							searching: !0,
							paging: !0,
							ordering: !0,
							info: !1,
							pageLength: 50,
							responsive: !0,
							destroy: !0,
							lengthChange: !0,
                            lengthMenu: [
                                [50, 100, 150, 200, 250, 300, 350, 400, 450, -1],
                                [50, 100, 150, 200, 250, 300, 350, 400, 450, 'All'],
                            ],
							language: {
                                paginate: { previous: "<", next: ">" },
								info: "Showing page _PAGE_  of _PAGES_",
								search: "_INPUT_",
								searchPlaceholder: "Cari...",
								sEmptyTable:
									'<div class="alert alert-danger" role="alert">Data Belum Ada!</div>',
							},
							fnDrawCallback: function (data, callback, settings) {
								$("input[type='search']").css("width", "250px").focus();
							},
							fnInitComplete: function (data, callback, settings) {
								// console.log(callback);
							}
						});
                }
            })
			.fail(function(xhr, status, error) {
				// Penanganan kesalahan
				errmsg(xhr, status, error);
			});
}
