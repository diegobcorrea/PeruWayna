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
					<?php include( TEMPLATEPATH . '/templates-student/student-menu.php'); ?>
				</div>
			</div>
		</div>

		<div id="booking-byhour" class="row step-one">
			<div class="header-message">
				<div class="title-tiny color gray text-center add-bottom">Seleccionar mis días y horarios de clases</br/><small><em>Select my class schedule</em></small></div>
				<p class="text-center">Por favor considere reservar sus clases con anticipación con el fin de asegurar disponibilidad en el horario que esta buscando.<br/>
					Tener en cuenta que los horarios populares se pueden llenar rápiradamente.</p>
			</div>

			<script type="text/javascript">
		        classesByHour();
		    </script>

			<div class="col-md-12 add-bottom">
				<div class="col-md-offset-1 col-md-10 add-bottom">
					<div class="col-md-4">
						<img src="<?php echo get_template_directory_uri(); ?>/images/img-instructions.jpg" alt="Instrucciones/Instructions" class="instructions-img">
					</div>
					<div class="col-md-8">
						<ul class="list-number">
							<li>Seleccione un día en el calendario<br/><em>Select a day from the calendar</em></li>
							<li>Seleccione sus horarios preferidos entre las horas de clase disponibles<br/><em>Select your preferred schedules among the available hours of classes</em></li>
							<li>Cuando termines de seleccionar todos los horarios en los que deseas tener clase, haz click en "Continuar"<br/><em>When you're done selecting all the schedules when you want to have classes click on "Continuar"</em></li>
						</ul>
					</div>
				</div>
				<div class="col-md-offset-1 col-md-10">
					<div class="datepicker-byhour">
						<div id="choosePicker"></div>
						<div class="loader"></div>
					</div>
					<form class="chooseHours" style="height: 243px; border: 1px solid #ccc; padding: 10px; width: 575px;">
						<div class="loader"></div>
						<div class="availableH"></div>
						<input type="hidden" id="chooseDate" name="chooseDate">
						<input type="hidden" id="daySelected" name="daySelected">
					</form>
				</div>
				<div class="col-md-offset-1 col-md-10 text-center">
					<div class="legendColor" style="display: inline-block; float: none">
						<div class="active"><span></span>Selecció actual</div>
						<div class="oneclass"><span></span>Días con horarios disponibles</div>
						<div class="hasclass"><span></span>Días donde seleccionaste al menos un horario de clases</div>
					</div>
				</div>
			</div>

			<div id="validateClasses" class="col-md-12 text-center add-bottom" style="display: none"><a href="#" id="validateClassesBtn" class="btn btn-secundary btn-sm">Continuar</a></div>
		</div>

		<div id="booking-class" class="row step-two">
			<div class="header-message">
				<div class="title-tiny color gray text-center">Confirmar mi selección de clases
					</br/><small><em>Confirm my classes selection</em></small>
				</div>
			</div>

			<div class="col-md-offset-1 col-md-10 text-center">
				<p>La lista a continuación muestra el detalle de las clases que has seleccionado hasta el momento<br/>
					<em>The list below displays the details of classes you have selected until now</em></p>
			</div>
			<div class="col-md-offset-1 col-md-10">
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

				<div class="col-md-12 add-bottom">
		        	<a href="#" id="backStepOne" class="btn btn-secundary btn-sm pull-right">Añadir más clases</a>
		       	</div>

		        <div class="col-md-12 add-bottom">
		        	<p><strong>Por favor recuerda:</strong><br/>
						Si alguna vez deseas cancelar una de tus clases reservadas puedes hacerlo hasta con 48 horas de anticipación y podrás recuperar tu clase posteriormente. Las clases canceladas con menos de 48 horas de anticipación lamentablemente serán consideradas como clases perdidas y no podrás recuperarlas.
		        	</p>
		        	<p><strong>Please remember:</strong><br/>
						If you ever decide to cancel one of your reserved classes, you will be able to do it up to 48 hours before your class is to begin. Unfortunately classes cancelled with 48 hours your class is to begin won't be subject to refund or postponement.
		        	</p>
		        </div>
	
				<div class="col-md-12 text-center add-bottom">
		        	<a href="#" id="confirm-classes" class="btn btn-secundary btn-sm" data-teacher="'<?php echo $id_teacher; ?>">Finalizar / Finish</a>
		        </div>
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