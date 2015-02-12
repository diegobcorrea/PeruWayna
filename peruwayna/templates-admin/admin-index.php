<?php
/**
 * Template Name: Admin Panel Template
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

		<form id="AddTeacherForm" class="form-horizontal" role="form">
			<div class="h4 add-bottom"><strong>Agregar Nuevo Profesor</strong></div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="inputName" class="col-sm-4 control-label text-right">Nombre</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputName" name="name" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputLastname" class="col-sm-4 control-label text-right">Apellido</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputLastname" name="lastname" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCountry" class="col-sm-4 control-label text-right">País</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputCountry" name="country" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputBirthday" class="col-sm-4 control-label text-right">Fecha de Nacimiento</label>
					<div class="col-sm-8">
						<div id="datetimeStart" class="input-group date" data-date-format="dd-mm-yyyy">
							<input type="text" class="form-control" id="inputBirthday" name="birthday" required>
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="inputPicture" class="col-sm-4 control-label text-right">Foto</label>
					<div class="col-sm-8">
						<input type="text" id="inputPicture" class="option-input upload preview pexeto-upload pull-left col-sm-8" name="picture" required>
						<input type="button" id="inputPicture_button" class="btn btn-secundary pexeto-upload-btn pull-right" value="Cargar foto" />
						<div class="tag-container pull-left">
							<img src="" class="option-image img-circle img-responsive" />
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="inputDescription" class="col-sm-2 control-label text-right">Descripción</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="5" id="inputDescription" name="description" required></textarea>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="inputPersEmail" class="col-sm-4 control-label text-right">Correo Personal</label>
					<div class="col-sm-8">
						<input type="email" class="form-control" id="inputPersEmail" name="email1" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCorpEmail" class="col-sm-4 control-label text-right">Correo asignado</label>
					<div class="col-sm-8">
						<input type="email" class="form-control" id="inputCorpEmail" name="email2" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword" class="col-sm-4 control-label text-right">Contraseña</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputPassword" name="password" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputSkype" class="col-sm-4 control-label text-right">Skype ID</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputSkype" name="skype" required>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-lg-3 col-lg-offset-2">
				<input type="submit" class="form-control btn btn-secundary" id="submitTeacher" value="Agregar Profesor">
			</div>
			<div class="col-lg-7">
				<p>Al hacer click en el botón de “Agregar profesor” el sistema enviará automáticamente un mensaje de confirmación al correo personal del profesor con la información contenida en este formulario y instrucciones de logueo en el sistema.</p>
			</div>
		</form>
	<?php else : ?>
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">Módulo de Administrador</div>
		</div>
		<div class="header-message">
			<div class="big color gray ta-center">¡Bienvenido!</div>
			<div class="h5 color gray ta-center">Por favor ingrese su usuario y contraseña para ingresar al módulo de administrador</div>
		</div>
		<?php show_error_messages(); ?>
		<div class="loginForm">
			<form id="loginAdmin" method="post" action="">
				<div class="form-group ta-center">
					<img src="<?php echo get_template_directory_uri(); ?>/images/login_pic.jpg" class="img-circle">
				</div>
				<div class="form-group">
					<input type="text" name="login_username" class="form-control" placeholder="Usuario">
					<input type="password" name="login_password" class="form-control" placeholder="Contraseña">
				</div>
				<input type="hidden" name="login_nonce" value="<?php echo wp_create_nonce('login-nonce'); ?>"/>
				<input type="submit" class="btn btn-primary btn-sm btn-block" value="Ingresar">
			</form>
		</div>
	<?php endif; ?>
	</div>

	<div id="SuccessModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="header-message">
					<div class="titlesmall color gray text-center">Usuario creado</div>

					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">El usuario "<span class="newTeacher"></span>" ha sido creado correctamente.</p>
						<p class="text-center small">Igualmente se ha enviado un correo de confirmación al usuario con las instrucciones de logueo</p>

						<div style="margin: 20px auto; width: 98px">
							<a href="#" class="btn btn-secundary btn-sm class-cancel" data-dismiss="modal">Cerrar / Close</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>