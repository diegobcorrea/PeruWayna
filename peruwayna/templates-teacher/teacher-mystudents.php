<?php
/**
 * Template Name: Teacher Panel - Mis Estudiantes
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
				<div class="h4 add-bottom"><strong>Ver la información de mis estudiantes / actualizar los datos de un estudiante</strong></div>

				<p>La lista inferior nuestra el detalle de todos los estudiantes que tuviste, tienes y tendrás.</p>
				<p>Puedes y debes actualizar el nivel de tus estudiantes cada vez que tu alumno haya pasado un nivel. Igualmente debes hacer anotaciones relevantes con el fin
					de ofrecer un mejor servicio de clase. Las anotaciones pueden incluir debilidades y fortalezas de cada estudiante, así como específicaciones de estilos o
					metodologías de enseñanza por las cuales tu alumno tenga afinidad.</p>

				<p><strong>Instrucciones:</strong></p>
				<ul class="list-number">
					<li>Encuentra al alumno que buscas en la lista inferior y anota su ID.</li>
					<li>Ingresa el ID en la casilla de texto debajo de la lista y haz click en el botoón "Consultar".</li>
					<li>Después de hacer click en el botón "Consultar", el sistema llenará automaticamente las casillas de texto con la información de tu estudiante, las
						casillas de texto habilitadas para escritura/modificación son los campos que esta permitido modificar.</li>
					<li>Cuando completes la modificación del nivel y/o hacer las anotaciones respectivas. Confirma los cambios haciendo click en "Guardar Cambios".</li>
				</ul>

				<p><strong>Nota:</strong> Por favor asegúrate de que se trate del estudiante correcto antes de modificar la información, para esto puedes verificar su foto e 
					información personal mostrada en las casillas de texto deshabilitadas. Si no estas 100% seguro de que se trate del estudiante que buscas, contacta a nuestro
					Departamento Académico para obtener asistencia.</p>

				<script type="text/javascript">
				jq(document).ready(function() {
				    jq('#mystudents-teacher').dataTable( { 
				    	paging: false, 
				    	searching: false, 
				    	"scrollY": "300px", 
				    	"scrollCollapse": true, 
				    	"language": {
							"zeroRecords": "Los alumnos aún no han tenido clases contigo."
						}
				    });

				    var body_height = parseInt(jq('#mystudents-teacher_wrapper .dataTables_scrollBody').height());

				    jq('#mystudents-teacher_wrapper .dataTables_scrollBody').height(body_height + 30);
				} );
				</script>
				<table id="mystudents-teacher" class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th class="text-center" style="width: 50px;">ID</th>
							<th class="text-center" style="width: 240px;">Nombre del Alumno</th>
							<th class="text-center" style="width: 125px">Foto</th>
							<th class="text-center" style="width: 125px">Nivel</th>
							<th class="text-center">Anotaciones</th>
						</tr>
					</thead>
					<tbody>
					<?php
						global $wpdb;

						$getStudents = $wpdb->get_results( "SELECT wp_bs_student.* FROM wp_bs_class JOIN wp_bs_student WHERE wp_bs_class.id_teacher = {$teacher->id_teacher} AND wp_bs_class.id_student = wp_bs_student.id_student GROUP BY wp_bs_class.id_student", OBJECT );

						if($getStudents):
							foreach($getStudents as $student):

							$getLevel = $wpdb->get_row( "SELECT * FROM wp_bs_levels WHERE id_level = {$student->level_student}", OBJECT );
					?>
						<tr>
							<td class="text-center" style="line-height: 5em; width: 50px"><?php echo $student->id_student; ?></td>
							<td class="text-center" style="line-height: 5em; width: 240px"><?php echo $student->name_student; ?> <?php echo $student->lastname_student; ?></td>
							<td class="text-center" style="width: 125px"><img src="<?php echo get_template_directory_uri(); ?>/lib/utils/timthumb.php?src=<?php echo $student->photo_student; ?>&h=65&w=65" class="img-thumbnail"></td>
							<td class="text-center" style="padding: 1.8em 0; width: 125px;"><?php echo $getLevel->level_name; ?><br/><?php echo $getLevel->level_prefix; ?></td>
							<td class="text-left"><?php echo $student->annotation_student; ?></td>
						</tr>
					<?php
							endforeach;
						endif;
					?>
						
					</tbody>
				</table>
			</div>

			<div class="col-md-12 add-bottom">
				<form id="ViewStudentForm" class="form-horizontal row" role="form">
					<div class="col-lg-2"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputIDstudent" class="col-sm-5 control-label text-right">ID del alumno</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="inputIDstudent" name="inputIDstudent">
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<input type="submit" class="form-control btn btn-secundary" id="submitGetStudent" value="consultar">
					</div>
					<div class="col-lg-2"></div>
				</form>

				<div class="student_info">
					<div class="form-group col-md-6">
					    <label for="student_name">Nombre</label>
					    <input type="email" class="form-control" id="student_name" disabled>
					</div>
					<div class="form-group col-md-6">
					    <label for="student_lastname">Apellido</label>
					    <input type="email" class="form-control" id="student_lastname" disabled>
					</div>
					<div class="form-group col-md-6">
					    <label for="student_skype">Skype ID</label>
					    <input type="email" class="form-control" id="student_skype" disabled>
					</div>
					<div class="form-group col-md-6">
					    <label for="student_mail">Correo Electrónico</label>
					    <input type="email" class="form-control" id="student_mail" disabled>
					</div>
					<div class="form-group col-md-6">
					    <label for="student_country">País de Residencia</label>
					    <input type="email" class="form-control" id="student_country" disabled>
					</div>
					<div class="form-group col-md-6">
					    <label for="student_city">Ciudad de Residencia</label>
					    <input type="email" class="form-control" id="student_city" disabled>
					</div>
					<div class="form-group col-md-6">
					    <label for="student_birthday">Fecha de Nacimiento</label>
					    <input type="email" class="form-control" id="student_birthday" disabled>
					</div>
					<div class="form-group col-md-6">
					    <label for="student_language">Lengua Nativa</label>
					    <input type="email" class="form-control" id="student_language" disabled>
					</div>
					<div class="form-group col-md-6">
					    <label for="student_olanguage">Otras lenguas</label>
					    <input type="email" class="form-control" id="student_olanguage" disabled>
					</div>
					<div class="form-group col-md-6">
					    <label for="student_work">¿En qué campo trabaja/estudia?</label>
					    <input type="email" class="form-control" id="student_work" disabled>
					</div>
					<div class="form-group col-md-6">
						<label for="student_level">Nivel</label>
		                <select id="student_level" class="form-control">
							<?php

							global $wpdb;

							$getLevels = $wpdb->get_results( "SELECT * FROM wp_bs_levels", OBJECT );

							foreach($getLevels as $level):

							?>
							<option value="<?php echo $level->id_level; ?>"><?php echo $level->level_name; ?> (<?php echo $level->level_prefix; ?>)</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group col-md-12">
						<label for="student_annotation">Observaciones</label>
		                <textarea class="form-control" id="student_annotation" rows="6"></textarea>
					</div>
					<div class="form-group col-md-3 col-md-offset-9">
						<input type="hidden" class="form-control" id="student_id">
						<input type="submit" class="form-control btn btn-secundary disabled" id="submitChangeStudent" value="Guardar Cambios">
					</div>
				</div>
			</div>

			<div id="updateStatusStudent" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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