// AJAX Functions
var jq = jQuery;

var getClassStudent = [];
var returnClass = [];

jq(document).ready(function() {

	jq('#submitTeacher').click(function(e){
		e.preventDefault();

        if (jq("#AddTeacherForm").valid()) {
            jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'add_teacher',
				    name: jq('#inputName').val(),
				    lastname: jq('#inputLastname').val(),
				    country : jq('#inputCountry').val(),
				    birthday : jq('#inputBirthday').val(),
				    picture : jq('#inputPicture').val(),
				    description : jq('#inputDescription').val(),
				    email1 : jq('#inputPersEmail').val(),
				    email2 : jq('#inputCorpEmail').val(),
				    password : jq('#inputPassword').val(),
				    skype : jq('#inputSkype').val(),
				},
				success: function(data, textStatus, XMLHttpRequest) {
					jq(".newTeacher").text( jq('#inputName').val() + ' ' + jq('#inputLastname').val() );
				   
				   	jq('#SuccessModal').on('show.bs.modal', centerModal);
					jq('#SuccessModal').modal();

					jq("#AddTeacherForm")[0].reset();
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
        } else {

        }

	});

	jq('#registerStep').click( function(e) {
        e.preventDefault();

        if ( jq("#registerStudent").valid() ) {
        	jq('.secondstep').fadeOut(800);

        	if(jq('#cb-profesional').is(":checked")){
        		var moti_one = jq('#cb-profesional').val();
        	}else{
        		var moti_one = '';
        	}
        	if(jq('#cb-personal').is(":checked")){
        		var moti_two = jq('#cb-personal').val();
        	}else{
        		var moti_two = '';
        	}
        	if(jq('#cb-trip').is(":checked")){
        		var moti_three = jq('#cb-trip').val();
        	}else{
        		var moti_three = '';
        	}
        	if(jq('#cb-other').is(":checked")){
        		var moti_four = jq('#cb-other').val();
        	}else{
        		var moti_four = '';
        	}
        	if(jq('#cb-newsletter').is(":checked")){
        		var newsletter = jq('#cb-newsletter').val();
        	}else{
        		var newsletter = 0;
        	}

            jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'add_student',
				    name: jq('#inputName').val(),
				    lastname: jq('#inputLastname').val(),
				    email : jq('#inputMail').val(),
				    skype : jq('#inputSkype').val(),
				    country : jq('#inputCountry').val(),
				    city : jq('#inputCity').val(),
				    birthday : jq('#inputBirthday').val(),
				    lang: jq('#inputNativeLanguage').val(),
				    otherlang: jq('#inputOtherLanguage').val(),
				    ocupation : jq('#inputWork').val(),
				    moti_one: moti_one,
				    moti_two: moti_two,
				    moti_three: moti_three,
				    moti_four: moti_four,
				    newsletter: newsletter,
				    password: jq('#inputPassword').val(),
				    picture: jq('#inputPicture').val(),
				},
				success: function(data, textStatus, XMLHttpRequest) {		
					jq('#thankMessage').show();
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
        } else {

        }

	});

	jq('.chooseHours .checkbox input[type=checkbox]').click( function() {
        if(jq(this).is(':checked')){
            jq(this).prop('disabled', true);

            jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'add_teacher_hour',
				    date: jq('#chooseDate').val(),
				    hour: jq(this).val(),
				    teacher: jq('#id_teacher').val(),
				},
				success: function(data, textStatus, XMLHttpRequest) {		
					// console.log(data);
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
        }
    });

    // TEACHER PANEL - CLASSES
    jq('a.class-proccess').click( function(e){
    	e.preventDefault();
    	
    	var id_student = '';
    	var id_class = '';

    	id_class = jq(this).attr('data-idclass');
    	id_student = jq(this).attr('data-student');

    	if(id_student == 0){
    		jq('td.available[data-idclass="'+id_class+'"]').text('SUSPENDIDA SIN ALUMNO').addClass('suspend').removeClass('available');
    		jq('a#suspendClass[data-idclass="'+id_class+'"]').addClass('disabled');

    		jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'teacher_suspend_class',
				    status: 'SUSPENDIDA SIN ALUMNO',
				    id_class: id_class,
				    id_student: id_student,
				    teacher: id_teacher,
				},
				success: function(data, textStatus, XMLHttpRequest) {		
					// console.log(data);
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
    	}else{
    		jq('td.available[data-idclass="'+id_class+'"]').text('SUSPENDIDA').addClass('suspend').removeClass('available');
    		jq('td.confirm[data-idclass="'+id_class+'"]').text('SUSPENDIDA').addClass('suspend').removeClass('confirm');
    		jq('a#suspendClass[data-idclass="'+id_class+'"]').addClass('disabled');

    		jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'teacher_suspend_class',
				    status: 'SUSPENDIDA',
				    id_class: id_class,
				    id_student: id_student,
				    id_teacher: id_teacher,
				},
				success: function(data, textStatus, XMLHttpRequest) {		
					// console.log(data);
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
    	}

    	jq('#myModal').modal('hide');

    });

	jq('#submitWorkedtime').click( function(e){
		e.preventDefault();

		var btn = jq(this);

		btn.val('Cargando..');

		var startDate = jq('#DateStart').val();
		var endDate = jq('#DateEnd').val();
		var idTeacher = jq('#TeacherID').val();

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'teacher_workedtime',
				startDate: startDate,
				endDate: endDate,
				idTeacher: idTeacher
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				var dataTable = jq('#mywork-teacher').dataTable();
				if(data == 'fail'){
					btn.val('Error..');

					setInterval(function() {
						btn.val('Consultar');
					}, 2500);
				}
				else{
					var arr = jq.parseJSON(data);

					dataTable.fnClearTable();

					jq.each(arr['day'], function(index, value) {
						dataTable.fnAddData([
					        value['id_class'],
					        value['date'],
					        value['start_class'],
					        value['end_class'],
					        value['status'],
					        value['student_name']
					    ]);
	                });

					jq('#mywork-teacher td').each(function() {
	                    jq(this).addClass('text-center');
	                });
	                jq('#mywork-teacher tr td:nth-child(5)').each(function() {
	                	if( jq(this).text() == 'COMPLETADA' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'ALUMNO FALTÓ' ){
	                		jq(this).addClass('miss');
	                	}
	                	else if( jq(this).text() == 'CANCELADA -' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'CANCELADA +' ){
	                		jq(this).addClass('cancel');
	                	}
	                });

	                jq('#workedTime').val(arr['timeworked']);
	                btn.val('Consultar');
                }
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq('#submitExpiredtime').click( function(e){
		e.preventDefault();

		var btn = jq(this);

		btn.val('Cargando..');

		var startDate = jq('#DateStart').val();
		var endDate = jq('#DateEnd').val();
		var idTeacher = jq('#TeacherID').val();

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'teacher_expiredtime',
				startDate: startDate,
				endDate: endDate,
				idTeacher: idTeacher
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				var dataTable = jq('#mywork-teacher').dataTable();
				if(data == 'fail'){
					btn.val('Error..');

					setInterval(function() {
						btn.val('Consultar');
					}, 2500);
				}
				else{
					var arr = jq.parseJSON(data);

					dataTable.fnClearTable();

					jq.each(arr['day'], function(index, value) {
						dataTable.fnAddData([
					        value['id_class'],
					        value['date'],
					        value['start_class'],
					        value['end_class'],
					        value['status'],
					        value['student_name']
					    ]);
	                });

					jq('#mywork-teacher td').each(function() {
	                    jq(this).addClass('text-center');
	                });
	                jq('#mywork-teacher tr td:nth-child(5)').each(function() {
	                	if( jq(this).text() == 'EXPIRADA' ){
	                		jq(this).addClass('miss');
	                	}
	                });

	                jq('#workedTime').val(arr['timeworked']);
	                btn.val('Consultar');
                }
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq('#submitChangeStatus').click( function(e){
		e.preventDefault();

		var id_class = jq('#inputIDclass').val();
		var status = jq('#inputChangeStatus').val();

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'teacher_updatestatus',
				id_class: id_class,
				status: status,
			    id_teacher: id_teacher,
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				if(data == true){
					jq('#updateStatusModal .modal-content').html('<div class="header-message"><div class="titlesmall color gray text-center">¡Estado actualizado!</div><div class="h5 color gray text-center add-bottom">La página se actualizará en <span id="count">5</span> segundos..</div></div>');
					jq('#updateStatusModal').on('show.bs.modal', centerModal);
					jq('#updateStatusModal').modal();

					var counter = 5;

					setInterval(function() {
						counter--;
						if (counter >= 0) {
							span = document.getElementById("count");
							span.innerHTML = counter;
						}
						// Display 'counter' wherever you want to display it.
						if (counter === 0) {
							clearInterval(counter);
							location.reload();
						}
					}, 1000);
					
				}else{
					jq('#updateStatusModal .modal-content').html('<div class="header-message"><div class="titlesmall color gray text-center">¡La clase no se actualizó!</div><div class="h5 color gray text-center add-bottom">La clase que quiere actualizar no se puede modificar.</div></div>');
					jq('#updateStatusModal').on('show.bs.modal', centerModal);
					jq('#updateStatusModal').modal();
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq('#submitGetStudent').click( function(e){
		e.preventDefault();

		var id_student = jq('#inputIDstudent').val();

		console.log(id_teacher);

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'teacher_getstudent',
				id_student: id_student,
				id_teacher: id_teacher
			},
			success: function(data, textStatus, XMLHttpRequest) {
				if(data != 'fail'){		
					var arr = jq.parseJSON(data);

					jq('#student_id').val(arr['id']);
					jq('#student_name').val(arr['name']);
					jq('#student_lastname').val(arr['lastname']);
					jq('#student_skype').val(arr['skype']);
					jq('#student_mail').val(arr['email']);
					jq('#student_country').val(arr['country']);
					jq('#student_city').val(arr['city']);
					jq('#student_birthday').val(arr['birthday']);
					jq('#student_language').val(arr['language']);
					jq('#student_olanguage').val(arr['olanguage']);
					jq('#student_work').val(arr['work']);
					jq('#student_level option[value="'+arr['level']+'"]').attr('selected','selected');
					jq('#student_annotation').val(arr['annotation']);

					jq('#submitChangeStudent').removeClass('disabled');
				}
				else {
					jq('#errorStudent').on('show.bs.modal', centerModal);
					jq('#errorStudent').modal();
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq('#submitChangeStudent').click( function(e){
		e.preventDefault();

		var id_student = jq('#student_id').val();
		var level_student = jq('#student_level').val();
		var annotation_student = jq('#student_annotation').val();

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'teacher_savestudent',
				id_student: id_student,
				level_student: level_student,
				annotation_student: annotation_student,
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				if(data == true){
					jq('#updateStatusStudent .modal-content').html('<div class="header-message"><div class="titlesmall color gray text-center">Estudiante actualizado!</div><div class="h5 color gray text-center add-bottom">Los datos del estudiante se actualizaron correctamente.</div></div>');
					jq('#updateStatusStudent').on('show.bs.modal', centerModal);
					jq('#updateStatusStudent').modal();
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

    // STUDENT PANEL - CLASSES
    jq('a.class-cancelclass').click( function(e){
    	e.preventDefault();
    	
    	var id_class = '';
    	var dCancel = '';

    	id_class = jq(this).attr('data-idclass');
    	dCancel = jq(this).attr('data-cancel');

    	if(dCancel == 'plus'){
    		jq('td.confirm[data-idclass="'+id_class+'"]').text('CANCELADA +').addClass('suspend').removeClass('confirm');
    		jq('a#suspendClass[data-idclass="'+id_class+'"]').addClass('disabled');

    		jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'student_suspend_class',
				    status: 'CANCELADA +',
				    id_class: id_class,
				    id_student: id_student,
				},
				success: function(data, textStatus, XMLHttpRequest) {		
					jq('#InfoModal').modal('hide');
					jq('#SuccessModal').on('show.bs.modal', centerModal);					
					jq('#SuccessModal').modal();
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
		}else if(dCancel == 'minus'){
			jq('td.confirm[data-idclass="'+id_class+'"]').text('CANCELADA -').addClass('suspend').removeClass('confirm');
    		jq('a#suspendClass[data-idclass="'+id_class+'"]').addClass('disabled');

    		jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'student_suspend_class',
				    status: 'CANCELADA -',
				    id_class: id_class,
				    id_student: id_student,
				},
				success: function(data, textStatus, XMLHttpRequest) {		
					jq('#InfoModal').modal('hide');
					jq('#SuccessModal').on('show.bs.modal', centerModal);
					jq('#SuccessModal').modal();
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
    	}
    });

	jq('a#select-teacher').click( function(e){
    	e.preventDefault();

    	jq('#booking-class.step-one').slideUp(1000);
    	
    	var id_teacher = '';
    	

    	id_teacher = jq(this).attr('data-teacher');

    	jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'get_teacher_info',
			    id_teacher: id_teacher,
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				jq('#teacher-info').html(data);

				setInterval(function() {
					jq('#booking-class.step-two').slideDown(1000);
				}, 500);
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});

	});

	jq('a#finish-booking').click( function(e){
    	e.preventDefault();

    	jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'finish_booking',
			    id_student: jq(this).data('student'),
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				jq('#finishBookingModal').on('show.bs.modal', centerModal);
				jq('#finishBookingModal').modal();

				// console.log(data);
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});

	});

	jq('#teacher-seeHours').click( function(e){
    	e.preventDefault();

    	var btn = jq(this);

		btn.val('Cargando..');

    	var teacher = jq('#inputIDteacher').val();
    	var startDate = jq('#inputDateStart').val();
		var endDate = jq('#inputDateEnd').val();

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'admin_teacherHours',
				startDate: startDate,
				endDate: endDate,
				teacher: teacher
			},
			success: function(data, textStatus, XMLHttpRequest) {
				if(data == 'fail'){
					btn.val('Error..');

					setInterval(function() {
						btn.val('Consultar');
					}, 2500);
				}else{
					var arr = jq.parseJSON(data);
					var dataTable = jq('#teacher-seehours').dataTable();

					dataTable.fnClearTable();

					jq.each(arr['day'], function(index, value) {
						dataTable.fnAddData([
					        index,
					        value['date'],
					        value['start_class'],
					        value['end_class'],
					        value['teacher_name'],
					        value['student_name'],
					        value['status'],
					    ]);
	                });

					jq('#teacher-seehours td').each(function() {
	                    jq(this).addClass('text-center');
	                });
	                jq('#teacher-seehours tr td:nth-child(6)').each(function() {
	                	if( jq(this).text() == 'COMPLETADA' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'CONFIRMADA' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'DISPONIBLE' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'ALUMNO FALTÓ' ){
	                		jq(this).addClass('miss');
	                	}
	                	else if( jq(this).text() == 'SUSPENDIDA' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'SUSPENDIDA SIN ALUMNO' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'CANCELADA -' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'CANCELADA +' ){
	                		jq(this).addClass('cancel');
	                	}
	                });

					setInterval(function() {
			            jq('#table-hours').slideDown(1000);
			        }, 500);

	                jq('#cancelminus').val(arr['cancelminus']);
	                jq('#cancelplus').val(arr['cancelplus']);
	                jq('#suspend').val(arr['suspend']);
	                jq('#suspendwos').val(arr['suspendwos']);
	                jq('#nocomplete').val(arr['nocomplete']);
	                jq('#complete').val(arr['complete']);

	                btn.val('Consultar');
                }
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq('#student-seeHours').click( function(e){
    	e.preventDefault();

    	var btn = jq(this);

		btn.val('Cargando..');

    	var student = jq('#inputName').val();
    	var startDate = jq('#inputDateStart').val();
		var endDate = jq('#inputDateEnd').val();

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'admin_studentHours',
				startDate: startDate,
				endDate: endDate,
			    student: student,
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				if(data == 'fail'){
					btn.val('Error..');

					setInterval(function() {
						btn.val('Consultar');
					}, 2500);
				}else{
					var arr = jq.parseJSON(data);
					var dataTable = jq('#teacher-seehours').dataTable();

					dataTable.fnClearTable();

					jq.each(arr['day'], function(index, value) {
						dataTable.fnAddData([
					        index,
					        value['date'],
					        value['start_class'],
					        value['end_class'],
					        value['teacher_name'],
					        value['student_name'],
					        value['status'],
					    ]);
	                });

					jq('#teacher-seehours td').each(function() {
	                    jq(this).addClass('text-center');
	                });
	                jq('#teacher-seehours tr td:nth-child(6)').each(function() {
	                	if( jq(this).text() == 'COMPLETADA' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'CONFIRMADA' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'DISPONIBLE' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'ALUMNO FALTÓ' ){
	                		jq(this).addClass('miss');
	                	}
	                	else if( jq(this).text() == 'SUSPENDIDA' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'SUSPENDIDA SIN ALUMNO' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'CANCELADA -' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'CANCELADA +' ){
	                		jq(this).addClass('cancel');
	                	}
	                });

					setInterval(function() {
			            jq('#table-hours').slideDown(1000);
			        }, 500);

	                jq('#cancelminus').val(arr['cancelminus']);
	                jq('#cancelplus').val(arr['cancelplus']);
	                jq('#suspend').val(arr['suspend']);
	                jq('#confirm').val(arr['confirm']);
	                jq('#nocomplete').val(arr['nocomplete']);
	                jq('#complete').val(arr['complete']);

	                btn.val('Consultar');

	                // console.log(arr);
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq('#teacher-exportExcel').click( function(e){
    	e.preventDefault();

    	var teacher = jq('#inputIDteacher').val();
    	var startDate = jq('#inputDateStart').val();
		var endDate = jq('#inputDateEnd').val();

		document.location.href= url_rel + "/export-excel.php?type=teacher&id="+teacher+"&startDate="+startDate+"&endDate="+endDate;
	});

	jq('#student-exportExcel').click( function(e){
    	e.preventDefault();

    	var student = jq('#inputIDstudent').val();
    	var startDate = jq('#inputDateStart').val();
		var endDate = jq('#inputDateEnd').val();

		document.location.href= url_rel + "/export-excel.php?type=student&id="+student+"&startDate="+startDate+"&endDate="+endDate;
	});

	jq('#reservedClass-exportExcel').click( function(e){
    	e.preventDefault();
		document.location.href= url_rel + "/export-excel.php?type=reserved";
	});

	jq('#availableClass-exportExcel').click( function(e){
    	e.preventDefault();
		document.location.href= url_rel + "/export-excel.php?type=available";
	});

	jq('#allclasses-historic').click( function(e){
    	e.preventDefault();

    	var btn = jq(this);

		btn.val('Cargando..');

    	var startDate = jq('#inputDateStart').val();
		var endDate = jq('#inputDateEnd').val();

		jq.ajax({
			type: 'GET',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'admin_allclassesHours',
				startDate: startDate,
				endDate: endDate,
			},
			success: function(data, textStatus, XMLHttpRequest) {
				console.log(data);
				

				if(data == 'fail'){
					btn.val('Error..');

					setInterval(function() {
						btn.val('Consultar');
					}, 2500);
				}
				else{
					var arr = jq.parseJSON(data);
					var dataTable = jq('#allclasses').dataTable();

					dataTable.fnClearTable();

					jq.each(arr['day'], function(index, value) {
						dataTable.fnAddData([
					        value['index'],
					        value['date'],
					        value['start_class'],
					        value['end_class'],
					        value['teacher_name'],
					        value['student_name'],
					        value['status'],
					    ]);
	                });

					jq('#allclasses td').each(function() {
	                    jq(this).addClass('text-center');
	                });
	                jq('#allclasses tr td:nth-child(6)').each(function() {
	                	if( jq(this).text() == 'COMPLETADA' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'CONFIRMADA' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'DISPONIBLE' ){
	                		jq(this).addClass('confirm');
	                	}
	                	else if( jq(this).text() == 'ALUMNO FALTÓ' ){
	                		jq(this).addClass('miss');
	                	}
	                	else if( jq(this).text() == 'EXPIRADA' ){
	                		jq(this).addClass('miss');
	                	}
	                	else if( jq(this).text() == 'SUSPENDIDA' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'SUSPENDIDA SIN ALUMNO' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'CANCELADA -' ){
	                		jq(this).addClass('cancel');
	                	}
	                	else if( jq(this).text() == 'CANCELADA +' ){
	                		jq(this).addClass('cancel');
	                	}
	                });

					setInterval(function() {
			            jq('#table-hours').slideDown(1000);
			        }, 500);

	                jq('#cancelminus').val(arr['cancelminus']);
	                jq('#cancelplus').val(arr['cancelplus']);
	                jq('#suspend').val(arr['suspend']);
	                jq('#suspendwos').val(arr['suspendwos']);
	                jq('#nocomplete').val(arr['nocomplete']);
	                jq('#complete').val(arr['complete']);

	                btn.val('Consultar');
                }
                
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq('#seeFreeHours').click( function(e){
    	e.preventDefault();

    	var startDate = jq('#inputDateStart').val();
		var endDate = jq('#inputDateEnd').val();

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'admin_seeFreeHours',
				startDate: startDate,
				endDate: endDate,
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				var arr = jq.parseJSON(data);
				var dataTable = jq('#table-seeFreehours').dataTable();

				dataTable.fnClearTable();

				jq.each(arr['day'], function(index, value) {
					dataTable.fnAddData([
				        index,
				        value['date'],
				        value['student_name'],
				        value['freetime']
				    ]);
                });

				jq('#table-seeFreehours td').each(function() {
                    jq(this).addClass('text-center');
                });

                // console.log(arr);
                
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq('#giveFreeHours').click( function(e){
    	e.preventDefault();

    	var idstudent = jq('#GiveHoursForm #inputIDstudent').val();
		var minutes = jq('#GiveHoursForm #inputMinutes').val();

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'admin_giveFreeHours',
				idstudent: idstudent,
				minutes: minutes,
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				if(data == 'true'){
					jq('#freehourStatus .success').show();
					jq('#freehourStatus .warning').hide();
					jq('#freehourStatus').on('show.bs.modal', centerModal);
					jq('#freehourStatus').modal();

					jq('#GiveHoursForm #inputName').val('');
					jq('#GiveHoursForm #inputLastname').val('');
					jq('#GiveHoursForm #inputMinutes').val('');
				}else{
					jq('#freehourStatus .warning').show();
					jq('#freehourStatus .success').hide();
					jq('#freehourStatus').on('show.bs.modal', centerModal);
					jq('#freehourStatus').modal();
				}

                // console.log(data);
                
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq('a.recoverPassword').click( function(e){
    	e.preventDefault();

        jq('#RecoverPassword').on('show.bs.modal', centerModal);
		jq('#RecoverPassword').modal();

		jq('#recoverPass .changePass').click( function(e){
    		e.preventDefault();

    		if (jq("#recoverPass").valid()) {

	    		var email = jq('#recoverPass #student_email').val();

	    		jq.ajax({
					type: 'POST',         
					url: apfajax.ajaxurl,
					data: {
					    action: 'recover_password',
						email: email,
					},
					success: function(data, textStatus, XMLHttpRequest) {		
						jq('#completeForm').slideUp();
						jq('#passSend').slideDown(500);
		                // console.log(data);
		                
						jq('#sendPassOk').click( function(e){
    						e.preventDefault();

		                	jq('#RecoverPassword').modal('hide');

		                	setInterval(function() {
								jq('#completeForm').show();
								jq('#passSend').hide();
					        }, 2000);
				            
				        });
					},
					error: function(MLHttpRequest, textStatus, errorThrown) {
					    alert(errorThrown);
					}
				});

    		}

    	});

    });

    jq('#recoverPass').validate({
        rules: {
            student_email: {
                required: true,
                email: true,
                remote: url_rel + '/templates-admin/validate/validate-student.php?type=recoverPass',
            },
        },
        messages: {
            student_email: {
                required: "Por favor ingresa un email.",
                remote: 'Email no pertenece a ningún usuario.'
            },       
        }
    });

    jq('#updateProfile').click( function(e){
    	e.preventDefault();

    	if(jq('#cb-profesional').is(":checked")){
    		var moti_one = jq('#cb-profesional').val();
    	}else{
    		var moti_one = '';
    	}
    	if(jq('#cb-personal').is(":checked")){
    		var moti_two = jq('#cb-personal').val();
    	}else{
    		var moti_two = '';
    	}
    	if(jq('#cb-trip').is(":checked")){
    		var moti_three = jq('#cb-trip').val();
    	}else{
    		var moti_three = '';
    	}
    	if(jq('#cb-other').is(":checked")){
    		var moti_four = jq('#cb-other').val();
    	}else{
    		var moti_four = '';
    	}
    	if(jq('#cb-newsletter').is(":checked")){
    		var newsletter = jq('#cb-newsletter').val();
    	}else{
    		var newsletter = 0;
    	}
    	
    	if(jq("#inputOldPassword").val() != '')
    	{
    		if (jq("#inputOldPassword").valid() == true ) 
	    	{
		        jq.ajax({
					type: 'POST',         
					url: apfajax.ajaxurl,
					data: {
					    action: 'updateProfileStudent',
						name: jq('#inputName').val(),
						lastname: jq('#inputLastname').val(),
						lastname: jq('#inputLastname').val(),
						email: jq('#inputMail').val(),
						skype: jq('#inputSkype').val(),
						country: jq('#inputCountry').val(),
						city: jq('#inputCity').val(),
						birthday: jq('#inputBirthday').val(),
						language: jq('#inputNativeLanguage').val(),
						olanguage: jq('#inputOtherLanguage').val(),
						work: jq('#inputWork').val(),
						moti_one: moti_one,
					    moti_two: moti_two,
					    moti_three: moti_three,
					    moti_four: moti_four,
					    newsletter: newsletter,
						picture: jq('#inputPicture').val(),
						password: jq('#inputPassword').val(),
					},
					success: function(data, textStatus, XMLHttpRequest) {		
						jq('#studentUpdateModalPassword').on('show.bs.modal', centerModal);
						jq('#studentUpdateModalPassword').modal();

						jq("#inputOldPassword").val('').removeClass('valid');
						jq('#inputPassword').val('').removeClass('valid').prop('disabled', true);
						jq('#inputRePassword').val('').removeClass('valid').prop('disabled', true);
		                
		                setInterval(function() {
							window.location.replace(close_session);
				        }, 5000);
					},
					error: function(MLHttpRequest, textStatus, errorThrown) {
					    alert(errorThrown);
					}
				});
		    } 
    	}
    	else {
    		jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'updateProfileStudent',
					name: jq('#inputName').val(),
					lastname: jq('#inputLastname').val(),
					lastname: jq('#inputLastname').val(),
					email: jq('#inputMail').val(),
					skype: jq('#inputSkype').val(),
					country: jq('#inputCountry').val(),
					city: jq('#inputCity').val(),
					birthday: jq('#inputBirthday').val(),
					language: jq('#inputNativeLanguage').val(),
					olanguage: jq('#inputOtherLanguage').val(),
					work: jq('#inputWork').val(),
					moti_one: moti_one,
				    moti_two: moti_two,
				    moti_three: moti_three,
				    moti_four: moti_four,
				    newsletter: newsletter,
					picture: jq('#inputPicture').val(),
					password: jq('#inputPassword').val(),
				},
				success: function(data, textStatus, XMLHttpRequest) {		
					jq('#studentUpdateModal').on('show.bs.modal', centerModal);
					jq('#studentUpdateModal').modal();
	                
	                setInterval(function() {
						jq('#studentUpdateModal').modal('hide');
						jq('#studentUpdateModal').hide();
			        }, 6000);
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
    	}

    });

	jq('a#closeSession').click( function(e){
    	e.preventDefault();

    	window.location.replace(close_session);
    });

	jq('a.recoverTeacherPass').click( function(e){
    	e.preventDefault();

        jq('#PasswordTeacher').on('show.bs.modal', centerModal);
		jq('#PasswordTeacher').modal();

		jq('#recoverPass .changePass').click( function(e){
    		e.preventDefault();

    		var email = jq('#recoverPass #teacher_email').val();

    		jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'recover_tpassword',
					email: email,
				},
				success: function(data, textStatus, XMLHttpRequest) {		
					jq('#completeForm').slideUp();
					jq('#passSend').slideDown(500);
	                
	                setTimeout(function() {
	                	jq('#passSend').modal('hide');
			            jq('#completeForm').show();
						jq('#passSend').hide();
			        }, 3500);
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
    	});
    });

	jq('#updateProfileTeacher').click( function(e){
    	e.preventDefault();

    	if(jq("#inputOldPassword").val() != '')
    	{
    		if (jq("#inputOldPassword").valid() == true ) 
	    	{
	    		jq.ajax({
					type: 'POST',         
					url: apfajax.ajaxurl,
					data: {
					    action: 'updateProfileTeacher',
						name: jq('#inputName').val(),
						lastname: jq('#inputLastname').val(),
						email: jq('#inputMail').val(),
						ecorp: jq('#inputMailCorp').val(),
						skype: jq('#inputSkype').val(),
						country: jq('#inputCountry').val(),
						birthday: jq('#inputBirthday').val(),
						description: jq('#inputDescription').val(),
						picture: jq('#inputPicture').val(),
						password: jq('#inputPassword').val(),
					},
					success: function(data, textStatus, XMLHttpRequest) {		
						jq('#teacherUpdateModalPassword').on('show.bs.modal', centerModal);
						jq('#teacherUpdateModalPassword').modal();
		                
		                jq("#inputOldPassword").val('').removeClass('valid');
						jq('#inputPassword').val('').removeClass('valid').prop('disabled', true);
						jq('#inputRePassword').val('').removeClass('valid').prop('disabled', true);
		                
		                setInterval(function() {
							window.location.replace(close_teacherSession);
				        }, 5000);
					},
					error: function(MLHttpRequest, textStatus, errorThrown) {
					    alert(errorThrown);
					}
				});
	    	}
	    }
    	else 
    	{
    		jq.ajax({
				type: 'POST',         
				url: apfajax.ajaxurl,
				data: {
				    action: 'updateProfileTeacher',
					name: jq('#inputName').val(),
					lastname: jq('#inputLastname').val(),
					email: jq('#inputMail').val(),
					ecorp: jq('#inputMailCorp').val(),
					skype: jq('#inputSkype').val(),
					country: jq('#inputCountry').val(),
					birthday: jq('#inputBirthday').val(),
					description: jq('#inputDescription').val(),
					picture: jq('#inputPicture').val(),
					password: jq('#inputPassword').val(),
				},
				success: function(data, textStatus, XMLHttpRequest) {		
					jq('#teacherUpdateModal').on('show.bs.modal', centerModal);
					jq('#teacherUpdateModal').modal();
	                
	                setTimeout(function() {
						jq('#teacherUpdateModal').modal('hide');
						jq('#teacherUpdateModal').hide();
			        }, 6000);
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
				    alert(errorThrown);
				}
			});
    	}
    });

	jq("a#validateClassesBtn").click(function(e){
		e.preventDefault();

		jq("#booking-byhour.step-one").slideUp(1000);

		var toJSON = JSON.stringify(sessionStorage);

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'validateClasses',
				classes: toJSON
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				var arr = jq.parseJSON(data);
				console.log(arr);
                var dataTable = jq('#selected-teachers').dataTable();

                dataTable.fnClearTable();

                jq.each( arr['data'], function( i, val ) {
                    dataTable.fnAddData([
                        val['day_class'],
                        val['start_class'],
                        val['end_class'],
                        val['teacher_name'],
                        val['action'],
                    ]);
                });

                if(sessionStorage.length > 1){
                    jq("a#confirm-classes").removeClass("disabled");
                }

                dataTable.fnDraw();
                setTimeout(function() {
                	jq(".dataTables_scrollHeadInner, table.dataTable").css({'width':'100%'});
                }, 50);
                
                jq('#selected-teachers td').each(function() {
                    jq(this).addClass('text-center');
                });

                setTimeout(function() {
					jq("#booking-class.step-two").slideDown(1000);
		        }, 500);
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	jq("a#backStepOne").click(function(e){
		e.preventDefault();

		jq("#booking-class.step-two").hide();

		checkClassesStorage();

		setTimeout(function() {
			jq("#booking-byhour.step-one").slideDown(1000);
		}, 500);
	});

	jq("#addTopic").click(function(e){
		e.preventDefault();

		var title = jq("#inputTitle");
		var topic = jq("#inputTopic");

		jq.ajax({
			type: 'POST',         
			url: apfajax.ajaxurl,
			data: {
			    action: 'addTopic',
				title: title.val(),
				topic: topic.val()
			},
			success: function(data, textStatus, XMLHttpRequest) {		
				var arr = jq.parseJSON(data);
                var dataTable = jq('#teacher-topics').dataTable();

                dataTable.fnClearTable();

                jq.each( arr['topic'], function( i, val ) {
                    dataTable.fnAddData([
                    	val['id'],
                        val['title'],
                        val['topic'],
                        val['action'],
                    ]);
                });
                
                setTimeout(function() {
                	jq(".dataTables_scrollHeadInner, table.dataTable").css({'width':'100%'});
                }, 50);

                title.val('');
                topic.val('');
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
			    alert(errorThrown);
			}
		});
	});

	setInterval(function() {
		if (jq(".updateProfile #inputOldPassword").val() != '' && jq(".updateProfile #inputOldPassword").length < 1 ) 
		{
			jq(".updateProfile input#inputPassword").prop('disabled', true);
		    jq(".updateProfile input#inputRePassword").prop('disabled', true);
		}
		else if (jq(".updateProfile #inputOldPassword").hasClass('valid') ) 
		{
			jq(".updateProfile input#inputPassword").prop('disabled', false);
		    jq(".updateProfile input#inputRePassword").prop('disabled', false);
		}
		else
		{
			jq(".updateProfile input#inputPassword").prop('disabled', true);
		    jq(".updateProfile input#inputRePassword").prop('disabled', true);
		}
	}, 200);

});