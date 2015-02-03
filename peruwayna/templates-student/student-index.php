<?php
/**
 * Template Name: Student Panel - Login & Home
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

		<div id="middle-menu">
			<div class="level-box text-center col-margin">
				<?php $getLevel = $wpdb->get_row( "SELECT * FROM wp_bs_levels WHERE id_level = {$user->level_student}", OBJECT ); ?>
				<h6 class="no-margin">Mi nivel de español</h6>
				<h1 class="medium no-margin"><?php echo $getLevel->level_prefix; ?></h1>
				<h6 class="no-margin"><?php echo $getLevel->level_name; ?></h6>
			</div>
			<div class="hours-used-box text-center col-margin">
				<?php $getSH = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $user->id_student AND status = 'COMPLETADA'" ); ?>
				<?php $hours = m2h($getSH[0]->total * 30); ?>
				<h6 class="no-margin">He estudiado</h6>
				<h1 class="medium no-margin"><?php echo $hours; ?></h1>
				<h6 class="no-margin">horas de español</h6>
			</div>
			<div class="myhours-box col-margin">
				<div>
					<h6 class="no-margin">Tengo</h6>
					<h1 class="titlesmall no-margin"><?php echo m2h($user->hours_in_balance); ?></h1>
					<h6 class="float">horas compradas para estudiar español</h6>
				</div>
				<a href="<?php echo get_site_url() . '/sistema-de-reservas/comprar-horas/'; ?>" class="btn btn-secundary btn-xs pull-right">Comprar más horas</a>
			</div>
		</div>

		<div id="class-details" class="row">
			<div class="col-md-10 col-md-offset-1 add-bottom">
				<div class="h4 add-bottom"><strong>Detalle de mis próximas clases:</strong></div>
				<p class="add-bottom"><strong>Notar:</strong> Todas las horas de clase mostradas son horas locales de Perú (UTC -5:00)<br/>
					<strong>Please Note:</strong> All class hours are displayed in Peruvian local time (UTC -5:00)</p>

				<script type="text/javascript">
				jQuery(document).ready(function() {
				    jQuery('#myclasses-student').dataTable( {
				        "scrollY":        "507px",
				        "scrollCollapse": true,
				        "paging":         false,
				        "order": [ [0,"asc"], [1,"asc"], [2,"asc"] ],
				        "columnDefs": [ {
			                "targets": [ 0 ],
			                "visible": false,
			                "searchable": false
			            } ],
			            "language": {
							"zeroRecords": "<b>No tienes ninguna clase reservada comenzando próximamente.</b><br/>You don't have any reserved class starting soon."
						} 
				    } );

				    var body_height = parseInt(jQuery('#myclasses-student_wrapper .dataTables_scrollBody').height());

				    jQuery('#myclasses-student_wrapper .dataTables_scrollBody').height(body_height + 30);
				} );
				</script>
				<table id="myclasses-student" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-center" style="width: 70px">Orden</th>
							<th class="text-center" style="width: 270px">Día</th>
							<th class="text-center" style="width: 100px">Desde</th>
							<th class="text-center" style="width: 100px">Hasta</th>
							<th class="text-center">Profesor</th>
							<th class="text-center">Estado</th>
							<th class="text-center">Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php

						global $wpdb, $dias, $meses;
						$h = "5";
					    $hm = $h * 60; 
					    $ms = $hm * 60;

						$now = date('Y-m-d',time()-($ms));
						$time = date('h:i A',time()-($ms));
						$getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_student = $user->id_student AND date_class >= '$now' ORDER BY date_class ASC", OBJECT );

						foreach ($getClasses as $key => $class) : 
							if($class->status == "CONFIRMADA" || $class->status == "SUSPENDIDA"):
								$date = explode("-", $class->date_class);
								$formatDate = $date[0].'-'.$date[1].'-'.$date[2] . $class->start_class;
								$date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] . $class->start_class ); 

								$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
								$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

							    $today = date('Y-m-d h:i A',time()-($ms));

		   						$dteStart = new DateTime($today); 
		   						$dteEnd   = new DateTime($formatDate);

		   						$dteDiff  = $dteStart->diff($dteEnd);
		   						$hours = $dteDiff->h;
								$hours = $hours + ($dteDiff->days*24);

								if($class->id_teacher != 0){
									$getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = $class->id_teacher", OBJECT );

									$teacherName = $getTeacher->name_teacher .' '.$getTeacher->lastname_teacher;
								}else{
									$teacherName = ' - ';
								}

								if($class->status == 'CONFIRMADA'){
									$btnLabel = "Cancelar clase";
									if($hours < 48){
										$dataLabel = "cancelclass-minus";	
									}else{
										$dataLabel = "cancelclass-plus";
									}
									
								}
								elseif ($class->status == 'SUSPENDIDA') {
									$btnLabel = "Ver detalle";
									$dataLabel = "suspendedclass";	
								}

								// Validate Date again, only show Today and after
								if( $dteEnd >= $dteStart):
								?>
								<tr>
									<td class="text-center" style="width: 70px"><?php echo $key; ?></td>
									<td class="text-center" style="width: 270px"><?php echo $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date); ?></td>
									<td class="text-center" style="width: 100px"><?php echo $class->start_class; ?></td>
									<td class="text-center" style="width: 100px"><?php echo $class->end_class; ?></td>
									<td class="text-center"><?php echo $teacherName; ?></td> 
									<td class="text-center <?php getClassStatus($class->status); ?>" data-idclass="<?php echo $class->id_class; ?>"><?php echo $class->status; ?></td>
									<td class="text-center"><a href="#" id="suspendClass" class="btn btn-secundary btn-xs btn-block" data-class="<?php echo $dataLabel; ?>" data-idclass="<?php echo $class->id_class; ?>" data-teacher="<?php if($class->id_teacher) : echo $class->id_teacher; else: echo '0'; endif; ?>"><?php echo $btnLabel; ?></a></td>
								</tr>
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>

				<a href="<?php echo get_site_url() . '/sistema-de-reservas/reservar-una-clase/'; ?>" class="btn btn-orange btn-text-lg btn-lg pull-right">¡Reservar una nueva clase!</a>
			</div>

			<div class="col-md-10 col-md-offset-1">
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/banner-contactus.jpg"/></a>
				<a href="#" style="margin-left: 16px;"><img src="<?php echo get_template_directory_uri(); ?>/images/banner-freehours.jpg"/></a>
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
					<a href="#" class="recoverPassword">¿Olvidó su contraseña?</a>
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

						<div style="margin: 0 auto; width: 69.66666667%;">
							<p class="text-center small">Estas cancelando una clase con más de 48 horas de anticipación.</p>
							<p class="text-center small">Devolveremos las horas de clase canceladas a tu balance para que puedas reservar nuevas clases cuando quieras.</p>
							<p class="text-center small">Nuestro sistema actualizará la clase al estado de "Cancelada" y tu profesor será alertado para que no espere por ti.</p>
							<p class="text-center small">Igualmente nuestro sistema ya no te enviará más recordatorios para que asistas a esta clase.</p>

							<div class="h5 color gray text-center">¿Estás seguro que deseas cancelas esta clase?</div>
							<div style="margin: 20px auto; width: 315px">
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

	<div id="RecoverPassword" class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="completeForm" class="header-message">
					<div class="titlesmall color gray text-center">¿Olvidó su contraseña?</div>

					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">Ingresa tu correo electrónico con el que te registraste en el sistema para obtener una nueva contraseña</p>

						<form id="recoverPass" method="post" action="">
							<div class="form-group">
								<input type="text" id="student_email" name="student_email" class="form-control" placeholder="Dirección de Correo">
							</div>
							<input type="submit" class="btn btn-primary btn-sm btn-block changePass" value="Cambiar contraseña">
						</form>
					</div>
				</div>

				<div id="passSend" class="header-message" style="display: none">
					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">Te hemos enviado una nueva contraseña para que puedas ingresar temporalmente a tu cuenta. Si deseas cambiarla puedes hacerlo en la sección de "Mi perfil".</p>
						<p class="text-center small" style="font-style: italic;">We have sent you a new temporary password you can use to enter your account. If you want to change it you can do it on "My profile" section once you’re inside your account.</p>

						<a href="#" id="sendPassOk" class="btn btn-secundary btn-sm class-cancel" data-dismiss="modal">¡Entendido! / Got it!.</a>
					</div>
				</div>

				<div id="passError" class="header-message" style="display: none">
					<div class="titlesmall color gray text-center">¡Error al cambiar contraseña!</div>

					<div style="margin: 0 auto; width: 67.66666667%;">
						<p class="text-center small">El email ingresado no pertenece a ningún usuario, por favor ingrese una válido.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>