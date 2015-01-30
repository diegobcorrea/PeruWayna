<?php
/**
 * Template Name: Student Panel - Booking Teacher
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
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo get_site_url() ?>/sistema-de-reservas/">Inicio</a></li>
						<li><a href="<?php echo get_site_url() ?>/sistema-de-reservas/mi-perfil?action=edit">Mi Perfil</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo get_site_url() ?>/sistema-de-reservas/cerrar-sesion">Cerrar Sesión</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div id="booking-class" class="row step-one">
			<div class="col-md-12 add-bottom">
				<div class="h4 add-bottom"><strong>PASO 1: Seleccionar mi profesor</strong></div>
			</div>

			<div class="col-md-12 add-bottom">
				<?php

				global $wpdb;
				$getTeachers = $wpdb->get_results( "SELECT * FROM wp_bs_teacher", OBJECT );

				?>
				<?php foreach ($getTeachers as $teacher) : ?>
				<div class="col-md-4 add-bottom">
					<div class="col-md-5 no-padding">
						<img src="<?php echo get_template_directory_uri(); ?>/lib/utils/timthumb.php?src=<?php echo $teacher->photo_teacher; ?>&h=115&w=115" class="img-circle" />
					</div>
					<div class="col-md-7 no-padding add-top">
						<h5><?php echo $teacher->name_teacher; ?> <?php echo $teacher->lastname_teacher; ?></h5>
						<a href="#" id="select-teacher" class="btn btn-secundary btn-sm" data-teacher="<?php echo $teacher->id_teacher; ?>">Seleccionar</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div id="booking-class" class="row step-two" style="display: none;">
			<div class="col-md-12 add-bottom">
				<div class="h4 add-bottom"><strong>PASO 2: Seleccionar mis días de clase</strong></div>
			</div>

			<div id="teacher-info" class="col-md-12 add-bottom"></div>
		</div>

		<script type="text/javascript">var id_student = <?php echo $user->id_student; ?>;</script>
	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/sistema-de-reservas/'; ?>");
		</script>
	<?php endif; ?>
	</div>

<?php get_footer(); ?>