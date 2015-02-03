<?php
/**
 * Template Name: Student Panel - Booking a Class
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
					<?php include( TEMPLATEPATH . '/templates-student/student-menu.php'); ?>
				</div>
			</div>
		</div>

		<div id="buyhours-details" class="row">
			<div class="header-message">
				<div class="titlesmall color gray text-center">¡Vamos a reservar tu próxima clase!</div>
			</div>

			<div class="col-md-5 text-center">
				<div class="h4">Hacer una reserva<br/>seleccionando mi profesor</div>
				<img src="<?php echo get_template_directory_uri(); ?>/images/icons/lg/ico-lg-teachers.png" class="center-block">
				<a href="<?php echo get_site_url() . '/sistema-de-reservas/reservar-una-clase/profesor/'; ?>" class="btn btn-secundary btn-lg">¡Vamos!</a>
			</div>
			<div class="col-md-2 text-center">
				<h1>o</h1>
			</div>
			<div class="col-md-5 text-center">
				<div class="h4">Hacer una reserva<br/>seleccionando un horario</div>
				<img src="<?php echo get_template_directory_uri(); ?>/images/icons/lg/ico-lg-calendar.png" class="center-block">
				<a href="<?php echo get_site_url() . '/sistema-de-reservas/reservar-una-clase/dia-horario/'; ?>" class="btn btn-secundary btn-lg">¡Vamos!</a>
			</div>

			<script type="text/javascript">
				var id_student = <?php echo $user->id_student; ?>
			</script>
		</div>
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

	<div id="InfoModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="has-class-plus">
					<div class="header-message">
						<div class="titlesmall color gray text-center">Cancelar mi clase</div>

						<div style="margin: 0 auto; width: 67.66666667%;">
							<p class="text-center small">Estas cancelando una clase con más de 48 horas de anticipación.</p>
							<p class="text-center small">Devolveremos las horas de clase canceladas a tu balance para que puedas reservar nuevas clases cuando quieras.</p>
							<p class="text-center small">Nuestro sistema actualizará la clase al estado de "Cancelada" y tu profesor será alertado para que no espere por ti.</p>
							<p class="text-center small">Igualmente nuestro sistema ya no te enviará más recordatorios para que asistas a esta clase.</p>

							<div class="h5 color gray text-center">¿Estás seguro que deseas cancelas esta clase?</div>
							<div style="margin: 20px auto; width: 305px">
								<a href="#" class="btn btn-secundary btn-sm class-cancelclass">Si, cancelar mi clase</a>
								<a href="#" class="btn btn-secundary btn-sm class-cancel" data-dismiss="modal">No quiero cancelar mi clase</a>
							</div>
						</div>
					</div>
				</div>
				<div class="has-class-minus">
					<div class="header-message">
						<div class="titlesmall color gray text-center">¡Por favor espera!</div>

						<div style="margin: 0 auto; width: 66.66666667%;">
							<p class="text-center small">Estas tratando de cancelar una de tus clases con menos de 48 horas de anticipación.</p>
							<p class="text-center small">Si continuas con la cancelación perderás tu clase y no podrás recuperarla posteriormente.</p>

							<div class="h5 color gray text-center">¿Estás seguro que deseas cancelas esta clase?</div>
							<div style="margin: 20px auto; width: 285px">
								<a href="#" class="btn btn-secundary btn-sm class-cancelclass">Si, estoy seguro</a>
								<a href="#" class="btn btn-secundary btn-sm class-cancel" data-dismiss="modal">No quiero cancelar mi clase</a>
							</div>
						</div>
					</div>
				</div>
				<div class="not-class">
					<div class="header-message">
						<div class="titlesmall color gray text-center">¡Lo sentimos mucho!</div>
						<div class="h5 color gray text-center add-bottom">Por motivos de emergencia tu profesor canceló una de las clases que habías reservado</div>

						<div style="margin: 0 auto; width: 66.66666667%;">
							<p class="text-center small">Te hemos enviado un correo electrónico con los detalles de la clase cancelada<br/> y también puedes ver los detalles de la cancelación
								en el menú principal.</p>
							<p class="text-center small">El sistema ya no te enviará recordatorios para esta clase.</p>

							<div class="text-center boxtron red">
								<p>Como señal de disculpa nos gustaría regalarte el 50%<br/>del tiempo de tu clase, lo cual es equivalente a</p>
								<h1>15 minutos de clase GRATIS</h1>
							</div>

							<p class="text-center small">El crédito de regalo ha sido cargado automáticamente<br/> a tu balance y podrás utilizarlo cuando quieras.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="SuccessModal" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="header-message">
					<div class="titlesmall color gray text-center">Tu clase ha sido cancelada</div>

					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">Te hemos enviado un correo electrónico con los detalles de la cancelación.</p>
						<p class="text-center small">Nuestro sistema ya no te enviará recordatorios para que asistas a tu clase e informaremos a tu profesor<br/>
							sobre la cancelación para que no espere por ti.</p>

						<div style="margin: 20px auto; width: 150px">
							<a href="#" class="btn btn-secundary btn-sm class-cancel" onClick="location.reload();">Regresar al menú principal</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>