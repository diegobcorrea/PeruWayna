<?php
/**
 * Template Name: Teacher Panel - Clases
 */

get_header(); ?>

	<div class="container">
	<?php if ( $_COOKIE['teacher_online'] == 1 ) : ?>
		<?php $teacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE email_c_teacher = '".$_COOKIE['teacher_mail']."' AND password_teacher = '".$_COOKIE['teacher_password']."'", OBJECT ); ?>
		<div class="panel panel-teacher-primary text-right">
			<div class="panel-heading">
				Hola <?php echo $teacher->name_teacher; ?>!
				<img src="<?php echo get_template_directory_uri(); ?>/lib/utils/timthumb.php?src=<?php echo $teacher->photo_teacher; ?>&h=65&w=65" class="img-thumbnail">
				<!-- Single button -->
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						Menu Principal <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo get_site_url() . '/modulo-profesor/'; ?>">Agregar Disponibilidad</a></li>
						<li><a href="<?php echo get_site_url() . '/modulo-profesor/clases'; ?>">Mi programación de clases</a></li>
						<li><a href="<?php echo get_site_url() . '/modulo-profesor/horas-laboradas'; ?>">Mis horas laboradas</a></li>
						<li><a href="<?php echo get_site_url() . '/modulo-profesor/horas-expiradas'; ?>">Mis horas expiradas</a></li>
						<li><a href="<?php echo get_site_url() . '/modulo-profesor/mis-alumnos'; ?>">Mis alumnos</a></li>
						<li><a href="<?php echo get_site_url() . '/modulo-profesor/perfil'; ?>">Mi perfil</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo get_site_url() . '/modulo-profesor/logout?id=' . $teacher->id_teacher; ?>">Cerrar Sesión</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div id="teacher-details" class="row">
			<div class="col-md-12 add-bottom">
				<div class="h4 add-bottom"><strong>Detalle de mis próximas clases:</strong></div>
				<script type="text/javascript">
				jq(document).ready(function() {
				    jq('#myclasses-teacher').dataTable( {
				        "scrollY":        "507px",
				        "scrollCollapse": true,
				        "paging":         false,
				        "order": [ [0,"asc"], [1,"asc"], [2,"asc"] ],
				        "columnDefs": [ {
			                "targets": [ 0 ],
			                "visible": false,
			                "searchable": false
			            } ]
				    } );
				} );
				</script>
				<table id="myclasses-teacher" class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th class="text-center" style="width: 70px">Orden</th>
							<th class="text-center" style="width: 300px">Día</th>
							<th class="text-center" style="width: 100px">Desde</th>
							<th class="text-center" style="width: 100px">Hasta</th>
							<th class="text-center">Estado</th>
							<th class="text-center">Alumno</th>
							<th class="text-center">Acción</th>
						</tr>
					</thead>
					<tbody>
					<?php

					$h = "5";
				    $hm = $h * 60; 
				    $ms = $hm * 60;

					$now = date('Y-m-d',time()-($ms));
					$time = date('h:i A',time()-($ms));

					global $wpdb, $dias, $meses;
					$getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_teacher = $teacher->id_teacher AND date_class >= '$now' AND status NOT LIKE 'COMPLETADA' AND status NOT LIKE 'ALUMNO FALTÓ' ORDER BY date_class ASC", OBJECT );

					foreach ($getClasses as $key => $class) : 

						$date = explode("-", $class->date_class);
						$formatDate = $date[0].'-'.$date[1].'-'.$date[2] . $class->start_class;
						$date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] ); 

						$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
						$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

					    $today = date('Y-m-d h:i A',time()-($ms));

   						$dteStart = new DateTime($today); 
   						$dteEnd   = new DateTime($formatDate);

						// Validate Date again, only show Today and after
						if( $dteEnd >= $dteStart):

							if($class->id_student != 0){
								$getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $class->id_student", OBJECT );

								$studentName = $getStudent->name_student .' '.$getStudent->lastname_student;
							}else{
								$studentName = ' - ';
							}

							?>
							<tr>
								<td class="text-center" style="width: 370px"><?php echo $key; ?></td>
								<td class="text-center" style="width: 300px"><?php echo $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date); ?></td>
								<td class="text-center" style="width: 100px"><?php echo $class->start_class; ?></td>
								<td class="text-center" style="width: 100px"><?php echo $class->end_class; ?></td>
								<td class="text-center <?php getClassStatus($class->status); ?>" data-idclass="<?php echo $class->id_class; ?>"><?php echo $class->status; ?></td>
								<td class="text-center"><?php echo $studentName; ?></td>
								<td class="text-center"><a href="#" id="suspendClass" class="btn btn-secundary btn-xs btn-block <?php getClassStatus($class->status, true); ?>" data-idclass="<?php echo $class->id_class; ?>" data-student="<?php if($class->id_student) : echo $class->id_student; else: echo '0'; endif; ?>">Suspender</a></td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
					</tbody>
				</table>

				<div class="col-md-4 add-bottom small text-left"><span class="suspend">SUSPENDIDO</span> = Clase suspendida por mi</div>
				<div class="col-md-4 add-bottom small text-center"><span class="cancel">CANCELADA</span> = Clase cancelada por el estudiante</div>
				<div class="col-md-4 add-bottom small text-right"><span class="confirm">CONFIRMADA</span> = Horario confirmado para clase</div>
			</div>

			<script type="text/javascript">
				var id_teacher = <?php echo $teacher->id_teacher; ?>
			</script>
		</div>
	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/modulo-profesor/'; ?>");
		</script>
	<?php endif; ?>
	</div>

	<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="has-student">
					<div class="header-message">
						<div class="titlesmall color gray text-center">¡Espera!</div>
						<div class="h5 color gray text-center add-bottom">Al parecer la clase que intentas suspender ya tiene un alumno inscrito</div>

						<div style="margin: 0 auto; width: 66.66666667%;">
							<p class="text-center small">De acuerdo a nuestras políticas de suspensión de clases, si suspendes una clase que tenga un alumno inscrito se te descontarán 15 minutos de clase
								por cada 30 minutos de clase suspendidos.</p>
							<p class="text-center small">Más de 120 minutos de clase suspendidos en un mes implicarán la observación de nuestro Departamento Académico.</p>
							<p class="text-center small">En caso que estés suspendiendo las clases por motivos de salud por favor te esperamos en nuestra oficinas de Dirección Académica para que hagas
								entrega de los certificados médicos justificatorios.</p>
							<p class="text-center small">En caso de que trabajes desde provincias por favor envía un escaneo con la documentación requerida.</p>
							<p class="text-center small">El sistema ya no te enviará recordatorios para esta clase y el sistema enviará automáticamente una alerta de suspensión de clases al estudiante
								para que no espere por ti en el horario programado.</p>

							<div class="h5 color gray text-center">Gracias por tu comprensión</div>
							<div style="margin: 20px auto; width: 150px">
								<a href="#" class="btn btn-secundary btn-sm class-cancel" data-dismiss="modal">Cancelar</a>
								<a href="#" class="btn btn-secundary btn-sm class-proccess" data-idclass="" data-student="">Proceder</a>
							</div>
						</div>
					</div>
				</div>
				<div class="not-student">
					<div class="header-message">
						<div class="titlesmall color gray text-center">¡Espera!</div>
						<div class="h5 color gray text-center add-bottom">La clase que intentas suspender aún no tiene un alumno inscrito</div>

						<div style="margin: 0 auto; width: 66.66666667%;">
							<p class="text-center small">Aún puedes esperar a que algún alumno se inscriba a tiempo para tu clase.</p>
							<p class="text-center small">El sistema ya no te enviará recordatorios para esta clase .</p>

							<div class="h5 color gray text-center">Gracias por tu comprensión</div>
							<div style="margin: 20px auto; width: 150px">
								<a href="#" class="btn btn-secundary btn-sm class-cancel" data-dismiss="modal">Cancelar</a>
								<a href="#" class="btn btn-secundary btn-sm class-proccess" data-idclass="" data-student="">Proceder</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>