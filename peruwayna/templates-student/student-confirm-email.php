<?php
/**
 * Template Name: Student Panel - Confirm
 */

get_header(); ?>

	<?php

	global $wpdb;
      
    $results = $wpdb->get_row("SELECT * FROM wp_bs_student WHERE skype_student = '" . $_GET['i'] . "' AND email_confirm = 0", 'ARRAY_A');

    if( $results['skype_student'] == $_GET['i'] ) :

    	$wpdb->update( 
			'wp_bs_student', 
			array( 
				'email_confirm' => 1,	// string
			), 
			array( 'skype_student' => $_GET['i'] ), 
			array( 
				'%d',	// value1
			), 
			array( '%s' ) 
		);

	?>

	<div class="container">
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">Registro de nuevo estudiante</div>
		</div>
		<div class="header-message">
			<div class="titlesmall color gray ta-center">¡Confirmación completa!</div>
			<div class="h5 color gray ta-center">Su dirección de correo electrónico ha sido correctamente verificada<br/>¡Ahora puede ingresar a nuestro sistema de reservas y organizar su próxima clase de español!</div>
		</div>
		<div class="center-btn">
			<a href="<?php echo get_site_url() ?>/sistema-de-reservas/" class="btn btn-primary btn-sm btn-block">Ingresar al sistema</a>
		</div>
	</div>
	<?php else: ?>

	<div class="container">
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">Registro de nuevo estudiante</div>
		</div>
		<div class="header-message">
			<div class="titlesmall color gray ta-center">¡Tu confirmación ya fue completada!</div>
			<div class="h5 color gray ta-center">Su dirección de correo electrónico ya ha sido correctamente verificada<br/>¡Ya puedes ingresar a nuestro sistema de reservas y organizar su próxima clase de español!</div>
		</div>
		<div class="center-btn">
			<a href="<?php echo get_site_url() ?>/sistema-de-reservas/" class="btn btn-primary btn-sm btn-block">Ingresar al sistema</a>
		</div>
	</div>

	<?php endif; ?>

<?php get_footer(); ?>