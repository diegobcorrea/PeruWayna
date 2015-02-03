<?php
/**
 * Template Name: Admin - Estudiantes y Profesores
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
			<div class="h4 add-bottom"><strong>Registro de alumnos</strong></div>
		</div>
		<?php 

		$h = "5";
	    $hm = $h * 60; 
	    $ms = $hm * 60;

	    $today = date('Y-m-d h:i A',time()-($ms));
	    $now = date('m-d-Y',time()-($ms));

		?>
		<script type="text/javascript">
		jq(document).ready(function() {
		    jq('#student-registers').dataTable( { 
		    	paging: false, 
		    	searching: false, 
		    	"scrollY": "507px", 
		    	"scrollCollapse": true, 
		    	"order": [ 
		    		[0,"asc"] 
		    	] 
		    });

		    var body_height = parseInt(jq('#student-registers_wrapper .dataTables_scrollBody').height());

			jq('#student-registers_wrapper .dataTables_scrollBody').height(body_height + 30);
		} );
		</script>
		<table id="student-registers" class="table table-striped table-bordered text-center">
			<thead>
				<tr>
					<th class="text-center" style="width: 150px">Fecha de registro</th>
					<th class="text-center" style="width: 250px">Nombre estudiante</th>
					<th class="text-center" style="width: 150px">País</th>
					<th class="text-center">Edad</th>
					<th class="text-center" style="width: 200px">Correo electrónico</th>
					<th class="text-center">Ofertas</th>
				</tr>
			</thead>
			<tbody>
				<?php

				global $wpdb, $dias, $meses;
				$getStudents = $wpdb->get_results( "SELECT * FROM wp_bs_student ORDER BY id_student", OBJECT );

				foreach ($getStudents as $student) : 

				$studentName = $student->name_student .' '.$student->lastname_student;
				$date = date('d-m-Y', strtotime($student->register_date));

			    $today = date('m/d/Y',time()-($ms));

				$dteStart = new DateTime($today); 
				$dteEnd   = new DateTime($student->birthday_student);

				$dteDiff  = $dteStart->diff($dteEnd);
				$years = $dteDiff->y;

				if($student->offers_student == 1):
					$offers = "SI";
				else:
					$offers = "NO";
				endif;

				?>
				<tr>
					<td class="text-center" style="width: 150px"><?php echo $date; ?></td>
					<td class="text-center" style="width: 250px"><?php echo $studentName; ?></td>
					<td class="text-center" style="width: 150px"><?php echo $student->country_student; ?></td>
					<td class="text-center"><?php echo $years; ?></td>
					<td class="text-center" style="width: 200px"><?php echo $student->email_student; ?></td>
					<td class="text-center"><?php echo $offers; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php 
			$getStudentNum = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_student" ); 
		?>
		<div id="table-hours" class="row half-top remove-bottom">
			<div class="form-group col-md-6 pull-right" style="line-height: 2.3em;">
				<label for="cancelminus" class="col-sm-8 control-label text-right">Total de alumnos inscritos</label>
				<div class="col-sm-4">
					<input type="text" class="form-control text-center" id="cancelminus" name="cancelminus" value="<?php echo $getStudentNum[0]->total; ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12 add-bottom">
			<div class="col-lg-2 pull-right">
				<a class="form-control btn btn-excel" id="allstudents-exportExcel">Exportar Excel</a>
			</div>
		</div>

		<div class="add-bottom">
			<div class="h4 add-bottom"><strong>Registro de profesores</strong></div>
		</div>

		<script type="text/javascript">
		jq(document).ready(function() {
		    jq('#teacher-registers').dataTable( { paging: false, searching: false, "scrollY": "507px", "scrollCollapse": true, "order": [ [0,"asc"] ] });

		    var body_height = parseInt(jq('#teacher-registers_wrapper .dataTables_scrollBody').height());

			jq('#teacher-registers_wrapper .dataTables_scrollBody').height(body_height + 30);
		} );
		</script>
		<table id="teacher-registers" class="table table-striped table-bordered text-center">
			<thead>
				<tr>
					<th class="text-center" style="width: 150px">Fecha registro</th>
					<th class="text-center" style="width: 200px">Nombre del profesor</th>
					<th class="text-center" style="width: 150px">País</th>
					<th class="text-center">Edad</th>
					<th class="text-center" style="width: 200px">Correo personal</th>
					<th class="text-center" style="width: 200px">Correo corporativo</th>
				</tr>
			</thead>
			<tbody>
				<?php

				global $wpdb, $dias, $meses;
				$getTeachers = $wpdb->get_results( "SELECT * FROM wp_bs_teacher ORDER BY id_teacher", OBJECT );

				foreach ($getTeachers as $teacher) : 

				$teacherName = $teacher->name_teacher .' '.$teacher->lastname_teacher;
				$date = date('d-m-Y', strtotime($teacher->register_date));

				$today = date('m/d/Y',time()-($ms));

				$dteStart = new DateTime($today); 
				$dteEnd   = new DateTime($teacher->birthday_teacher);

				$dteDiff  = $dteStart->diff($dteEnd);
				$years = $dteDiff->y;

				?>
				<tr>
					<td class="text-center" style="width: 150px"><?php echo $date; ?></td>
					<td class="text-center" style="width: 200px"><?php echo $teacherName; ?></td>
					<td class="text-center" style="width: 150px"><?php echo $teacher->country_teacher; ?></td>
					<td class="text-center"><?php echo $years; ?></td>
					<td class="text-center" style="width: 200px"><?php echo $teacher->email_p_teacher; ?></td>
					<td class="text-center" style="width: 200px"><?php echo $teacher->email_c_teacher; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php 
			$getTeacherNum = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_teacher" ); 
		?>
		<div id="table-hours" class="row half-top remove-bottom">
			<div class="form-group col-md-6 pull-right" style="line-height: 2.3em;">
				<label for="cancelminus" class="col-sm-8 control-label text-right">Total de profesores registrados</label>
				<div class="col-sm-4">
					<input type="text" class="form-control text-center" id="cancelminus" name="cancelminus" value="<?php echo $getTeacherNum[0]->total; ?>">
				</div>
			</div>
		</div>
		<div class="col-md-12 add-bottom">
			<div class="col-lg-2 pull-right">
				<a class="form-control btn btn-excel" id="allteachers-exportExcel">Exportar Excel</a>
			</div>
		</div>

	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/admin-panel/'; ?>");
		</script>
	<?php endif; ?>
	</div>

<?php get_footer(); ?>