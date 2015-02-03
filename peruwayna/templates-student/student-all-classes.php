<?php
/**
 * Template Name: Student Panel - Classes History
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
	
		<div id="class-history" class="row">
			<div class="header-message">
				<div class="titlesmall color gray text-center">Historial de Clases</div>
			</div>

			<script type="text/javascript">
			jq(document).ready(function() {
			    jq('#allclasses').dataTable( { paging: false, searching: false, "scrollY": "507px", "scrollCollapse": true, "order": [ [0,"asc"] ], "columnDefs": [
	            {
	                "targets": [ 0 ],
	                "visible": false,
	                "searchable": false
	            } ] });

			    var body_height = parseInt(jq('#allclasses_wrapper .dataTables_scrollBody').height());

				jq('#allclasses_wrapper .dataTables_scrollBody').height(body_height + 30);
			} );
			</script>
			<table id="allclasses" class="table table-striped table-bordered text-center">
				<thead>
					<tr>
						<th class="text-center" style="width: 70px">Orden</th>
						<th class="text-center" style="width: 300px">Día</th>
						<th class="text-center" style="width: 100px">Desde</th>
						<th class="text-center" style="width: 100px">Hasta</th>
						<th class="text-center">Profesor</th>
						<th class="text-center">Estado</th>
					</tr>
				</thead>
				<tbody>
				<?php 

				$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
				$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

				$getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_student = $user->id_student ORDER BY date_class ASC", OBJECT );

				$getHours_cancelminus = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $user->id_student AND status = 'CANCELADA -' ORDER BY date_class" );
				$getHours_cancelplus = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $user->id_student AND status = 'CANCELADA +' ORDER BY date_class" );
				$getHours_suspend = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $user->id_student AND status = 'SUSPENDIDA' ORDER BY date_class" );
				$getHours_confirm = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $user->id_student AND status = 'CONFIRMADA' ORDER BY date_class" );
				$getHours_nocomplete = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $user->id_student AND status = 'ALUMNO FALTÓ' ORDER BY date_class" );
				$getHours_complete = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $user->id_student AND status = 'COMPLETADA' ORDER BY date_class" );

				$getWT = array();

				if($getClasses){
				    foreach($getClasses as $getDay => $value):
				        $date = explode("-", $value->date_class);
				        $date = strtotime( $date[2].'/'.$date[0].'/'.$date[1] ); 

				        $date = $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date);

				        if($value->id_student != 0){
				            $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $value->id_student", OBJECT );

				            $studentName = $getStudent->name_student .' '.$getStudent->lastname_student;
				        }else{
				            $studentName = ' - ';
				        }

				        if($value->id_teacher != 0){
				            $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = $value->id_teacher", OBJECT );

				            $teacherName = $getTeacher->name_teacher .' '.$getTeacher->lastname_teacher;
				        }else{
				            $teacherName = ' - ';
				        }

				        ?>
				    <tr>
						<td class="text-center" style="width: 70px"><?php echo $value->date_class; ?></td>
						<td class="text-center" style="width: 300px"><?php echo $date; ?></td>
						<td class="text-center" style="width: 100px"><?php echo $value->start_class; ?></td>
						<td class="text-center" style="width: 100px"><?php echo $value->end_class; ?></td>
						<td class="text-center"><?php echo $teacherName; ?></td>
						<td class="text-center"><?php echo $value->status; ?></td>
					</tr>
				    <?php endforeach;      
				}

				$cancelminus = m2h($getHours_cancelminus[0]->total * 30);
				$cancelplus = m2h($getHours_cancelplus[0]->total * 30);
				$suspend = m2h($getHours_suspend[0]->total * 30);
				$confirm = m2h($getHours_confirm[0]->total * 30);
				$nocomplete = m2h($getHours_nocomplete[0]->total * 30);
				$complete = m2h($getHours_complete[0]->total * 30);

				?>	
				</tbody>
			</table>

			<div id="table-hours" class="row add-top">
				<div class="form-group col-md-6">
					<label for="cancelminus" class="col-sm-8 control-label text-right">Total de horas canceladas con<br/>MENOS de 48 horas</label>
					<div class="col-sm-4">
						<input type="text" class="form-control text-center" id="cancelminus" name="cancelminus" value="<?php echo $cancelminus; ?>">
					</div>
				</div>
				<div class="form-group col-md-6">
					<label for="suspend" class="col-sm-8 control-label text-right">Total de horas suspendidas<br/>que tenía reservadas</label>
					<div class="col-sm-4">
						<input type="text" class="form-control text-center" id="suspend" name="suspend" value="<?php echo $suspend; ?>">
					</div>
				</div>
				<div class="form-group col-md-6">
					<label for="cancelplus" class="col-sm-8 control-label text-right">Total de horas canceladas con<br/>MAS de 48 horas</label>
					<div class="col-sm-4">
						<input type="text" class="form-control text-center" id="cancelplus" name="cancelplus" value="<?php echo $cancelplus; ?>">
					</div>
				</div>
				<div class="form-group col-md-6">
					<label for="nocomplete" class="col-sm-8 control-label text-right">Total de horas en las que<br/>el alumno faltó</label>
					<div class="col-sm-4">
						<input type="text" class="form-control text-center" id="nocomplete" name="nocomplete" value="<?php echo $nocomplete; ?>">
					</div>
					</div>
				</div>
				<div class="form-group col-md-6">
					<label for="complete" class="col-sm-8 control-label text-right">Total de horas completadas</label>
					<div class="col-sm-4">
						<input type="text" class="form-control text-center" id="complete" name="complete" value="<?php echo $complete; ?>">
					</div>
				</div>
			</div>
			<script>
			jq(document).ready(function(){
				jq('#allclasses tr td:nth-child(5)').each(function() {
					if( jq(this).text() == 'COMPLETADA' ){
						jq(this).addClass('confirm');
					}
					else if( jq(this).text() == 'CONFIRMADA' ){
						jq(this).addClass('confirm');
					}
					else if( jq(this).text() == 'DISPONIBLE' ){
						jq(this).addClass('confirm');
					}
					else if( jq(this).text() == 'ALUMNO FALTÓ' ){
						jq(this).addClass('miss');
					}
					else if( jq(this).text() == 'SUSPENDIDA' ){
						jq(this).addClass('cancel');
					}
					else if( jq(this).text() == 'SUSPENDIDA SIN ALUMNO' ){
						jq(this).addClass('cancel');
					}
					else if( jq(this).text() == 'CANCELADA -' ){
						jq(this).addClass('cancel');
					}
					else if( jq(this).text() == 'CANCELADA +' ){
						jq(this).addClass('cancel');
					}
				});
			});
			</script>
		</div>

	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/sistema-de-reservas/'; ?>");
		</script>
	<?php endif; ?>
	</div>

<?php get_footer(); ?>