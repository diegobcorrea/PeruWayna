<?php
/**
 * Template Name: Student Panel - Buy Hours
 */

get_header(); 

session_start();

$_SESSION['uniqID'] = md5(uniqid(rand(), true));

?>

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

		<div id="buyhours-details" class="row">
			<div class="header-message">
				<div class="titlesmall color gray text-center">Comprar horas de clase</div>
			</div>

			<div class="list-group col-md-6 col-md-offset-3">
				<div class="list-group-item">
					<div class="text-center" style="display: inline-block;">
						<p class="list-group-item-text">paquete de 3 horas</p>
						<h4 class="list-group-item-heading">US$15/hora</h4>
						<small>¡Ahora hasta US$3 con esta opción!</small>
					</div>
					<div class="text-center pull-right" style="display: inline-block; margin: 16px 8px 0;">
						<script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=businesstestpaypal@peruwayna.com" 
						    data-button="buynow" 
						    data-name="Buy Reserved Hours" 
						    data-amount="15" 
						    data-currency="USD" 
						    data-quantity="3"
						    data-custom="<?php echo $user->id_student; ?>"
						    data-callback="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/confirmas-clases/"
						    data-return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/pago-efectuado/"
						    data-rm="2"
						    data-cancel_return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/"
						    data-notify_url="http://carlosmarruffo.com/clientes/peruwayna/notificacion/"
						    data-host="www.sandbox.paypal.com"
						    data-env="sandbox"
						></script>
					</div>
				</div>
			</div>

			<div class="list-group col-md-6 col-md-offset-3">
				<div class="list-group-item">
					<div class="text-center" style="display: inline-block;">
						<p class="list-group-item-text">paquete de 10 horas</p>
						<h4 class="list-group-item-heading">US$14/hora</h4>
						<small>¡Ahora hasta US$20 con esta opción!</small>
					</div>
					<div class="text-center pull-right" style="display: inline-block; margin: 16px 8px 0;">
						<script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=businesstestpaypal@peruwayna.com" 
						    data-button="buynow" 
						    data-name="Buy Reserved Hours" 
						    data-amount="14" 
						    data-currency="USD" 
						    data-quantity="10"
						    data-custom="<?php echo $user->id_student; ?>"
						    data-callback="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/confirmas-clases/"
						    data-return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/pago-efectuado/"
						    data-rm="2"
						    data-cancel_return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/"
						    data-notify_url="http://carlosmarruffo.com/clientes/peruwayna/notificacion/"
						    data-host="www.sandbox.paypal.com"
						    data-env="sandbox"
						></script>
					</div>
				</div>
			</div>

			<div class="list-group col-md-6 col-md-offset-3">
				<div class="list-group-item">
					<div class="text-center" style="display: inline-block;">
						<p class="list-group-item-text">paquete de 30 horas</p>
						<h4 class="list-group-item-heading">US$13/hora</h4>
						<small>¡Ahora hasta US$90 con esta opción!</small>
					</div>
					<div class="text-center pull-right" style="display: inline-block; margin: 16px 8px 0;">
						<script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=businesstestpaypal@peruwayna.com" 
						    data-button="buynow" 
						    data-name="Buy Reserved Hours" 
						    data-amount="13" 
						    data-currency="USD" 
						    data-quantity="30"
						    data-custom="<?php echo $user->id_student; ?>"
						    data-callback="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/confirmas-clases/"
						    data-return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/pago-efectuado/"
						    data-rm="2"
						    data-cancel_return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/"
						    data-notify_url="http://carlosmarruffo.com/clientes/peruwayna/notificacion/"
						    data-host="www.sandbox.paypal.com"
						    data-env="sandbox"
						></script>
					</div>
				</div>
			</div>

			<div class="list-group col-md-6 col-md-offset-3">
				<div class="list-group-item">
					<div class="text-center" style="display: inline-block;">
						<p class="list-group-item-text">paquete de 60 horas</p>
						<h4 class="list-group-item-heading">US$12/hora</h4>
						<small>¡Ahora hasta US$240 con esta opción!</small>
					</div>
					<div class="text-center pull-right" style="display: inline-block; margin: 16px 8px 0;">
						<script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=businesstestpaypal@peruwayna.com" 
						    data-button="buynow" 
						    data-name="Buy Reserved Hours" 
						    data-amount="12" 
						    data-currency="USD" 
						    data-quantity="60"
						    data-custom="<?php echo $user->id_student; ?>"
						    data-callback="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/confirmas-clases/"
						    data-return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/pago-efectuado/"
						    data-rm="2"
						    data-cancel_return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/"
						    data-notify_url="http://carlosmarruffo.com/clientes/peruwayna/notificacion/"
						    data-host="www.sandbox.paypal.com"
						    data-env="sandbox"
						></script>
					</div>
				</div>
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

<?php get_footer(); ?>