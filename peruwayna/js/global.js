// Global Functions
var jq = jQuery;

var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
var endDate = new Date(nowDate.getFullYear(), nowDate.getMonth() + 4, nowDate.getDate(), 0, 0, 0, 0);
var month;
var freeDays = [];
var teacherDays = [];
var hoursDays = [];

fetchFreeDays();

jq(document).ready( function() {

    var nowTime = moment().utcOffset(-5).format('HH:mm A');

    if(sessionStorage.length > 0){
        jq("#validateClasses").slideDown(1000);
    }

    jq("#AddTeacherForm").validate({
        rules: {
            name: "required",
            lastname: "required",
            country: "required",
            birthday: "required",
            email1: {
                required: true,
                email: true,
                remote: url_rel + '/templates-admin/validate/validate.php?type=email1',
            },
            email2: {
                required: true,
                email: true,
                remote: url_rel + '/templates-admin/validate/validate.php?type=email2',
            },
            skype: {
                required: true,
                remote: url_rel + '/templates-admin/validate/validate.php?type=skype',
            },

        },
        messages: {
            name: "Por favor ingresa un nombre.",
            lastname: "Por favor ingresa un apellido.",
            country: "Por favor ingresa un país.",
            birthday: "Por favor ingresa una fecha de cumpleaños.",
            picture: "Sube la foto del profesor",
            email1: {
                required: "Por favor ingresa un email válido.",
                remote: 'Email ya se usó.'
            },
            email2: {
                required: "Por favor ingresa un email válido.",
                remote: 'Email ya se usó.'
            },
            description: "Por favor, agrega una breve descripción.",
            password: "Ingresa una contraseña.",
            skype: {
                required: "Ingresa un ID de skype válido.",
                remote: 'Este ID de Skype ya se usó.'
            },            
        },

    });

    jq("#updateTeacher").validate({
        rules: {
            name: "required",
            lastname: "required",
            country: "required",
            birthday: "required",
            email: {
                required: true,
                email: true,
            },
            emailCorp: {
                required: true,
                email: true,
            },
            skype: {
                required: true,
            },
            oldPassword: {
                remote: url_rel + '/templates-teacher/validate/validate-teacher.php?type=oldPassword',
            },
            password : { 
                required: true,
            },
            repassword:{
                equalTo: "#inputPassword"
            }
        },
        messages: {
            name: "Por favor ingresa un nombre.",
            lastname: "Por favor ingresa un apellido.",
            country: "Por favor ingresa un país.",
            birthday: "Por favor ingresa una fecha de cumpleaños.",
            picture: "Sube la foto del profesor",
            email: {
                required: "Por favor ingresa un email válido.",
            },
            emailCorp: {
                required: "Por favor ingresa un email válido.",
            },
            description: "Por favor, agrega una breve descripción.",
            skype: {
                required: "Ingresa un ID de skype válido.",
            },
            oldPassword: {
                remote: 'No coincide con tu contraseña.'
            },
            password : "Ingresa una contraseña.",
            repassword : "Confirma la contraseña.",            
        },

    });

    jq('#datetimeStart').datepicker({
        pickTime: false
    });

    jq('#datetimeEnd').datepicker({
        pickTime: false
    });

    jq('#startday.input-group.date').datepicker({
        startDate: today,
        endDate: endDate,
        pickTime: false
    });

    jq('#startdayNot.input-group.date').datepicker({
        endDate: endDate,
        pickTime: false
    });

    jq('#notstart.input-group.date').datepicker({
        endDate: endDate,
        pickTime: true
    });

    jq('#endToday.input-group.date').datepicker({
        endDate: today,
        pickTime: true
    });

    jq('#registerStudent').validate({
        rules: {
            name: "required",
            lastname: "required",
            country: "required",
            birthday: "required",
            email: {
                required: true,
                email: true,
                remote: url_rel + '/templates-admin/validate/validate-student.php?type=email',
            },
            skypeID: {
                required: true,
                remote: url_rel + '/templates-admin/validate/validate-student.php?type=skype',
            },
            password : { 
                required: true,
            },
            repassword:{
                equalTo: "#inputPassword"
            }
        },
        messages: {
            name: "Por favor ingresa un nombre.",
            lastname: "Por favor ingresa un apellido.",
            country: "Por favor ingresa un país.",
            city: "Por favor ingresa una ciudad.",
            birthday: "Por favor ingresa una fecha de cumpleaños.",
            lang: "Campo requerido.",
            other_lang: "Campo requerido.",
            ocupation: "Campo requerido.",
            picture: "Sube tu foto personal",
            email: {
                required: "Por favor ingresa un email válido.",
                remote: 'Email ya se usó.'
            },
            password : "Ingresa una contraseña.",
            repassword : "Confirma la contraseña.",
            skypeID: {
                required: "Ingresa un ID de skype válido.",
                remote: 'Este ID de Skype ya se usó.'
            },            
        }
    });

    jq('#updateStudent').validate({
        rules: {
            name: "required",
            lastname: "required",
            country: "required",
            birthday: "required",
            email: {
                required: true,
                email: true,
            },
            skypeID: {
                required: true,
            },
            oldPassword: {
                remote: url_rel + '/templates-student/validate/validate-student.php?type=oldPassword',
            },
            password : { 
                required: true,
            },
            repassword:{
                equalTo: "#inputPassword"
            }
        },
        messages: {
            name: "Por favor ingresa un nombre.",
            lastname: "Por favor ingresa un apellido.",
            country: "Por favor ingresa un país.",
            city: "Por favor ingresa una ciudad.",
            birthday: "Por favor ingresa una fecha de cumpleaños.",
            lang: "Campo requerido.",
            other_lang: "Campo requerido.",
            ocupation: "Campo requerido.",
            picture: "Sube tu foto personal",
            email: {
                required: "Por favor ingresa un email válido.",
            },
            oldPassword: {
                remote: 'No coincide con tu contraseña.'
            },
            password : "Ingresa una contraseña.",
            repassword : "Confirma la contraseña.",
            skypeID: {
                required: "Ingresa un ID de skype válido.",
            },            
        }
    });

    jq('#inputPassword').on('keyup', function () {  
        current = 5 - parseInt(jq(this).val().length);
        jq(this).rules('add', {
            minlength: 5,
            messages: {
                minlength: "Faltan " + current + " carácteres."
            }
        });
    });


    jq('#nextStep').click( function(e) {
        e.preventDefault();

        if ( jq("#registerStudent").valid() ) {
            jq('.firststep').fadeOut(800);
            setTimeout(function() {
                jq('.secondstep').fadeIn(800);
            }, 850);
        }
    });

    jq('form.chooseHours').hide();

    jq(document).on('click', '#teacher-details .datepicker th.prev, #teacher-details .datepicker th.next', function (ev) {
        month = jq('.datepicker-days thead th.datepicker-switch').text();
        month = month.substring(0,month.length - 5);
        year = nowDate.getFullYear();

        freeDays = [];

        jq('form.chooseHours').fadeOut(1000);

        if(ev.target.className == 'next'){
            fetchFreeDays(year, month);

            console.log(freeDays);
        }
        else if(ev.target.className == 'prev'){
            fetchFreeDays(year, month);

            console.log(freeDays);
        }
    });

    jq(document).on('click', '#booking-class .datepicker th.prev, #booking-class .datepicker th.next', function (ev) {
        month = jq('.datepicker-days thead th.datepicker-switch').text();
        month = month.substring(0,month.length - 5);
        year = nowDate.getFullYear();

        teacherDays = [];

        jq('form.chooseHours').fadeOut(1000);

        if(ev.target.className == 'next'){
            classesByTeacher(year, month);
        }
        else if(ev.target.className == 'prev'){
            classesByTeacher(year, month);
        }

    });

    jq(document).on('click', '#booking-byhour .datepicker th.prev, #booking-byhour .datepicker th.next', function (ev) {
        month = jq('.datepicker-days thead th.datepicker-switch').text();
        month = month.substring(0,month.length - 5);
        year = nowDate.getFullYear();

        hoursDays = [];

        jq('form.chooseHours').fadeOut(1000);
        jq(".loader").show();

        if(ev.target.className == 'next'){
            classesByHour(year, month);
        }
        else if(ev.target.className == 'prev'){
            classesByHour(year, month);
        }
    });

    // TEACHER PANEL - CLASSES
    jq('a#suspendClass').click( function(e){
        e.preventDefault();
        
        var id_class = jq(this).data('idclass');
        var id_student = jq(this).data('student');

        if(id_student == 0){
            jq('#myModal').modal();
            jq('.class-proccess').attr('data-student',id_student).attr('data-idclass',id_class);
            jq('.has-student').hide();
            jq('.not-student').show();
        }else{
            jq('#myModal').modal();
            jq('.class-proccess').attr('data-student',id_student).attr('data-idclass',id_class);
            jq('.not-student').hide();
            jq('.has-student').show();
        }

        jq('#myModal').on('show.bs.modal', centerModal);
    });

    // STUDENT PANEL - MY CLASSES
    jq('a#suspendClass').click( function(e){
        e.preventDefault();
        
        var id_class = jq(this).data('idclass');
        var id_teacher = jq(this).data('teacher');
        var class_i = jq(this).data('class');

        if(class_i == 'cancelclass-plus'){
            jq('#InfoModal').modal();
            jq('#InfoModal').on('show.bs.modal', centerModal);
            jq('.class-cancelclass').attr('data-teacher',id_teacher).attr('data-idclass',id_class).attr('data-cancel','plus');
            jq('.not-class').hide();
            jq('.has-class-minus').hide();
            jq('.has-class-plus').show();
        }else if(class_i == 'cancelclass-minus'){
            jq('#InfoModal').modal();
            jq('#InfoModal').on('show.bs.modal', centerModal);
            jq('.class-cancelclass').attr('data-teacher',id_teacher).attr('data-idclass',id_class).attr('data-cancel','minus');
            jq('.not-class').hide();
            jq('.has-class-plus').hide();
            jq('.has-class-minus').show();
        }else{
            jq('#InfoModal').modal();
            jq('#InfoModal').on('show.bs.modal', centerModal);
            jq('.has-class-plus').hide();
            jq('.has-class-minus').hide();
            jq('.not-class').show();
        }
    });

    jq('#buy-hourstopay').click( function(e) {
        e.preventDefault();
        
        jq('#buyclass').slideUp(1000);

        setInterval(function() {
            jq('#buy-onlybooked').slideDown(1000);
        }, 500);
        
    });

    jq('#buy-hourpack').click( function(e) {
        e.preventDefault();
        
        jq('#buyclass').slideUp(1000);

        setInterval(function() {
            jq('#buy-package').slideDown(1000);
        }, 500);
        
    });

    jq('#booking-class.step-two').slideUp(2000);
    
});

function getMonthFromString(mon){
    var d = Date.parse(mon + "1," + nowDate.getFullYear());
    if(!isNaN(d)){
        return new Date(d).getMonth() + 1;
    }
    return -1;
}

function fetchFreeDays(year, month, id_teacher) {

    jq.ajax({
        type: 'POST',         
        url: apfajax.ajaxurl,
        data: {
            action: 'fetchFreeDays',
            month: month,
            id_teacher: id_teacher    
        },
        success: function(data, textStatus, XMLHttpRequest) {       
            if(data != ''){
                var arr = jq.parseJSON(data);

                jq.each(arr, function(index, value) {
                    freeDays.push(value); // add this date to the freeDays array
                });
            };

            jq('.datepicker-embed div#choosePicker').datepicker({
                startDate: today,
                endDate: endDate,
            }).on('changeDate', function(e){
                var nowTime = moment().utcOffset(-5).format('x');
                var nowNow = moment().utcOffset(-5).format('MM-DD-YYYY');

                jq('#chooseDate').val(e.format('yyyy-mm-dd'));
                jq('form.chooseHours').fadeIn(1000);
                jq('.checkbox input[type=checkbox]').prop('disabled', false).prop('checked', false);

                month = jq('.datepicker-days thead th.datepicker-switch').text();
                month = month.substring(0,month.length - 5);
                year = nowDate.getFullYear();
                fetchFreeDays(year, month);

                jq(".checkbox input").each(function() {
                    // print value
                    var nowValue = moment( e.format('mm-dd-yyyy')+' '+jq(this).val() ).format('x');

                    if( nowValue < nowTime ){
                        jq(this).prop('disabled', true);                         
                        jq(this).parent().css({'color':'rgba(0,0,0,.5)'});
                    }else{
                        jq(this).parent().css({'color':'rgba(0,0,0,1)'});
                    }
                });

                jq.ajax({
                    type: 'POST',         
                    url: apfajax.ajaxurl,
                    data: {
                        action: 'get_teacher_hour',
                        date: jq('#chooseDate').val(),
                        teacher: jq('#id_teacher').val(),
                    },
                    success: function(data, textStatus, XMLHttpRequest) {       
                        var arr = jq.parseJSON(data);

                        jq.each( arr, function( i, val ) {
                            jq('.checkbox input[value="'+val+'"]').prop('disabled', true).prop('checked', true);
                        });
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            });
    
            if(data != ''){
                jq('.datepicker-days .table-condensed td').each(function() {
                    jq(this).removeClass('hasclass');
                });

                jq('.datepicker-days .table-condensed td').each(function() {
                    var cellText = jq(this).text(); 

                    for (var i = 0; i < freeDays.length; i++) {
                        if (freeDays[i] == cellText) {
                            jq(this).not('.disabled').addClass('hasclass');
                        }
                    }
                });
            }
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}

function classesByTeacher(year, month) {
    teacherDays = [];
    
    jq.ajax({
        type: 'POST',         
        url: apfajax.ajaxurl,
        data: {
            action: 'classesByTeacher',
            month: month,
            id_teacher: id_teacher,
        },
        success: function(data, textStatus, XMLHttpRequest) {       
            if(data != ''){
                teacherDays = [];
                var arr = jq.parseJSON(data);

                jq.each(arr, function(index, value) {
                    teacherDays.push(value); // add this date to the teacherDays array
                });
            };

            jq('.datepicker-embed div#choosePicker').datepicker({
                startDate: today,
                endDate: endDate,
            }).on('changeDate', function(e){
                jq(".loader").show();
                jq('#chooseDate').val(e.format('yyyy-mm-dd'));
                jq('.chooseDate').text(e.format('dd/mm/yyyy'));

                var day = e.format('dd');

                jq.ajax({
                    type: 'POST',         
                    url: apfajax.ajaxurl,
                    data: {
                        action: 'get_available_hour',
                        date: jq('#chooseDate').val(),
                        id_teacher: id_teacher,
                    },
                    success: function(data, textStatus, XMLHttpRequest) {       
                        jq('.availableH').html(data);
                        setTimeout(function() {
                            jq(".loader").hide();
                        }, 500);

                        var itemsNum = sessionStorage.length - 1;
                        var i = 0;

                        for (i; i <= itemsNum; i++) {
                            var ID = sessionStorage.key(i);
                            var sameID = ID.split("_");
                            console.log(sameID[1] + '_' + sameID[2]);

                            jq('div.availableH td input[data-id='+ID+']').prop('disabled', true).prop('checked', true);
                            // jq('a#'+ID).addClass('disabled');
                        }

                        jq('.datepicker-days .table-condensed td').each(function() {
                            jq(this).removeClass('hasclass');
                        });

                        jq('.datepicker-days .table-condensed td').each(function() {
                            var cellText = jq(this).text(); 

                            for (var i = 0; i < teacherDays.length; i++) {
                                if (teacherDays[i] == cellText) {
                                    jq(this).not('.disabled').addClass('hasclass');
                                }
                            }
                        });
                        
                        jq('div.availableH td input[type="checkbox"]').click( function() {
                            if(jq(this).is(':checked')){
                                jq(this).prop('disabled', true);

                                id   = jq(this).data("id");
                                hour = jq(this).val();
                                date = jq('#chooseDate').val();

                                sessionStorage.setItem(id, hour);
                                var toJSON = JSON.stringify(sessionStorage);

                                jq.ajax({
                                    type: 'POST',         
                                    url: apfajax.ajaxurl,
                                    data: {
                                        action: 'choose_classhour',
                                        classes: toJSON,
                                        id_teacher: id_teacher
                                    },
                                    success: function(data, textStatus, XMLHttpRequest) {       
                                        var arr = jq.parseJSON(data);
                                        var dataTable = jq('#selected-hours').dataTable();

                                        console.log(data);

                                        dataTable.fnClearTable();

                                        jq.each( arr['data'], function( i, val ) {
                                            dataTable.fnAddData([
                                                val['day_class'],
                                                val['start_class'],
                                                val['end_class'],
                                                val['action'],
                                            ]);

                                            var itemsNum = sessionStorage.length - 1;
                                            var i = 0;

                                            for (i; i <= itemsNum; i++) {
                                                var ID = sessionStorage.key(i);
                                                var sameID = ID.split("_");
                                                console.log(sameID[1] + '_' + sameID[2]);

                                                jq('div.availableH td input[data-id='+ID+']').prop('disabled', true).prop('checked', true);
                                                // jq('a#'+ID).addClass('disabled');
                                            };
                                        });

                                        jq('#selected-hours td').each(function() {
                                            jq(this).addClass('text-center');
                                        });
                                    },
                                    error: function(MLHttpRequest, textStatus, errorThrown) {
                                        alert(errorThrown);
                                    }
                                });
                            };
                        });
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            });
    
            if(data != ''){
                jq('.datepicker-days .table-condensed td').each(function() {
                    jq(this).removeClass('hasclass');
                });

                jq('.datepicker-days .table-condensed td').each(function() {
                    var cellText = jq(this).text(); 

                    for (var i = 0; i < teacherDays.length; i++) {
                        if (teacherDays[i] == cellText) {
                            jq(this).not('.disabled').addClass('hasclass');
                        }
                    }
                });
            }
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}

function classesByHour(year, month) {
    hoursDays = [];
    
    jq.ajax({
        type: 'POST',         
        url: apfajax.ajaxurl,
        data: {
            action: 'classesByHour',
            month: month,
        },
        success: function(data, textStatus, XMLHttpRequest) {       
            if(data != ''){
                var arr = jq.parseJSON(data);

                jq.each(arr, function(index, value) {
                    hoursDays.push(value); // add this date to the freeDays array
                });
            };

            jq(".loader").fadeOut(500);

            jq('.datepicker-byhour div#choosePicker').datepicker({
                startDate: today,
                endDate: endDate,
            }).on('changeDate', function(e){
                jq('#chooseDate').val(e.format('yyyy-mm-dd'));
                jq('form.chooseHours').fadeIn(2000);
                jq(".loader").show();
                jq('.checkbox input[type=checkbox]').prop('disabled', false).prop('checked', false);

                month = jq('.datepicker-days thead th.datepicker-switch').text();
                month = month.substring(0,month.length - 5);
                year = nowDate.getFullYear();
                classesByHour(year, month);

                jq.ajax({
                    type: 'POST',         
                    url: apfajax.ajaxurl,
                    data: {
                        action: 'get_all_hour',
                        date: jq('#chooseDate').val(),
                    },
                    success: function(data, textStatus, XMLHttpRequest) {                               
                        jq('.availableH').html(data);
                        jq(".loader").fadeOut(500);
                        setTimeout(function() {
                            jq(".loader").hide();
                        }, 500);
                        hoursDays = [];

                        jq('div.availableH td input[type="checkbox"]').click(function() {

                            //jq('#booking-class.step-one').slideUp(1000);

                            if(jq(this).is(':checked')){

                                jq('div.availableH td input[type="checkbox"]').not(this).prop('checked', false);  

                                var hour = '';
                                var date = '';

                                hour = jq(this).val();
                                date = jq('#chooseDate').val();

                                jq.ajax({
                                    type: 'POST',         
                                    url: apfajax.ajaxurl,
                                    data: {
                                        action: 'choose_classteacher',
                                        hour: hour,
                                        date: date,
                                    },
                                    success: function(data, textStatus, XMLHttpRequest) {       
                                        //jq('#teacher-info').html(data);
                                        var arr = jq.parseJSON(data);  
                                        var dataTable = jq('#selected-hours').dataTable();

                                        dataTable.fnClearTable();

                                        jq.each( arr['teacher'], function( i, val ) {
                                            dataTable.fnAddData([
                                                val['name'],
                                                val['image'],
                                                val['description'],
                                                val['action'],
                                            ]);

                                            var itemsNum = sessionStorage.length - 1;
                                            var i = 0;

                                            for (i; i <= itemsNum; i++) {
                                                var ID = sessionStorage.key(i);
                                                var sameID = ID.split("_");
                                                console.log(sameID[1] + '_' + sameID[2]);

                                                jq("a:regex(id, .*"+sameID[1]+"_"+sameID[2]+".*)").addClass('disabled');
                                                jq('a#'+ID).removeClass("disabled");

                                                if( jq('a#'+ID).hasClass("addTeacher") ){
                                                    jq('a#'+ID).removeClass("addTeacher").addClass("removeTeacher").text("Quitar clase");
                                                }
                                                // jq('a#'+ID).addClass('disabled');
                                            };
                                        });

                                        jq('#selected-hours td').each(function() {
                                            jq(this).addClass('text-center');
                                        });

                                        jq('.step-one #dayhourBox').slideDown(1000);
                                        jq('.step-one span.date').html(date);
                                        jq('.step-one span.hour').html(hour);

                                    },
                                    error: function(MLHttpRequest, textStatus, errorThrown) {
                                        alert(errorThrown);
                                    }
                                });
                            }
                        });
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            });
    
            if(data != ''){
                jq('.datepicker-days .table-condensed td').each(function() {
                    jq(this).removeClass('hasclass');
                });

                jq('.datepicker-days .table-condensed td').each(function() {
                    var cellText = jq(this).text(); 

                    if(jq(this).hasClass('new')){
                        jq(this).addClass('disabled');
                    }

                    for (var i = 0; i < hoursDays.length; i++) {
                        if (hoursDays[i] == cellText) {
                            jq(this).not('.disabled').addClass('hasclass');
                        }
                    }
                });

                jq('.datepicker-days .table-condensed td').each(function() {
                    jq(this).not('.hasclass').addClass('disabled');
                });
            }else{
                jq('.datepicker-days .table-condensed td').each(function() {
                    jq(this).not('.hasclass').addClass('disabled');
                });
            }
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}
 
function highlightDays(date) {
    for (var i = 0; i < freeDays.length; i++) {
        if (freeDays[i] == date.getDate()) {
            return { classes: 'hasclass' };
        }
    }
 
    return { classes: '' };
}

function remove_accent(str){
    var charMap = {
        Á:'A',É:'E',Í:'I',Ó:'O',Ú:'U',Ñ:'N',
        á:'a',é:'e',í:'i',ó:'o',ú:'u',ñ:'n',
    };

    var str_array = str.split('');

    for( var i = 0, len = str_array.length; i < len; i++ ) {
        str_array[ i ] = charMap[ str_array[ i ] ] || str_array[ i ];
    };

    return str_array.join('');
}

function centerModal() {
    jq(this).css('display', 'block');
    var dialog = jq(this).find(".modal-dialog");
    var offset = (jq(window).height() - dialog.height()) / 2;
    // Center modal vertically in window
    dialog.css("margin-top", offset);
}

function changeDesc( id, status ) {
   for (var i in getClassStudent) {
     if (getClassStudent[i].id == id) {
        jq(".checkbox input[value='"+getClassStudent[i][id].start_class+"']").prop("disabled", false).prop("checked", false);
        break; //Stop this loop, we found it!
     }
   }
}

jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}