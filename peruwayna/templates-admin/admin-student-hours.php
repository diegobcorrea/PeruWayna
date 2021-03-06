<?php
/**
 * Template Name: Admin - Estudiante Horarios
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

		<form id="HourTeacherForm" class="form-horizontal" role="form">
			<div class="h4 add-bottom"><strong>Consultar registro de horas del alumno</strong></div>
			<div class="col-md-12">
				<div class="col-lg-5">
					<div class="form-group">
						<label for="inputName" class="col-sm-4 control-label text-right">Nombre</label>
						<div class="col-sm-8">
							<?php $getStudents = $wpdb->get_results( "SELECT * FROM wp_bs_student", OBJECT ); ?>
							<select name="id_student" id="inputIDstudent">
							<?php foreach ($getStudents as $student) : ?>
								<option value="<?php echo $student->id_student; ?>"><?php echo $student->name_student ?> <?php echo $student->lastname_student ?></option>
							<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-lg-5"></div>
				<div class="col-lg-2">
					<a class="form-control btn btn-secundary" id="student-exportExcel">Exportar Excel</a>
				</div>
			</div>
			<div class="col-md-12 add-bottom">
				<div class="col-lg-5">
					<div class="form-group">
						<label for="inputDateStart" class="col-sm-4 control-label text-right">Fecha Inicio</label>
						<div class="col-sm-8">
							<div id="notstart" class="input-group date" data-date-format="mm-dd-yyyy">
								<input type="text" class="form-control" id="inputDateStart" name="datestart" required>
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="form-group">
						<label for="inputDateEnd" class="col-sm-4 control-label text-right">Fecha Inicio</label>
						<div class="col-sm-8">
							<div id="notstart" class="input-group date" data-date-format="mm-dd-yyyy">
								<input type="text" class="form-control" id="inputDateEnd" name="dateend" required>
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-2">
					<input type="submit" class="form-control btn btn-secundary" id="student-seeHours" value="Consultar">
				</div>
			</div>
		</form>

		<div id="dvjson"></div>

		<script type="text/javascript">
		jQuery(document).ready(function() {
		    jQuery('#teacher-seehours').dataTable( { paging: false, searching: false, "scrollY": "507px", "scrollCollapse": true, "order": [ [0,"asc"] ], "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            } ] });

		    var body_height = parseInt(jQuery('#teacher-seehours_wrapper .dataTables_scrollBody').height());

			jQuery('#teacher-seehours_wrapper .dataTables_scrollBody').height(body_height + 30);

			jQuery("#inputIDstudent").chosen();
		} );
		</script>
		<table id="teacher-seehours" class="table table-striped table-bordered text-center">
			<thead>
				<tr>
					<th class="text-center" style="width: 70px">Orden</th>
					<th class="text-center" style="width: 300px">Día</th>
					<th class="text-center" style="width: 100px">Desde</th>
					<th class="text-center" style="width: 100px">Hasta</th>
					<th class="text-center">Profesor</th>
					<th class="text-center">Alumno</th>
					<th class="text-center">Estado</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>

		<div id="table-hours" class="row add-top" style="display: none;">
			<div class="form-group col-md-6">
				<label for="complete" class="col-sm-8 control-label text-right" style="line-height: 2.3em;">Total de horas <span class="confirm">COMPLETADAS</span></label>
				<div class="col-sm-4">
					<input type="text" class="form-control text-center" id="complete" name="complete">
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="confirm" class="col-sm-8 control-label text-right" style="line-height: 2.3em;">Total de horas <span class="confirm">CONFIRMADAS</span></label>
				<div class="col-sm-4">
					<input type="text" class="form-control text-center" id="confirm" name="confirm">
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="nocomplete" class="col-sm-8 control-label text-right" style="line-height: 2.3em;">Total de horas que <span class="miss">ALUMNO FALTÓ</span></label>
				<div class="col-sm-4">
					<input type="text" class="form-control text-center" id="nocomplete" name="nocomplete">
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="cancelplus" class="col-sm-8 control-label text-right" style="line-height: 2.3em;">Total de horas <span class="cancel">CANCELADAS +</span></label>
				<div class="col-sm-4">
					<input type="text" class="form-control text-center" id="cancelplus" name="cancelplus">
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="cancelminus" class="col-sm-8 control-label text-right" style="line-height: 2.3em;">Total de horas <span class="cancel">CANCELADAS -</span></label>
				<div class="col-sm-4">
					<input type="text" class="form-control text-center" id="cancelminus" name="cancelminus">
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="suspend" class="col-sm-8 control-label text-right" style="line-height: 2.3em;">Total de horas <span class="cancel">SUSPENDIDAS</span></label>
				<div class="col-sm-4">
					<input type="text" class="form-control text-center" id="suspend" name="suspend">
				</div>
			</div>
			
		</div>

	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/admin-panel/'; ?>");
		</script>
	<?php endif; ?>
	</div>

<?php get_footer(); ?>