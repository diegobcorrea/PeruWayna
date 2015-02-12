<?php
/**
 * Template Name: Admin - Clases Disponibles
 */

get_header(); ?>

	<div class="container">
	<?php if ( is_user_logged_in() ) : ?>
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">
				<div class="dropdown">
					<div id="dropdownMenu1" data-toggle="dropdown">
						Panel de Administrador
						<span class="caret"></span>
					</div>
					<?php include( TEMPLATEPATH . '/templates-admin/admin-menu.php'); ?>
				</div>
			</div>
		</div>

		<div class="add-bottom">
			<div class="h4 add-bottom"><strong>Vista general de disponibilidad de horarios</strong></div>
			<div>La siguiente lista detalla todos los horarios de clase disponibles cargados por los profesores que todavía no han sido reservados por ningún alumno:</div>			
		</div>
		<?php 

		$h = "5";
	    $hm = $h * 60; 
	    $ms = $hm * 60;

	    $today = date('d-m-Y h:i A',time()-($ms));
	    $now = date('m-d-Y',time()-($ms));

		?>
		<script type="text/javascript">

		(function(){

			var currentLang = 'es';
			moment.locale(currentLang);

			function update() {
				jq('#clock').html(moment().utcOffset(-5).format('LLL'));
			}

			setInterval(update, 1000);

		})();

		</script>
		<div class="clock add-bottom">Tiempo y hora actual: <span id="clock">cargando ...</span></div>

		<script type="text/javascript">
		jq(document).ready(function() {
		    jq('#reservedClass').dataTable( { 
		    	paging: false, 
		    	searching: false, 
		    	"scrollY": "507px", 
		    	"scrollCollapse": true, 
		    	"order": [ [0,"asc"] ],
		    	"columnDefs": [ {
	                "targets": [ 0 ],
	                "visible": false,
	                "searchable": false
	            } ] ,
	            "language": {
					"zeroRecords": "No hay clases disponibles por el momento."
				} 

			});

		    var body_height = parseInt(jq('#reservedClass_wrapper .dataTables_scrollBody').height());

			jq('#reservedClass_wrapper .dataTables_scrollBody').height(body_height + 30);
		} );
		</script>
		<table id="reservedClass" class="table table-striped table-bordered text-center">
			<thead>
				<tr>
					<th class="text-center">ID</th>
					<th class="text-center" style="width: 300px">Día</th>
					<th class="text-center" style="width: 100px">Desde</th>
					<th class="text-center" style="width: 100px">Hasta</th>
					<th class="text-center">Profesor</th>
					<th class="text-center">Alumno</th>
					<th class="text-center">Estado</th>
				</tr>
			</thead>
			<tbody>
				<?php

				global $wpdb, $dias, $meses;
				$getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE date_class >= '$now' AND status = 'DISPONIBLE' ORDER BY date_class", OBJECT );

				foreach ($getClasses as $class) : 

				$date = explode("-", $class->date_class);
				$timeNow = strtotime($date[0].'/'.$date[1].'/'.$date[2] . ' '. $class->start_class);
				$date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] ); 
				
				$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
				$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

				if($class->id_student != 0){
					$getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $class->id_student", OBJECT );

					$studentName = $getStudent->name_student .' '.$getStudent->lastname_student;
				}else{
					$studentName = ' - ';
				}

				if($class->id_teacher != 0){
					$getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = $class->id_teacher", OBJECT );

					$teacherName = $getTeacher->name_teacher .' '.$getTeacher->lastname_teacher;
				}else{
					$teacherName = ' - ';
				}

				?>
				<tr>
					<td class="text-center"><?php echo $timeNow; ?></td>
					<td class="text-center" style="width: 300px"><?php echo $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date); ?></td>
					<td class="text-center" style="width: 100px"><?php echo $class->start_class; ?></td>
					<td class="text-center" style="width: 100px"><?php echo $class->end_class; ?></td>
					<td class="text-center"><?php echo $teacherName; ?></td>
					<td class="text-center"><?php echo $studentName; ?></td>
					<td class="text-center <?php getClassStatus($class->status); ?>" data-idclass="<?php echo $class->id_class; ?>"><?php echo $class->status; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php 
			$getHours = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE date_class >= '$now' AND status = 'DISPONIBLE' ORDER BY date_class" ); 
			$hours = m2h($getHours[0]->total *30);
		?>
		<div id="table-hours" class="row half-top remove-bottom">
			<div class="form-group col-md-6 pull-right" style="line-height: 2.3em;">
				<label for="cancelminus" class="col-sm-8 control-label text-right">Total de horas <span class="confirm">DISPONIBLES</span></label>
				<div class="col-sm-4">
					<input type="text" class="form-control text-center" id="cancelminus" name="cancelminus" value="<?php echo $hours; ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12 add-bottom">
			<div class="col-lg-2 pull-right">
				<a class="form-control btn btn-excel" id="availableClass-exportExcel">Exportar Excel</a>
			</div>
		</div>

	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/admin-panel/'; ?>");
		</script>
	<?php endif; ?>
	</div>

<?php get_footer(); ?>