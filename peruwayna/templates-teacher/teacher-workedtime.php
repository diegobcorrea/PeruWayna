<?php
/**
 * Template Name: Teacher Panel - Horas Laboradas
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
				<div class="h4 add-bottom"><strong>Mi registro de horas laboradas</strong></div>

				<p class="add-bottom">
					El siguiente historial de clases laboradas detalla únicamente las clases completadas (clases realizadas) y las clases en las que el alumno faltó 
					(las horas en las que un alumno falta son igualmente remuneradas para el profesor por lo cual también se condideran como horas laboradas).
				</p>

				<form id="HourTeacherForm" class="form-horizontal row" role="form">
					<div class="col-md-5">
						<div class="form-group">
							<label for="inputDateStart" class="col-sm-4 control-label text-right">Fecha Inicio</label>
							<div class="col-sm-8">
								<div id="startdayNot" class="input-group date" data-date-format="mm-dd-yyyy">
									<input type="text" class="form-control" id="inputDateStart" name="datestart" required>
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
									<input type="text" class="form-control" id="inputDateEnd" name="datestart" required>
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<input type="submit" class="form-control btn btn-secundary" id="submitWorkedtime" value="Consultar">
					</div>
				</form>

				<script type="text/javascript">
				jq(document).ready(function() {
				    jq('#mywork-teacher').dataTable( { paging: false, searching: false, "scrollY": "507px", "scrollCollapse": true, });
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
						<label for="workedTime" class="col-sm-8 control-label text-right" style="line-height: 2.3em;">Total de Horas Laboradas</label>
						<div class="col-sm-4">
							<input type="text" class="form-control text-center" id="workedTime" name="workedTime">
						</div>
					</div>
				</div>

				<p class="text-right small">
					El total de las horas laboradas = <span class="confirm">COMPLETADAS</span> + <span class="miss">ALUMNO FALTÓ</span> + <span class="cancel">CANCELADAS -</span><br/>
					(<span class="cancel">CANCELADAS -</span> = horas canceladas con menos de 48 horas).<br/>
					Por favor notar que las horas canceladas con más de 48 horas no cuentan como horas laboradas.<br/>
					(<span class="cancel">CANCELADAS +</span> = horas canceladas con más de 48 horas).
				</p>
			</div>

			<div class="col-md-12 add-bottom">
				<div class="h4 add-bottom"><strong>Actualizar el estado de una clase</strong></div>

				<p class="small">
					<strong>NOTA:</strong> El sistema de reservas y horarios registrará automáticamente una clase como "<span class="confirm">COMPLETADA</span>" inmediatamente después
					del término de una clase. En caso de que el alumno haya faltado (no haya asistido a su clase en vivo) es responsabilidad del profesor actualizar el estado de la clase
					a "<span class="miss">ALUMNO FALTÓ</span>" cambiando el estado en la lista deplegable inferior.
				</p>

				<form id="HourTeacherForm" class="form-horizontal row" role="form">
					<div class="col-md-5">
						<div class="form-group">
							<label for="inputIDclass" class="col-sm-4 control-label text-right">ID de la clase</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="inputIDclass" name="inputIDclass" required>
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label for="inputChangeStatus" class="col-sm-4 control-label text-right">Estado</label>
							<div class="col-sm-8">
				                <select id="inputChangeStatus" class="form-control">
									<option>Elegir en la lista</option>
									<option class="confirm" value="COMPLETADA">COMPLETADA</option>
									<option class="miss" value="ALUMNO FALTÓ">ALUMNO FALTÓ</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<input type="submit" class="form-control btn btn-secundary" id="submitChangeStatus" value="Cambiar Estado">
					</div>
				</form>
			</div>

			<div id="updateStatusModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						
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