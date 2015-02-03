<?php
/**
 * Template Name: Student Panel - Confirm Hours
 */

get_header(); 

session_start();

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
					<?php include( TEMPLATEPATH . '/templates-student/student-menu.php'); ?>
				</div>
			</div>
		</div>

		<?php if( $_SESSION['hours_in_balance'] < $_SESSION['numClass'] ): ?>
		<?php $_SESSION['needtobuy'] = $_SESSION['hours_in_balance'] - $_SESSION['numClass']; ?>
		<div id="buyclass" class="row">
			<div class="header-message">
				<div class="titlesmall color gray text-center">¡Opps! Necesitas comprar más clases</div>
			</div>
			<div class="col-md-12 add-bottom">
				<div class="col-md-2 col-md-offset-1 text-center">
					<h4>Tienes</h4>
					<div class="box red">
						<?php echo m2h($_SESSION['hours_in_balance']); ?>
					</div>
					<span>horas compradas<br/>en tu balance</span>
				</div>
				<div class="col-md-1 text-center">
					<h1 class="separator" style="line-height: 2.1em;">-</h1>
				</div>
				<div class="col-md-2 text-center">
					<h4>Deseas reservar</h4>
					<div class="box red">
						<?php echo m2h($_SESSION['numClass']); ?>
					</div>
					<span>horas de clase</span>
				</div>
				<div class="col-md-1 text-center">
					<h1 class="separator" style="line-height: 2.1em;">=</h1>
				</div>
				<div class="col-md-4 text-center">
					<h4>Necesitas comprar al menos</h4>
					<div class="box red">
						<?php echo m2h($_SESSION['hours_in_balance'] - $_SESSION['numClass']); ?>
					</div>
					<span>horas de clase</span>
				</div>
			</div>
			<div class="col-md-12 add-bottom">
				<div class="col-md-4 col-md-offset-1 text-center">
				</div>
				<div class="col-md-2 text-center">
					
				</div>
				<div class="col-md-4 text-center">
					<div class="box gray">
						<div style="display: inline-block; vertical-align: top; width:48%;">
							<p>Comprar un paquete de horas</p>
							<a href="#" id="buy-hourpack" class="btn btn-secundary btn-sm">Vamos</a>
						</div>
						<div style="display: inline-block; width:49%;">
							<img src="<?php echo get_template_directory_uri(); ?>/images/pack-image.jpg" style="width: 100%">
						</div>
					</div>
					<h1 style="line-height: 0.3em; margin-bottom: 25px;">o</h1>
					<div class="box gray">
						<p>Pagar solamente mis<br/>horas reservadas</p>
						<a href="#" id="buy-hourstopay" class="btn btn-secundary btn-sm">Vamos</a>
					</div>
				</div>
			</div>
		</div>
		<div id="buy-onlybooked" class="row" style="display:none">
			<div class="header-message">
				<div class="titlesmall color gray text-center">Pagar solamente mis clases reservadas</div>
			</div>
			<div class="col-md-12 add-bottom">
				<div class="col-md-2 col-md-offset-1 text-center">
					<h4 style="font-size: 19px;">Usted necesita pagar</h4>
					<div class="box red">
						<?php echo m2h($_SESSION['needtobuy']); ?>
					</div>
					<span>hora(s) para completar<br/>su reserva de clases</span>
				</div>
				<div class="col-md-1 text-center">
					<h1 class="separator" style="line-height: 2.9em;">x</h1>
				</div>
				<div class="col-md-2 text-center">
					<h4 style="font-size: 19px;">Cada clase cuesta</h4>
					<div class="box red">
						US$ 16
					</div>
				</div>
				<div class="col-md-1 text-center">
					<h1 class="separator" style="line-height: 2.9em;">=</h1>
				</div>
				<div class="col-md-4 text-center">
					<h4 style="margin-top: 30px">Pago total</h4>
					<div class="box red add-bottom">
						US$ <?php echo ($_SESSION['needtobuy']/60) * 16 * -1; ?>
					</div>
					<script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=businesstestpaypal@peruwayna.com" 
					    data-button="buynow" 
					    data-name="Buy Reserved Hours" 
					    data-amount="<?php echo ($_SESSION['needtobuy']/60) * 16 * -1; ?>" 
					    data-currency="USD" 
					    data-quantity="1"
					    data-custom="<?php echo $user->id_student; ?>"
					    data-callback="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/confirmas-clases/"
					    data-return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/pago-efectuado/"
					    data-rm="2"
					    data-cancel_return="http://carlosmarruffo.com/clientes/peruwayna/sistema-de-reservas/"
					    data-notify_url="http://carlosmarruffo.com/clientes/peruwayna/notificacion/?hours=<?php echo $_SESSION['needtobuy'] * -1; ?>"
					    data-host="www.sandbox.paypal.com"
					    data-env="sandbox"
					></script>
				</div>
			</div>
		</div>
		<div id="buy-package" class="row" style="display:none">
			<div class="header-message">
				<div class="titlesmall color gray text-center">Comprar un paquete de clases</div>
			</div>
			<div class="col-md-12 add-bottom">
				<div class="col-md-4 col-md-offset-1 text-center">
					<h4 class="small" style="margin-top: 30px">Recuerda que necesitas comprar<br/>un paquete de</h4>
					<div class="box red half-bottom">
					<?php 
						$value = $_SESSION['needtobuy']*-1;

						if($value <= 180):
							echo "3 horas";
						elseif($value <= 600):
							echo "10 horas";
						elseif($value <= 1800):
							echo "30 horas";
						elseif($value <= 3600):
							echo "60 horas";
						endif;
					?>
					</div>
					<span class="small">para completar tu reserva<br/>de tus clases seleccionadas!</span>
				</div>
				<div class="col-md-7 text-center" style="margin-top: 95px;">
					<p>Por favor escoje uno de los paquetes y confirma tu compra<br/>presionando el botón de "Buy Now" (Comprar ahora)</p>
				</div>
			</div>
			<div class="col-md-12 add-bottom">				
				<div class="list-group col-md-6 col-md-offset-3">
					<div class="list-group-item">
						<div class="text-center" style="display: inline-block;">
							<p class="list-group-item-text"><strong>paquete de 3 horas = US$45</strong></p>
							<p class="list-group-item-text">(Comprando este paquete cada hora te cuesta US$15)</p>
							<small>¡Ahorra hasta US$3 con esta opción!</small>
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
							<p class="list-group-item-text"><strong>paquete de 10 horas = US$140</strong></p>
							<p class="list-group-item-text">(Comprando este paquete cada hora te cuesta US$14)</p>
							<small>¡Ahorra hasta US$20 con esta opción!</small>
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
							<p class="list-group-item-text"><strong>paquete de 30 horas = US$390</strong></p>
							<p class="list-group-item-text">(Comprando este paquete cada hora te cuesta US$13)</p>
							<small>¡Ahorra hasta US$20 con esta opción!</small>
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
							<p class="list-group-item-text"><strong>paquete de 60 horas = US$720</strong></p>
							<p class="list-group-item-text">(Comprando este paquete cada hora te cuesta US$12)</p>
							<small>¡Ahorra hasta US$20 con esta opción!</small>
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
			</div>
		</div>
		<?php elseif( $_SESSION['hours_in_balance'] >= $_SESSION['numClass'] ): ?>
		<div id="buyclass" class="row">
			<div class="header-message add-bottom">
				<div class="titlesmall color gray text-center">Confirmar mi reserva de clases</div>
			</div>
			<div class="col-md-2 col-md-offset-1 text-center">
				<h4>Tienes</h4>
				<div class="box red">
					<?php echo m2h($_SESSION['hours_in_balance']); ?>
				</div>
				<span>horas compradas<br/>en tu balance</span>
			</div>
			<div class="col-md-1 text-center">
				<h1 class="separator" style="line-height: 2.3em;">&</h1>
			</div>
			<div class="col-md-2 text-center">
				<h4>Deseas reservar</h4>
				<div class="box red">
					<?php echo m2h($_SESSION['numClass']); ?>
				</div>
				<span>horas de clase</span>
			</div>
			<div class="col-md-1 text-center">
				<h1 class="separator" style="line-height: 2.1em;">=</h1>
			</div>
			<div class="col-md-4 text-center">
				<div class="box red small">
					<p>¡Puedes reservar tus clases ahora mismo!</p>
					<a href="#" id="finish-booking" class="btn btn-secundary btn-md" data-student="<?php echo $user->id_student; ?>">Finalizar mi reserva</a>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<script type="text/javascript">var id_student = <?php echo $user->id_student; ?>;</script>
	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/sistema-de-reservas/'; ?>");
		</script>
	<?php endif; ?>
	</div>

	<div id="finishBookingModal" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="header-message">
					<div class="titlesmall color gray text-center">¡Felicitaciones!</div>

					<div style="margin: 0 auto;">
						<p class="text-center small">¡Tus clases han sido correctamente reservadas!</p>
						<p class="text-center small">Te hemos enviado un correo electrónico con los detalles de tus clases confirmadas.<br/>
							También puedes ver el detalle de tus clases en el menú principal</p>
						<p class="text-center small">Adicionalmente nuestro sistema te enviará un recordatorio 24 horas antes del inicio de cada clase.</p>
						<p class="text-center small">Finalmente recuerda que si deseas cancelar una clase, por favor hazlo con al menos<br/>48 horas de anticipación
							para poder recuperarla posteriormente.</p>
						<p class="text-center small">Si cancelas una clase con menos de 48 horas de anticipación lamentablemente perderás tu clase.</p>

						<div style="margin: 20px auto; width: 150px">
							<a href="#" class="btn btn-secundary btn-sm class-cancel" onClick="window.location.replace('<?php echo get_site_url() . "/sistema-de-reservas/"; ?>')">Regresar al menú principal</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>