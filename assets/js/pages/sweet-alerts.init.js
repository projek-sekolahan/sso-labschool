/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Sweetalert Js File
*/
    function errmsg(xhr, status, error) {
        var t = xhr.responseJSON;
        if (xhr.status=='403' || xhr.status=='500' || xhr.status=='404' || xhr.status=='400') {
            if (typeof(t)=='object') {
                swalMsg(t.data.title, t.data.message, t.data.info, t.data.location);
            } else {
                toastAlert("warning", "Connection Loose");
            }
        }
    }

    function swalOption(event,titleswal,htmlswal) {
        Swal.fire({
            title: titleswal,
            html: htmlswal,
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#31a66a",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes , Do it!",
            cancelButtonText: "No , Cancel",
            showLoaderOnConfirm: !0,
            reverseButtons: !0,
            allowOutsideClick: !1,
            allowEscapeKey: !1,
            preConfirm: function (s) {
                return new Promise(function (m, n) {
                    ajaxSwal(event);
                }).catch((t) => {
                    Swal.showValidationMessage(`Request failed: ${t}`);
                });
            },
        }).then((t) => {
            t.dismiss === Swal.DismissReason.cancel &&
                toastAlert("info", "Terima Kasih");
        });
    }    

    function toastAlert(icon,title) {
        const Toast = Swal.mixin({
            toast               : true,
            position            : 'top-end',
            showConfirmButton   : false,
            allowOutsideClick   : false,
            allowEscapeKey      : false,
            timer               : 3000,
            timerProgressBar    : true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        Toast.fire({
          icon  : icon,
          title : title
        }).then((result) => {location.reload();});
    }    

    function swalMsg(title,message,icon,detail) {
        if (icon=="success" || icon=="error" || icon=="info") {
            configmsg = {
                position: 'center',
                icon: icon,
                title: title,
                html: message,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 3000,
                timerProgressBar: true,
            }
        }
        Swal.fire(configmsg).then((result) => {
            if (detail=='login') {
                localStorage.clear();
            } else {
                localStorage.setItem("pages", detail);
            }
            location.reload();
        });
    }
