<?php
/**
 * Template Name: Student Panel - Register
 */

get_header(); ?>

	<div class="container">
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">Registro de nuevo estudiante</div>
		</div>
		<form id="registerStudent" class="form-horizontal" method="post" action="" role="form">
		<div class="firststep">
			<div class="header-message">
				<div class="medium color gray ta-center">¡Gracias por elegirnos!</div>
				<div class="h5 color gray ta-center">Por favor completa los espacios en blanco con tu información personal</div>
			</div>
			<div class="registerForm">
				<div class="form-group">
					<label for="inputName" class="col-sm-4 control-label text-right">Nombre</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputName" name="name" required="">
					</div>
				</div>
				<div class="form-group">
					<label for="inputLastname" class="col-sm-4 control-label text-right">Apellido</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputLastname" name="lastname" required="">
					</div>
				</div>
				<div class="form-group">
					<label for="inputMail" class="col-sm-4 control-label text-right">Correo Electrónico</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputMail" name="email" required="">
					</div>
				</div>
				<div class="form-group">
					<label for="inputSkype" class="col-sm-4 control-label text-right">Skype ID</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputSkype" name="skypeID" required="">
					</div>
				</div>
				<div class="form-group">
					<label for="inputCountry" class="col-sm-4 control-label text-right">País de Residencia</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputCountry" name="country" required="">
					</div>
				</div>
				<div class="form-group">
					<label for="inputCity" class="col-sm-4 control-label text-right">Ciudad de Residencia</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputCity" name="city" required="">
					</div>
				</div>
				<div class="form-group">
					<label for="inputBirthday" class="col-sm-4 control-label text-right">Fecha de Nacimiento</label>
					<div class="col-sm-8">
						<div id="datetimeStart" class="input-group date" data-date-format="mm-dd-yyyy">
							<input type="text" class="form-control" id="inputBirthday" name="birthday" required>
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputNativeLanguage" class="col-sm-4 control-label text-right">Lengua Nativa</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputNativeLanguage" name="lang" required="">
					</div>
				</div>
				<div class="form-group">
					<label for="inputOtherLanguage" class="col-sm-4 control-label text-right">Otras Lenguas</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputOtherLanguage" name="other_lang" required="">
					</div>
				</div>
				<div class="form-group">
					<label for="inputWork" class="col-sm-4 control-label text-right">¿En que campo trabaja/estudia?</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputWork" name="ocupation" required="">
					</div>
				</div>
				<p>¿Cúal es su principal motivación para aprender español?</p>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<div class="checkbox">
							<label>
								<input type="checkbox" id="cb-profesional" value="profesional"> Profesional
							</label>
						</div>
					</div>
					<div class="col-sm-offset-4 col-sm-8">
						<div class="checkbox">
							<label>
								<input type="checkbox" id="cb-personal" value="personal"> Interés Personal
							</label>
						</div>
					</div>
					<div class="col-sm-offset-4 col-sm-8">
						<div class="checkbox">
							<label>
								<input type="checkbox" id="cb-trip" value="viaje"> Viaje
							</label>
						</div>
					</div>
					<div class="col-sm-offset-4 col-sm-8">
						<div class="checkbox">
							<label>
								<input type="checkbox" id="cb-other" value="otro"> Otro
							</label>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="checkbox">
							<label>
								<input type="checkbox" id="cb-newsletter" value="1"> Quiero recibir ofertas especiales y promociones en mi correo electrónico.
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPicture" class="col-sm-4 control-label text-right">Foto personal</label>
					<div class="col-sm-8">
						<input type="text" id="inputPicture" class="option-input upload preview pexeto-upload pull-left col-sm-8" name="picture" required>
						<input type="button" id="inputPicture_button" class="btn btn-secundary pexeto-upload-btn pull-right" value="Cargar foto" />
						<div class="tag-container pull-left">
							<img src="" class="option-image img-circle img-responsive" />
						</div>
					</div>
				</div>
				<div class="center-btn">
					<a href="" id="nextStep" class="btn btn-primary btn-sm btn-block">Siguiente</a>
				</div>
			</div>
		</div>
		<div class="secondstep">
			<div class="header-message">
				<div class="titlesmall color gray ta-center">Por favor elige una contraseña</div>
				<div class="h5 color gray ta-center">Utilizarás esta contraseña de seguridad para ingresar a nuestro sistema de reservas</div>
			</div>
			<div class="registerForm">
				<div class="form-group">
					<label for="inputPassword" class="col-sm-4 control-label text-right">Contraseña</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="inputPassword" name="password" required="">
					</div>
				</div>
				<div class="form-group">
					<label for="inputRePassword" class="col-sm-4 control-label text-right">Repetir contraseña</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="inputRePassword" name="repassword" required="">
					</div>
				</div>
				<div class="center-btn">
					<input type="submit" id="registerStep" class="btn btn-primary btn-sm btn-block" value="Finalizar">
				</div>
			</div>
		</div>
		</form>

		<div id="thankMessage" class="text-center">
			<img src="<?php echo get_template_directory_uri(); ?>/images/thank-image.jpg" style="margin-bottom: 20px">
			<div class="h5 color gray text-center">Su información ha sido correctamente registrada en nuestro sistema.<br/>Recibirá un correo de confirmación en breve con simples instrucciones<br/>
				finales para confirmar su dirección de correo electrónico.</div>
			<div class="center-btn">
				<a href="<?php echo get_site_url() ?>/sistema-de-reservas/" class="btn btn-primary btn-sm btn-block">Ingresar al sistema</a>
			</div>				
		</div>
	</div>

<?php get_footer(); ?>