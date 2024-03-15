/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Table responsive Init Js File
*/

function dataLoad(t,s) {
    if (s[1]=="view") {
        var hasil = parseJwt(t.data);
		hasil = decrypt(hasil,'fromResponse');
		if (s[3]=="menu_akses") {
			// options = void 0 === $("#menu_groupid").val() ? '<option value="" class="opt-val-category">Pilih Pages Parent</option>': "";
			console.log(hasil);
			/* $("#menu_groupid option").val(function (s, t) {
				$(this)
					.siblings("[value='" + t + "']")
					.remove();
			}),
			$("#menu_groupid").val() == hasil.id ? (options +=
							'<option value="' +
							hasil.id +
							'" class="opt-val-category" selected>' +
							hasil.nama_menu +
							"</option>")
					: (options +=
							'<option value="' +
							hasil.id +
							'" class="opt-val-category">' +
							hasil.nama_menu +
							"</option>"); */
			// Bersihkan elemen select sebelum menambahkan opsi
			$('#menu_groupid').empty();
			// Buat opsi untuk setiap elemen dalam data
			options = $('<option>', {
				value: hasil.id,  // Tentukan nilai dari opsi
				text: hasil.nama_menu     // Tentukan teks dari opsi
			});
			// Tambahkan opsi ke dalam elemen select
			$("#menu_groupid").append(options);
			// Loop melalui data yang diterima
			$.each(hasil, function (index, item) {
				console.log(index, item);
				// Periksa jika opsi harus dipilih (selected option)
				/* if (item.isSelected) {
					options.attr('selected', 'selected');
				} */
			});
			
		}
        if (s[3]=="profile_pengguna") {
            $(".username").text(hasil.nama_lengkap);
            $(".jabatan").text((hasil.jabatan==null) ? 'Belum Punya Jabatan':hasil.jabatan);
            $("#foto-profile").attr('src',hasil.img_location);
            $("#btn-editProfile").data('action','/api/client/user/detail_pengguna');
            $("#btn-editProfile").data('param',hasil.email);
            $.each(hasil, function (a, b) {
                c = (a.replace('_',' ')).replace(/\b\w/g, l => l.toUpperCase());
                (b==null || b=='') ? d='Belum Ada Data':d=b;
                if (a=='nomor_induk' || a=='email' || a=='phone') {
                    detail = '<div class="row">'+
                    '<div class="col-sm-4"><h6 class="mb-0">'+c+'</h6></div>'+
                    '<div class="col-sm-8 text-secondary"><span class="valadjust">'+d+'</span></div></div><hr>';
                    $(".detail").append(detail);
                }
            });
        }
        if (s[3]=="detail_pengguna") {
            $.each(hasil, function (a, b) {
                $("#"+a).val(b);
            })
        }
        if (s[3]=="bulan_kalender") {
            $.each(hasil, function (a, b) {
                $("#article-id").val(b.idtab);
                $("#article").val(b.article);
                $(".tiny").html(b.description);
                tinyMCE.activeEditor.setContent(b.description);
            });
        }
        if (s[3]=="layar_kalender") {
            $.each(hasil, function (a, b) {
                $("#layar-id").val(b.idtab);
                if (b.is_active==1) {
                    $("#aktif").prop("checked",true);
                }
            });
        }
    }
    else {
        if (s=="form-login") {
            localStorage.setItem("token",t.data.Tokenjwt);
        }
        if (s=="form-verify") {
            localStorage.setItem("token",t.data.token);
            localStorage.setItem("expired",new Date().getTime()+300);
        }
        if (typeof t.data=="object") {
            swalMsg(t.data.title, t.data.message, t.data.info, t.data.location);
        } else {
            var hasil = parseJwt(t.data);
			hasil = decrypt(hasil,'fromResponse');
            swalMsg(hasil.title, hasil.message, hasil.info, hasil.location);
        }
    }
}

