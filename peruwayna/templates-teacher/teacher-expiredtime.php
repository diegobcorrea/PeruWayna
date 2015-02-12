<?php
/**
 * Template Name: Teacher Panel - Horas Expiradas
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
				<div class="h4 add-bottom"><strong>Mi registro de horas expiradas</strong></div>

				<p class="add-bottom">
					El siguiente historial de clases se detalla únicamente las clases expiradas (clases sin alumno que pasaron su fecha).
				</p>

				<form id="HourTeacherForm" class="form-horizontal row" role="form">
					<div class="col-md-5">
						<div class="form-group">
							<label for="inputDateStart" class="col-sm-4 control-label text-right">Fecha Inicio</label>
							<div class="col-sm-8">
								<div id="startdayNot" class="input-group date" data-date-format="mm-dd-yyyy">
									<input type="text" class="form-control" id="DateStart" name="datestart" required>
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label for="inputDateEnd" class="col-sm-4 control-label text-right">Fecha Fin</label>
							<div class="col-sm-8">
				                <div id="startdayNot" class="input-group date" data-date-format="mm-dd-yyyy">
									<input type="text" class="form-control" id="DateEnd" name="datestart" required>
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<input type="hidden" id="TeacherID" value="<?php echo $teacher->id_teacher; ?>">
						<input type="submit" class="form-control btn btn-secundary" id="submitExpiredtime" value="Consultar">
					</div>
				</form>

				<script type="text/javascript">
				jq(document).ready(function() {
				    jq('#mywork-teacher').dataTable( { 
				    	paging: false, 
				    	searching: false, 
				    	"scrollY": "507px", 
				    	"scrollCollapse": true, 
				    	"language": {
							"zeroRecords": "<b>Escoge las fechas y da click en 'Consultar'.</b>"
						}
				    });
				} );
				</script>
				<table id="mywork-teacher" class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th class="text-center" style="width: 50px">ID</th>
							<th class="text-center" style="width: 300px">Día</th>
							<th class="text-center" style="width: 100px">Desde</th>
							<th class="text-center" style="width: 100px">Hasta</th>
							<th class="text-center">Estado</th>
							<th class="text-center">Alumno</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>

				<div class="text-right row">
					<div class="form-group pull-right">
						<label for="workedTime" class="col-sm-8 control-label text-right" style="line-height: 2.3em;">Total de Horas Expiradas</label>
						<div class="col-sm-4">
							<input type="text" class="form-control text-center" id="workedTime" name="workedTime">
						</div>
					</div>
				</div>
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

<?php get_footer(); ?>