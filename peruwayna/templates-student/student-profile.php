<?php
/**
 * Template Name: Student Panel - Profile
 */

get_header(); ?>

	<div class="container">
	<?php if ( $_COOKIE['student_online'] == 1 ) : ?>
		<?php $user = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE email_student = '".$_COOKIE['student_mail']."' AND password_student = '".$_COOKIE['student_password']."'", OBJECT ); ?>
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">
				Hola <?php echo $user->name_student; ?>!
				<img src="<?php echo get_template_directory_uri(); ?>/lib/utils/timthumb.php?src=<?php echo $user->photo_student; ?>&h=65&w=65" class="img-thumbnail">
				<!-- Single button -->
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						Menu Principal <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo get_site_url() ?>/sistema-de-reservas/">Inicio</a></li>
						<li><a href="<?php echo get_site_url() ?>/sistema-de-reservas/mi-perfil?action=edit">Mi Perfil</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo get_site_url() ?>/sistema-de-reservas/cerrar-sesion">Cerrar Sesión</a></li>
					</ul>
				</div>
			</div>
		</div>

		<form id="updateStudent" class="form-horizontal" method="post" action="" role="form">
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
						<input type="text" class="form-control" id="inputName" name="name" required="" value="<?php echo $user->name_student; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputLastname" class="col-sm-4 control-label text-right">Apellido</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputLastname" name="lastname" required="" value="<?php echo $user->lastname_student; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputMail" class="col-sm-4 control-label text-right">Correo Electrónico</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputMail" name="email" required="" value="<?php echo $user->email_student; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputSkype" class="col-sm-4 control-label text-right">Skype ID</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputSkype" name="skypeID" required="" value="<?php echo $user->skype_student; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputCountry" class="col-sm-4 control-label text-right">País de Residencia</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputCountry" name="country" required="" value="<?php echo $user->country_student; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputCity" class="col-sm-4 control-label text-right">Ciudad de Residencia</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputCity" name="city" required="" value="<?php echo $user->city_student; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputBirthday" class="col-sm-4 control-label text-right">Fecha de Nacimiento</label>
					<div class="col-sm-8">
						<div id="datetimeStart" class="input-group date" data-date-format="mm-dd-yyyy">
							<input type="text" class="form-control" id="inputBirthday" name="birthday" required value="<?php echo $user->birthday_student; ?>">
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputNativeLanguage" class="col-sm-4 control-label text-right">Lengua Nativa</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputNativeLanguage" name="lang" required="" value="<?php echo $user->native_language_student; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputOtherLanguage" class="col-sm-4 control-label text-right">Otras Lenguas</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputOtherLanguage" name="other_lang" required="" value="<?php echo $user->other_language_student; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputWork" class="col-sm-4 control-label text-right">¿En que campo trabaja/estudia?</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputWork" name="ocupation" required="" value="<?php echo $user->campo_student; ?>">
					</div>
				</div>
				<p>¿Cúal es su principal motivación para aprender español?</p>
				<?php $motivation = explode(" ", $user->motivation_student); ?>
				<?php echo $user->motivation_student; ?>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<div class="checkbox">
							<label>
								<?php if (in_array("profesional", $motivation)): $checked = 'checked'; else: $checked = ''; endif; ?>
								<input type="checkbox" id="cb-profesional" value="profesional" <?php echo $checked; ?>> Profesional
							</label>
						</div>
					</div>
					<div class="col-sm-offset-4 col-sm-8">
						<div class="checkbox">
							<label>
								<?php if (in_array("personal", $motivation)): $checked = 'checked'; else: $checked = ''; endif; ?>
								<input type="checkbox" id="cb-personal" value="personal" <?php echo $checked; ?>> Interés Personal
							</label>
						</div>
					</div>
					<div class="col-sm-offset-4 col-sm-8">
						<div class="checkbox">
							<label>
								<?php if (in_array("viaje", $motivation)): $checked = 'checked'; else: $checked = ''; endif; ?>
								<input type="checkbox" id="cb-trip" value="viaje" <?php echo $checked; ?>> Viaje
							</label>
						</div>
					</div>
					<div class="col-sm-offset-4 col-sm-8">
						<div class="checkbox">
							<label>
								<?php if (in_array("otro", $motivation)): $checked = 'checked'; else: $checked = ''; endif; ?>
								<input type="checkbox" id="cb-other" value="otro" <?php echo $checked; ?>> Otro
							</label>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="checkbox">
							<label>
								<?php if($user->offers_student == 1): $checked = 'checked'; else: $checked = ''; endif; ?>
								<input type="checkbox" id="cb-newsletter" value="1" <?php echo $checked; ?>> Quiero recibir ofertas especiales y promociones en mi correo electrónico.
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPicture" class="col-sm-4 control-label text-right">Foto personal</label>
					<div class="col-sm-8">
						<input type="text" id="inputPicture" class="option-input upload preview pexeto-upload pull-left col-sm-8" name="picture" value="<?php echo $user->photo_student; ?>">
						<input type="button" id="inputPicture_button" class="btn btn-secundary pexeto-upload-btn pull-right" value="Cargar foto" />
						<div class="tag-container pull-left">
							<img src="<?php echo $user->photo_student; ?>" class="option-image img-circle img-responsive" />
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
						<input type="text" class="form-control" id="inputPassword" name="password" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="inputRePassword" class="col-sm-4 control-label text-right">Repetir Contraseña Nueva</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputRePassword" name="repassword" disabled>
					</div>
				</div>
				<div class="center-btn">
					<input type="submit" id="updateProfile" class="btn btn-primary btn-sm btn-block" value="Guardar">
				</div>
			</div>

			<div class="bg-success text-center successUpdate" style="border-radius: 5px; display: none; margin: 0 auto; padding: 15px; width: 530px;"><h5>Sus datos fueron guardados correctamente.</h5></div>
		</div>
		</form>

	<?php else : ?>
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">Ingresar al sistema de reservas</div>
		</div>
		<div class="header-message">
			<div class="big color gray ta-center">¡Bienvenido!</div>
			<div class="h5 color gray ta-center">Por favor ingrese su correo y contraseña para ingresar a nuestro sistema de reservas</div>
		</div>
		<div class="newaccount-meesage text-center">
			<p>¿Todavia no esta registrado?</p>
			<a href="<?php echo get_site_url() . '/sistema-de-reservas/registro/'; ?>" class="create">Crear una cuenta nueva</a>
		</div>
		<?php show_error_messages(); ?>
		<div class="loginForm">
			<form id="loginStudent" method="post" action="">
				<div class="form-group ta-center">
					<img src="<?php echo get_template_directory_uri(); ?>/images/login_pic.jpg" class="img-circle">
				</div>
				<div class="form-group">
					<input type="text" name="student_username" class="form-control" placeholder="Dirección de Correo">
					<input type="password" name="student_password" class="form-control" placeholder="Contraseña">
				</div>
				<input type="hidden" name="student_nonce" value="<?php echo wp_create_nonce('student-nonce'); ?>"/>
				<input type="submit" class="btn btn-primary btn-sm btn-block" value="Ingresar">

				<div class="form-group remember">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="student_staylogin" value="yes"> Permanecer conectado
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

	<div id="studentUpdateModal" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="header-message">
					<div class="titlesmall color gray text-center">Datos Actualizados</div>

					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">Tus datos han sido actualizados en nuestro sistema, si cambiaste tu contraseña te recomendamos cerrar sesión y volver
							a ingresar para limpiar las cookies de tu ordenador.</p>

						<div style="margin: 20px auto; width: 150px">
							<a href="#" class="btn btn-secundary btn-sm class-cancel" data-dismiss="modal" style="margin: 20px auto; width: 100px">Ok</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>