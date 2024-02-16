function call_ajax_page(page) {
	document.title = page.replace(/\b\w/g, l => l.toUpperCase()) + " User | Aplikasi Administrasi Kalender";
	urloc = "/content" + "/" + page;
	$.post(url + "/view" + urloc, {
		csrf_token: getCookie("csrf_cookie"),
	}).done(function (e) {
		localStorage.setItem("pages", page);
		if (page=="dashboard") {
			$(e).find("#header").load(url + "/view/subcontent/header", function (t) {
				$("#header").prepend(t);
			});
			$(e).find("#leftSidebar").load(url + "/view/subcontent/leftSidebar", function (t) {
				$("#leftSidebar").prepend(t);
				$("#leftSidebar").find("#side-menu").metisMenu();
				initActiveMenu(localStorage.getItem('menu'));
				menu(localStorage.getItem('menu'));
			});
			$(e).find("#rightSidebar").load(url + "/view/subcontent/rightSidebar", function (t) {
				$("#rightSidebar").prepend(t);
			});
			$(e).find("#footer").load(url + "/view/subcontent/footer", function (t) {
				$("#footer").prepend(t);
			});
		}
		$("#content").html(e);
	}).fail(function(jqXHR) {
        if(jqXHR.status==500 || jqXHR.status==0) {
			localStorage.clear();
			location.reload();
        }
    });
}

function menu(action) {
	if (action==null) {
		action = "overview";
	}
		$("#content").find('#status').fadeOut();
        $("#content").find('#preloader').delay(500).fadeOut('slow');
		$("#content").find("#result").load(url + "/view/menu/" + action, function (e) {
				localStorage.setItem("menu", action);
				var decodeToken = parseJwt(localStorage.getItem('token'));
				$(".main-content").find(".apex-charts").each(function(s,t) {
					makeChart($(t).attr("id"),$(t).data("key"));
				});
				$(".main-content").find(".table").each(function(s,t) {
					loadTable($(t).attr("id"), $(t).data("action"), decodeToken, $(t).data("key"));
				});
				$(".main-content").find(".temp-calendar").each(function(s,t) {
					$.CalendarPage.init();
				});
				initActiveMenu(localStorage.getItem('menu'));
		});
}

function ajaxData(dataParam,action,decodeToken,event) {
	$.ajax({
        url     :   url+action,
        data    :   dataParam,
        method: "post",
		dataType: "json",
		headers: {
			"Authorization": "Basic " + decodeToken.authkey,
		},
        success: function(response, textStatus, xhr) {
			if (xhr.status=='201') {
				if (event==null) {
					clearInterval(interval);
					localStorage.clear();
					swalMsg(response.data.title, response.data.message, response.data.info, response.data.location);
				} else {
					dataLoad(response,event);
				}
            } else if ("Edit" == $(event).children('span').text()) {
				dataLoad(response,event);
			} 
        },
        error: function(xhr, status, error) {
			errmsg(xhr, status, error);
        }
    });
}

function ajaxSave(dataParam,action,authkey,event) {
	$.ajax({
		url: url + action,
		data: dataParam,
		type: "post",
		method: "post",
		dataType: "json",
		headers: {
			"Authorization": "Basic " + authkey,
		},
		processData: !1,
		contentType: !1,
		success: function (t) {
			if (t.status==false) {
				swalMsg(t.title, t.message, t.info, t.location);
			} else {
				dataLoad(t,event);
			}
		}
		,error: function(xhr, status, error){
			errmsg(xhr, status, error);
        }
	});
}
