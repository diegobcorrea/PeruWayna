<?php
/**
 * Template Name: Admin - Historial horas gratis
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

		<form id="HourTeacherForm" class="form-horizontal" role="form" class="col-md-12">
			<div class="h4 add-bottom"><strong>Historial de horas otorgadas</strong></div>
			<div class="col-md-7 add-bottom">
				<div class="col-md-8">
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
				<div class="col-md-8">
					<div class="form-group">
						<label for="inputDateEnd" class="col-sm-4 control-label text-right">Fecha Límite</label>
						<div class="col-sm-8">
							<div id="endToday" class="input-group date" data-date-format="mm-dd-yyyy">
								<input type="text" class="form-control" id="inputDateEnd" name="dateend" required>
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<input type="submit" class="form-control btn btn-secundary" id="seeFreeHours" value="Consultar">
				</div>
			</div>
		</form>

		<div class="col-md-12">
			<script type="text/javascript">
			jQuery(document).ready(function() {
			    jQuery('#table-seeFreehours').dataTable( { 
			    	paging: false, 
			    	searching: false, 
			    	"scrollY": "507px", 
			    	"scrollCollapse": true, 
			    	"order": [ [0,"desc"] ], 
			    	"columnDefs": [{
		                "targets": [ 0 ],
		                "visible": false,
		                "searchable": false
		            }] 
		        });

			    var body_height = parseInt(jQuery('#table-seeFreehours_wrapper .dataTables_scrollBody').height());
				jQuery('#table-seeFreehours_wrapper .dataTables_scrollBody').height(body_height + 30);
			} );
			</script>
			<div class="col-md-7">
				<table id="table-seeFreehours" class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th class="text-center" style="width: 70px">Orden</th>
							<th class="text-center" style="width: 100px">Fecha</th>
							<th class="text-center" style="width: 250px">Nombre del Estudiante</th>
							<th class="text-center" style="width: 100px">Nro. horas</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
			<div class="col-md-5" style="background-color: #ccc; border-radius: 10px;">
				<form id="GiveHoursForm" class="form-horizontal" role="form" class="col-md-12">
				<div class="h4 add-bottom"><strong>Otorgar horas gratis</strong></div>
				<div class="col-md-12 add-bottom">
					<div class="col-md-12">
						<div class="form-group">
							<label for="inputName" class="col-md-4 control-label text-right">Nombre</label>
							<div class="col-md-8">
								<?php $getStudents = $wpdb->get_results( "SELECT * FROM wp_bs_student", OBJECT ); ?>
								<select name="id_student" id="inputIDstudent">
								<?php foreach ($getStudents as $student) : ?>
									<option value="<?php echo $student->id_student; ?>"><?php echo $student->name_student ?> <?php echo $student->lastname_student ?></option>
								<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="inputMinutes" class="col-md-4 control-label text-right">Minutos (Horas x 60)</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="inputMinutes" name="minutes" required>
							</div>
						</div>
					</div>
					<div class="col-md-6 pull-right">
						<input type="submit" class="form-control btn btn-secundary" id="giveFreeHours" value="Otorgar horas">
					</div>
				</div>
			</form>

			</div>
		</div>

	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/admin-panel/'; ?>");
		</script>
	<?php endif; ?>
	</div>

	<div id="freehourStatus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="success">
					<div class="header-message">
						<div class="titlesmall color gray text-center">¡Finalizado!</div>
						<div class="h5 color gray text-center add-bottom">Se otorgaron las horas (minutos) gratis al alumno que elegiste</div>

						<div style="margin: 0 auto; width: 66.66666667%;">
							<div style="margin: 20px auto; width: 100px">
								<a href="#" class="btn btn-secundary btn-sm btn-block class-cancel" data-dismiss="modal">Cerrar</a>
							</div>
						</div>
					</div>
				</div>
				<div class="warning">
					<div class="header-message">
						<div class="titlesmall color gray text-center">¡Hubo un problema!</div>
						<div class="h5 color gray text-center add-bottom">Al parecer los datos del alumno ingresado no coinciden o no existe</div>

						<div style="margin: 0 auto; width: 66.66666667%;">
							<div style="margin: 20px auto; width: 100px">
								<a href="#" class="btn btn-secundary btn-sm btn-block class-cancel" data-dismiss="modal">Cerrar</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>