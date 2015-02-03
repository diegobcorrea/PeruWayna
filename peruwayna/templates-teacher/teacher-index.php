<?php
/**
 * Template Name: Teacher Panel - Login & Home
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
				<div class="h4 add-bottom"><strong>Agregar disponibilidad de horarios</strong></div>

				<div id="chooseBox" class="col-md-12">
					<div class="col-md-4">
						<div class="h4 add-bottom"><strong>Agregar disponibilidad laboral</strong></div>
						<strong>Instrucciones</strong>
						<ul class="list-number">
							<li>Seleccione un día</li>
							<li>Marque los horarios en los que se encuentra disponible para hacer una clase por internet.</li>
							<li>Seleccione otro día para agregar su disponibilidad.</li>
						</ul>
					</div>
					<div class="col-md-8">
						<div class="wrapper-loader">
							<div class="loader"></div>
						
							<div class="datepicker-embed">
								<div id="choosePicker"></div>
							</div>
							<?php 

							$h = "5";
							$hm = $h * 60; 
							$ms = $hm * 60;

							$time = date('h:i A',time()-($ms));

							?>
							<form class="chooseHours">
								<ul>
									<?php 

									$hour_1 = '12:00 AM';

									for ($i = 0; $i < 12; $i++) : ?>
									<li>
										<div class="checkbox">
											<label>
												<input type="checkbox" value="<?php echo $hour_1; ?>"> <?php echo $hour_1; ?>
											</label>
										</div>
									</li>
									<?php $hour_1 = date("h:i A", strtotime('+30 minutes', strtotime($hour_1) ) ); endfor; ?>
								</ul>
								<ul>
									<?php 

									$hour_2 = '06:00 AM';

									for ($i = 0; $i < 12; $i++) : ?>
										<li><div class="checkbox"><label><input type="checkbox" value="<?php echo $hour_2; ?>"> <?php echo $hour_2; ?></label></div></li>
									<?php $hour_2 = date("h:i A", strtotime('+30 minutes', strtotime($hour_2) ) ); endfor; ?>
								</ul>
								<ul>
									<?php 

									$hour_3 = '12:00 PM';

									for ($i = 0; $i < 12; $i++) : ?>
										<li><div class="checkbox"><label><input type="checkbox" value="<?php echo $hour_3; ?>"> <?php echo $hour_3; ?></label></div></li>
									<?php $hour_3 = date("h:i A", strtotime('+30 minutes', strtotime($hour_3) ) ); endfor; ?>
								</ul>
								<ul>
									<?php 

									$hour_4 = '06:00 PM';

									for ($i = 0; $i < 12; $i++) : ?>
										<li><div class="checkbox"><label><input type="checkbox" value="<?php echo $hour_4; ?>"> <?php echo $hour_4; ?></label></div></li>
									<?php $hour_4 = date("h:i A", strtotime('+30 minutes', strtotime($hour_4) ) ); endfor; ?>
								</ul>
								<input type="hidden" id="chooseDate" name="chooseDate">
								<input type="hidden" id="id_teacher" name="id_teacher" value="<?php echo $teacher->id_teacher; ?>">
							</form>
						</div>
						<div class="legendColor">
							<div class="active"><span></span>Seleccionado</div>
							<div class="oneclass"><span></span>Días con al menos un horario de clases</div>
							<div class="noclass"><span></span>Días sin ningún horario de clases</div>
						</div>

					</div>
				</div>

				<div class="col-md-10 col-md-offset-1">
					<p><strong>NOTA:</strong> Sea cuidadoso en marcar sus horas de disponibilidad. Una vez que marca un horario no podrá desmarcarlo. 
						Si marcó una de las horas por equivocación puede cancelarla en la página de <a href="#">mi programa de clases</a>.</p>
				</div>
			</div>

			<script type="text/javascript">
				var id_teacher = <?php echo $teacher->id_teacher; ?>
			</script>
		</div>
	<?php else : ?>
		<div class="panel panel-teacher-primary text-right">
			<div class="panel-heading">Módulo de profesor</div>
		</div>
		<div class="header-message">
			<div class="big color gray ta-center">¡Bienvenido!</div>
			<div class="h5 color gray ta-center">Por favor ingrese su correo y contraseña para ingresar al módulo de profesor</div>
		</div>
		<div class="newaccount-meesage text-center">
			<p>¿Todavia no esta registrado?</p>
			<a href="http://www.peruwaynagroup.com/#!contact/c1d94" class="create">Solicite un usuario a nuestro Coordinador Académico</a>
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
					<a href="#" class="recoverTeacherPass">¿Olvidó su contraseña?</a>
				</div>
			</form>
		</div>
	<?php endif; ?>
	</div>

	<div id="PasswordTeacher" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="completeForm" class="header-message">
					<div class="titlesmall color gray text-center">¿Olvidó su contraseña?</div>

					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">Ingresa tu correo electrónico personal para obtener una nueva contraseña</p>

						<form id="recoverPass" method="post" action="">
							<div class="form-group">
								<input type="text" id="teacher_email" name="teacher_email" class="form-control" placeholder="Dirección de Correo">
							</div>
							<input type="submit" class="btn btn-primary btn-sm btn-block changePass" value="Cambiar contraseña">
						</form>
					</div>
				</div>

				<div id="passSend" class="header-message" style="display: none">
					<div class="titlesmall color gray text-center">¡Su contraseña fue cambiada con éxito!</div>

					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">Te hemos enviado un mensaje a tu correo electrónico con tu nuevo contraseña.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>