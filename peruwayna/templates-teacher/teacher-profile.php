<?php
/**
 * Template Name: Teacher Panel - Perfil
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

		<form id="updateTeacher" class="form-horizontal" method="post" action="" role="form">
		<div class="firststep">
			<div class="header-message">
				<div class="medium color gray ta-center">Editar mi perfil</div>
				<div class="h5 color gray ta-center">Cambio tus datos que sean necesarios, la contraseña solo se cambiará si se llena el campo</div>
			</div>

			<div class="bg-success text-center successUpdate" style="border-radius: 5px; display: none; margin: 0 auto; padding: 15px; width: 530px;"><h5>Sus datos fueron guardados correctamente.</h5></div>

			<div class="registerForm">
				<div class="form-group">
					<label for="inputName" class="col-sm-4 control-label text-right">Nombre</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputName" name="name" required="" value="<?php echo $teacher->name_teacher; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="inputLastname" class="col-sm-4 control-label text-right">Apellido</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputLastname" name="lastname" required="" value="<?php echo $teacher->lastname_teacher; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="inputMail" class="col-sm-4 control-label text-right">Correo Electrónico Personal</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputMail" name="email" required="" value="<?php echo $teacher->email_p_teacher; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="inputMailCorp" class="col-sm-4 control-label text-right">Correo Electrónico Corporativo</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputMailCorp" name="emailCorp" required="" value="<?php echo $teacher->email_c_teacher; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="inputSkype" class="col-sm-4 control-label text-right">Skype ID</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputSkype" name="skypeID" required="" value="<?php echo $teacher->skype_teacher; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCountry" class="col-sm-4 control-label text-right">País de Residencia</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputCountry" name="country" required="" value="<?php echo $teacher->country_teacher; ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="inputBirthday" class="col-sm-4 control-label text-right">Fecha de Nacimiento</label>
					<div class="col-sm-8">
						<div id="datetimeStart" class="input-group date" data-date-format="mm-dd-yyyy">
							<input type="text" class="form-control" id="inputBirthday" name="birthday" required value="<?php echo $teacher->birthday_teacher; ?>" disabled>
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDescription" class="col-sm-4 control-label text-right">Descripción</label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="5" id="inputDescription" name="description" required disabled><?php echo $teacher->description_teacher; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPicture" class="col-sm-4 control-label text-right">Foto personal</label>
					<div class="col-sm-8">
						<input type="text" id="inputPicture" class="option-input upload preview pexeto-upload pull-left col-sm-8" name="picture" required value="<?php echo $teacher->photo_teacher; ?>" disabled />
						<input type="button" id="inputPicture_button" class="btn btn-secundary pexeto-upload-btn pull-right" value="Cargar foto" disabled />
						<div class="tag-container pull-left">
							<img src="<?php echo $teacher->photo_teacher; ?>" class="option-image img-circle img-responsive" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputOldPassword" class="col-sm-4 control-label text-right">Contraseña Antigua</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputOldPassword" name="oldPassword">
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword" class="col-sm-4 control-label text-right">Contraseña Nueva</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="inputPassword" name="password" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="inputRePassword" class="col-sm-4 control-label text-right">Repetir Contraseña Nueva</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="inputRePassword" name="repassword" disabled>
					</div>
				</div>
				<div class="center-btn">
					<input type="submit" id="updateProfileTeacher" class="btn btn-primary btn-sm btn-block" value="Guardar">
				</div>
			</div>

			<div class="bg-success text-center successUpdate" style="border-radius: 5px; display: none; margin: 0 auto; padding: 15px; width: 530px;"><h5>Sus datos fueron guardados correctamente.</h5></div>
		</div>
		</form>
		<script type="text/javascript">
			var id_teacher = <?php echo $teacher->id_teacher; ?>
		</script>
	<?php else : ?>
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">Módulo de profesor</div>
		</div>
		<div class="header-message">
			<div class="big color gray ta-center">¡Bienvenido!</div>
			<div class="h5 color gray ta-center">Por favor ingrese su correo y contraseña para ingresar al módulo de profesor</div>
		</div>
		<div class="newaccount-meesage text-center">
			<p>¿Todavia no esta registrado?</p>
			<a href="<?php echo get_site_url() . '/sistema-de-reservas/registro/'; ?>" class="create">Solicite un usuario a nuestro Coordinador Académico</a>
		</div>
		<?php show_error_messages(); ?>
		<div class="loginForm">
			<form id="loginTeacher" method="post" action="">
				<div class="form-group ta-center">
					<img src="<?php echo get_template_directory_uri(); ?>/images/login_pic.jpg" class="img-circle">
				</div>
				<div class="form-group">
					<input type="text" name="teacher_email" class="form-control" placeholder="Dirección de Correo Corporativo">
					<input type="password" name="teacher_password" class="form-control" placeholder="Contraseña">
				</div>
				<input type="hidden" name="teacher_nonce" value="<?php echo wp_create_nonce('teacher-nonce'); ?>"/>
				<input type="submit" class="btn btn-primary btn-sm btn-block" value="Ingresar">

				<div class="form-group remember">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="teacher_staylogin" value="yes"> Permanecer conectado
						</label>
					</div>
				</div>
				<div class="form-group remember">
					<a href="#">¿Olvidó su contraseña?</a>
				</div>
			</form>
		</div>
	<?php endif; ?>
	</div>

	<div id="teacherUpdateModalPassword" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="header-message">
					<div class="titlesmall color gray text-center">Datos Actualizados</div>

					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">Tu contraseña fue actualizada, se cerrará tu sesión para que vuelvas a ingresar.</p>

						<div style="margin: 20px auto; width: 170px">
							<a href="#" id="closeSession" class="btn btn-secundary btn-sm class-cancel" data-dismiss="modal" style="margin: 20px auto; width: 100px">Ok</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="teacherUpdateModal" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="header-message">
					<div class="titlesmall color gray text-center">Datos Actualizados</div>

					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">Tus datos han sido actualizados en nuestro sistema.</p>

						<div style="margin: 20px auto; width: 170px">
							<a href="#" class="btn btn-secundary btn-sm class-cancel" data-dismiss="modal" style="margin: 20px auto; width: 100px">Ok</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var close_teacherSession = "<?php echo get_site_url() ?>/modulo-profesor/logout?id=1";
	</script>

<?php get_footer(); ?>