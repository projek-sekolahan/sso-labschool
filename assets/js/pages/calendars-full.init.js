/*
Template Name: Minia - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Calendar init js
*/
                    var CalendarPage = function () {};
					CalendarPage.prototype.init = function () {
                        // variabel
                        var addEvent = $("#event-modal");
						var modalTitle = $("#modal-title");
						var formEvent = $("#form-event");
						var selectedEvent = null;
						var newEventDate = null;
                        var edate = null;
                        var emonth = null;
                        var eyear = null;
                        var sdate = null;
                        var smonth = null;
                        var syear = null;
                        var date = new Date();
						var m = date.getMonth();
						var y = date.getFullYear();
                        var decodeToken = parseJwt(localStorage.getItem('token'));
                        
                        // initialize drag calendar 
                        var dragEl = $('#external-events')[0];
                        new FullCalendarInteraction.Draggable(dragEl, {
							itemSelector: ".external-event",
							eventData: function(eventEl) {
								return {
									title: eventEl.innerText,
									className: $(eventEl).data("class")
								}
							}
						});

						// initialize the calendar
                        var calendarEl = $('#calendar')[0];
                        $(document).ready(function() {
                            m = (m<10) ? '0'+(m+1):(m+1);
                            param = m+'-'+y;
                            calendar = new FullCalendar.Calendar(calendarEl, {
                                locale: 'id',
                                plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
                                editable: true,
                                droppable: true,
                                selectable: true,
                                defaultView: "dayGridMonth",
                                themeSystem: "bootstrap",
                                header: {
                                    left: "prev,next",
                                    right: "title"
                                },
                                monthNames: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                                monthNamesShort: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],
                                dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
                                dayNamesShort: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
                                initialView: getInitialView(),
                                // responsive
                                windowResize: function (view) {
                                    var newView = getInitialView();
                                    calendar.changeView(newView);
                                },
                                eventClick: function (info) {
                                    info.jsEvent.preventDefault();
                                    addEvent.modal('show');
                                    formEvent.attr('action','/api/client/calendar/update');
                                    formEvent[0].reset();
                                    editorArea();
                                    dropFile();
                                    selectedEvent   = info.event;
                                    newEventDate    = eventDate(selectedEvent);
                                    $("#event-id").val(selectedEvent.id);
                                    $("#btn-delete-event").data('param',selectedEvent.id);
                                    $("#btn-delete-event").data('action','/api/client/calendar/delete');
                                    $("#event-date").val(newEventDate);
                                    $("#event-title").val(selectedEvent.title);
                                    $('#event-category > option').each(function() {
                                        if($(this).val().split('/')[0] == selectedEvent.classNames[0]) {
                                            $(this).prop("selected", true);
                                        }
                                    });
                                    modalTitle.text('Rubah Tanda Hari');
                                    if (selectedEvent.url) {
                                        $("#artikel").prop("checked",true);
                                        $(".article-section").removeClass("d-none");
                                        $.each(selectedEvent.extendedProps, function(i,j) {
                                            if(i=="article-description") {
                                                $("#"+i).html(j);
                                            } else {
                                                $("#"+i).val(j);
                                            }
                                        });
                                        window.open(info.event.url);
                                    }
                                },
                                eventReceive: function(info) {
                                    dragDropAjax(info.event,'/api/client/calendar/create','create');
                                },
                                eventResize: function(info) {
                                    dragDropAjax(info.event,'/api/client/calendar/update','update');
                                },
                                eventDrop: function(info) {
                                    dragDropAjax(info.event,'/api/client/calendar/update','update');
                                },
                                dayRender: function (cell) {
                                    $('.fc-sun').addClass('text-danger fw-bolder');
                                    $('.fc-sat').addClass('text-success fw-bolder');
                                },
                                dateClick: function (info) {
                                    addNewEvent(info);
                                },
                            });
                            calendar.render();
                            ajaxCalendar(param,decodeToken);
                        });
                        
                        // function
                        function ajaxCalendar(param,decodeToken) {
                            dataParam = {
                                csrf_token: getCookie("ci_sso_csrf_cookie"),
                                AUTH_KEY: decodeToken.authkey,
                                param:param,
                            };
                            dataParam[keyname] = decodeToken.apikey;
                            $.ajax({
                                url     : url+'/api/client/calendar/read',
                                data    : dataParam,
                                type    : 'post',
                                method  : "post",
                                dataType: 'json',
                                headers: {
                                    "Authorization": "Basic " + decodeToken.authkey,
                                },
                                success : function(t) {
                                    var hasil = parseJwt(t.data);
									hasil = decrypt(hasil,'fromResponse');
                                    hasil = hasil.data;
                                    calendar.addEventSource(hasil);
                                }
                            });
                        }
                        function eventDate(selectedEvent) {
                            edate   = (selectedEvent._instance.range.end.getDate()<10) ? ('0'+selectedEvent._instance.range.end.getDate()):selectedEvent._instance.range.end.getDate();
                            emonth  = (selectedEvent._instance.range.end.getMonth()<10) ? '0'+(selectedEvent._instance.range.end.getMonth()+1):(selectedEvent._instance.range.end.getMonth()+1);
                            eyear   = selectedEvent._instance.range.end.getFullYear();
                            sdate   = (selectedEvent._instance.range.start.getDate()<10) ? ('0'+selectedEvent._instance.range.start.getDate()):selectedEvent._instance.range.start.getDate();
                            smonth  = (selectedEvent._instance.range.start.getMonth()<10) ? '0'+(selectedEvent._instance.range.start.getMonth()+1):(selectedEvent._instance.range.start.getMonth()+1);
                            syear   = selectedEvent._instance.range.start.getFullYear();
                            return emonth+'/'+edate+'/'+eyear+'-'+smonth+'/'+sdate+'/'+syear;
                        }
                        function dragDropAjax(selectedEvent,action,event) {
                            newEventDate    = eventDate(selectedEvent);
                            if(selectedEvent.classNames[0]=="bg-primary") {
                                icon = 'bg-primary/kegiatan';
                            }
                            if(selectedEvent.classNames[0]=="bg-danger") {
                                icon = 'bg-danger/libur';
                            }
                            if(selectedEvent.classNames[0]=="bg-success") {
                                icon = 'bg-success/penting';
                            }
                            var decodeToken = parseJwt(localStorage.getItem('token'));
                            dataParam = {
                                csrf_token: getCookie("ci_sso_csrf_cookie"),
                                AUTH_KEY: decodeToken.authkey,
                                'event-date'    :newEventDate,
                                'event-id'      :selectedEvent.id,
                                'event-title'   :selectedEvent.title,
                                'event-category':icon,
                            };
                            dataParam[keyname] = decodeToken.apikey;
                            ajaxData(dataParam,action,decodeToken,event);
                        }
                        function addNewEvent(info) {
                            addEvent.modal('show');
                            formEvent.attr('action','/api/client/calendar/create');
                            formEvent.removeClass("was-validated");
                            formEvent[0].reset();
                            editorArea();
                            dropFile();
                            $("#artikel").prop("checked",false);
                            $(".article-section").addClass("d-none");
                            modalTitle.text('Tambah Tanda Hari');
                            selectedEvent = info.date;
                            edate   = (selectedEvent.getDate()<10) ? ('0'+selectedEvent.getDate()):selectedEvent.getDate();
                            emonth  = (selectedEvent.getMonth()<10) ? '0'+(selectedEvent.getMonth()+1):(selectedEvent.getMonth()+1);
                            eyear   = selectedEvent.getFullYear();
                            sdate   = (selectedEvent.getDate()<10) ? ('0'+selectedEvent.getDate()):selectedEvent.getDate();
                            smonth  = (selectedEvent.getMonth()<10) ? '0'+(selectedEvent.getMonth()+1):(selectedEvent.getMonth()+1);
                            syear   = selectedEvent.getFullYear();
                            $("#event-date").val(emonth+'/'+edate+'/'+eyear+'-'+smonth+'/'+sdate+'/'+syear);
                        }
                        function getInitialView() {
                            if (window.innerWidth >= 768 && window.innerWidth < 1200) {
                                return 'timeGridWeek';
                            } else if (window.innerWidth <= 768) {
                                return 'listMonth';
                            } else {
                                return 'dayGridMonth';
                            }
                        }
                        // Form to add new event
                        $(formEvent).on('submit', function (ev) {
                            ev.preventDefault();
                            var a = formEvent.attr("id");
                            validateForm(ev, a, formEvent);
                        });
                        $("#btn-delete-event").on('click', function (e) {
                            e.preventDefault();
                            selectedEvent.remove();
                            selectedEvent = null;
                            addEvent.modal('hide');
                            swalOption($(this),"Yakin Hapus Item?","Klik Yes Untuk OK!");
                        });
                        $(document).on("click",".fc-prev-button",function(e) {
                            e.preventDefault();
                            m = (m<11) ? '0'+(m-1):(m-1);
                            if (m=='00') {
                                let d = new Date(y,0);
                                let l = new Date(d.getFullYear(), d.getMonth()-1);
                                m = l.getMonth()+1;
                                y = l.getFullYear();
                                param = m+'-'+y;
                            } else {
                                param = m+'-'+y;
                            }
                            calendar.refetchEvents();
                            var eventSources = calendar.getEventSources();
                            eventSources[0].remove();
                            ajaxCalendar(param,decodeToken);
                        });
                        $(document).on("click",".fc-next-button",function(e) {
                            e.preventDefault();
                            let d = new Date(y,m);
                            let l = new Date(d.getFullYear(), d.getMonth());
                            m = l.getMonth();
                            y = l.getFullYear();
                            m = (m<9) ? '0'+(m+1):(m+1);
                            param = m+'-'+y;
                            calendar.refetchEvents();
                            var eventSources = calendar.getEventSources();
                            eventSources[0].remove();
                            ajaxCalendar(param,decodeToken);
                        });
					};
                    
						//init
						$.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage;
