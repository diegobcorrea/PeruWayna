<?php
/**
 * Template Name: Student Panel - Booking Hours
 */

get_header(); ?>

	<div class="container">
	<?php if ( $_COOKIE['student_online'] == 1 ) : ?>
		<?php $user = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE email_student = '".$_COOKIE['student_mail']."' AND password_student = '".$_COOKIE['student_password']."'", OBJECT ); ?>
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">
				Hola <?php echo $user->name_student; ?>!
				<img src="<?php echo get_template_directory_uri(); ?>/lib/utils/timthumb.php?src=<?php echo $user->photo_student; ?>&h=65&w=65" class="img-thumbnail">
				<!-- Single button -->
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						Menu Principal <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo get_site_url() ?>/sistema-de-reservas/">Inicio</a></li>
						<li><a href="<?php echo get_site_url() ?>/sistema-de-reservas/mi-perfil?action=edit">Mi Perfil</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo get_site_url() ?>/sistema-de-reservas/cerrar-sesion">Cerrar Sesión</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div id="booking-class" class="row step-one">
			<div class="header-message">
				<div class="title-tiny color gray text-center">PASO 1: Seleccionar mis días y horarios de clases</div>
				<p class="text-center">Por favor considere reservar sus clases con anticipación con el fin de asegurar disponibilidad en el horario que esta buscando.<br/>
					Tener en cuenta que los horarios populares se pueden llenar rápiradamente.</p>
			</div>

			<script type="text/javascript">
		        classesByHour();
		    </script>

			<div class="col-md-12 add-bottom">
				<div class="col-md-4">
					<div class="h4 add-bottom"><strong>Instrucciones</strong></div>
					<ul class="list-number">
						<li>Seleccione un día en el calendario.</li>
						<li>Seleccione el horario de su preferencia.</li>
					</ul>
				</div>
				<div class="col-md-8">
					<div class="datepicker-byhour"><div id="choosePicker"></div></div>
					<form class="chooseHours" style="height: 243px; border: 1px solid #ccc; padding: 10px;">
						<div class="loader"></div>
						<div class="availableH"></div>
						<input type="hidden" id="chooseDate" name="chooseDate">
					</form>
					<div class="legendColor">
						<div class="active"><span></span>Seleccionado</div>
						<div class="oneclass"><span></span>Días con al menos un horario de clases</div>
						<div class="noclass"><span></span>Días sin ningún horario de clases</div>
					</div>
				</div>
			</div>

			<div id="dayhourBox" class="col-md-12 text-center add-bottom" style="display: none"><strong>Día seleccionado:</strong> <span class="date"></span>. <strong>Horario seleccionado:</strong> <span class="hour"></span></div>

			<div id="teacher-info" class="col-md-8 add-bottom col-md-push-2">
				<script type="text/javascript">
		        jq(document).ready(function() {
		            jq('#selected-hours').dataTable( {
		                "scrollY":        "350px",
		                "scrollCollapse": true,
		                "paging":         false,
		                "order": [ [0,"asc"],[1,"asc"] ],
		                "language": {
							"zeroRecords": "Sigue las instrucciones en la parte superior para mostrar resultados"
						}
		            } );

		            var body_height = parseInt(jq('#selected-hours_wrapper .dataTables_scrollBody').height());

		            jq('#selected-hours_wrapper .dataTables_scrollBody').height(body_height + 30);
		        } );
		        </script>
		        <table id="selected-hours" class="table table-striped table-bordered">
		            <thead>
		                <tr>
		                    <th class="text-center" style="width: 150px">Profesor</th>
		                    <th class="text-center" style="width: 120px">Foto</th>
		                    <th class="text-center" style="width: 227px">Descripción</th>
		                    <th class="text-center" style="width: 150px">Acción</th>
		                </tr>
		            </thead>
		            <tbody>
		            </tbody>
		        </table>
			</div>

			<div id="validateClasses" class="col-md-12 text-center add-bottom" style="display: none"><a href="#" id="validateClassesBtn" class="btn btn-secundary btn-sm">Confirmar clases seleccionadas</a></div>
		</div>

		<div id="booking-class" class="row step-two">
			<div class="header-message">
				<div class="title-tiny color gray text-center">PASO 2: ¿Desea agregar más clases?</div>
			</div>

			<div class="col-md-4 add-bottom text-center">
				<p class="h4"><strong>Si! Agregar más clases</strong></p>
				<a href="#" id="backStepOne" class="btn btn-secundary btn-sm">Volver al paso #1</a>
			</div>
			<div class="col-md-8 add-bottom">
				<p class="text-center"><strong class="h4">No,</strong><br/>
					Por favor revisar el detalle de<br/> sus clases y confirmar su reserva.</p>
				<script type="text/javascript">
		        jq(document).ready(function() {
		            jq('#selected-teachers').dataTable( {
		                "scrollY":        "200px",
		                "scrollCollapse": true,
		                "paging":         false,
		                "order": [ [0,"asc"],[1,"asc"] ],
		                "language": {
							"zeroRecords": "Sigue las instrucciones en la parte superior para mostrar resultados"
						}
		            } );

		            var body_height = parseInt(jq('#selected-teachers_wrapper .dataTables_scrollBody').height());

		            jq('#selected-teachers_wrapper .dataTables_scrollBody').height(body_height + 30);
		        } );
		        </script>
		        <table id="selected-teachers" class="table table-striped table-bordered">
		            <thead>
		                <tr>
		                    <th class="text-center" style="width: 150px">Día</th>
		                    <th class="text-center" style="width: 100px">Inicio</th>
		                    <th class="text-center" style="width: 100px">Fin</th>
		                    <th class="text-center" style="width: 150px">Profesor</th>
		                    <th class="text-center" style="width: 120px">Acción</th>
		                </tr>
		            </thead>
		            <tbody>
		            </tbody>
		        </table>

		        <a href="#" id="confirm-classes" class="btn btn-secundary btn-sm pull-right" data-teacher="'<?php echo $id_teacher; ?>">Confirmar mis clases</a>
		        <script type="text/javascript">
		        var jq = jQuery;

		        jq('#confirm-classes').click( function(e) {
		            e.preventDefault();

		            var id_student = <?php echo $user->id_student; ?>;

		            jq.ajax({
		                type: 'POST',         
		                url: apfajax.ajaxurl,
		                data: {
		                    action: 'save_class_byhour',
		                    classes: JSON.stringify(sessionStorage),
		                    id_student: id_student,
		                },
		                success: function(data, textStatus, XMLHttpRequest) {       
		                    console.log(data);
		                    window.location.replace('<?php echo get_site_url() . "/sistema-de-reservas/confirmas-clases/"; ?>');
		                    
		                },
		                error: function(MLHttpRequest, textStatus, errorThrown) {
		                    alert(errorThrown);
		                }
		            });
		        });
		        </script>
			</div>
		</div>

	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/sistema-de-reservas/'; ?>");
		</script>
	<?php endif; ?>
	</div>

<?php get_footer(); ?>