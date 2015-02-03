<?php
/**
 * Template Name: Student Panel - Confirm Pay
 */

session_start();

get_header(); ?>

	<div class="container">
	<?php if ( $_COOKIE['student_online'] == 1 ) : ?>
		<?php $user = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE email_student = '".$_COOKIE['student_mail']."' AND password_student = '".$_COOKIE['student_password']."'", OBJECT ); ?>
		<?php $_SESSION['hours_in_balance'] = $user->hours_in_balance; ?>
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

		<?php
		if( isset($_SESSION['needtobuy']) && $_SESSION['needtobuy'] != '' ):
			$return_url = "<?php echo get_site_url() ?>/sistema-de-reservas/confirmas-clases/";
		else:
			$return_url = "<?php echo get_site_url() ?>/sistema-de-reservas/";
		endif;
		?>



		<div id="buyclass" class="row">
			<div class="header-message">
				<div class="titlesmall color gray text-center">¡Su pago se realizó con exito!</div>
				<div class="h5 color gray ta-center">La ventana se cargará en <span id="count">5</span> segundos o de click <a href="<?php echo $return_url; ?>">aquí</a></div>
			</div>

			<script type="text/javascript">
				var id_student = <?php echo $user->id_student; ?>;
				var return_url = "<?php echo $return_url; ?>";
				var counter = 5;

				setInterval(function() {
					counter--;
					if (counter >= 0) {
						span = document.getElementById("count");
						span.innerHTML = counter;
					}
					// Display 'counter' wherever you want to display it.
					if (counter === 0) {
						clearInterval(counter);
						window.location.replace(return_url);
					}
				}, 1000);
			</script>
		</div>
	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/sistema-de-reservas/'; ?>");
		</script>
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