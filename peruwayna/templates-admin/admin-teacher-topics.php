<?php
/**
 * Template Name: Admin - Profesor Temas
 */

get_header(); ?>

	<div class="container">
	<?php if ( is_user_logged_in() ) : ?>
		<div class="panel panel-theme-primary text-right">
			<div class="panel-heading">
				<div class="dropdown">
					<div id="dropdownMenu1" data-toggle="dropdown">
						Panel de Administrador
						<span class="caret"></span>
					</div>
					<?php include( TEMPLATEPATH . '/templates-admin/admin-menu.php'); ?>
				</div>
			</div>
		</div>

		<form id="HourTeacherForm" class="form-horizontal" role="form">
			<div class="h4 add-bottom"><strong>Temas pendientes de trabajo</strong></div>
			<div class="col-md-12">
				<div class="col-lg-12">
					<div class="form-group">
						<label for="inputTitle" class="col-sm-1 control-label text-right">Título</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="inputTitle" name="title" required>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="col-lg-12">
					<div class="form-group">
						<label for="inputTopic" class="col-sm-1 control-label text-right">Tema</label>
						<div class="col-sm-11">
							<textarea class="form-control" id="inputTopic" name="topic" required></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 add-bottom">
				<div class="col-lg-2 pull-right">
					<input type="submit" class="form-control btn btn-secundary" id="addTopic" value="Agregar Tema">
				</div>
			</div>
		</form>

		<script type="text/javascript">
		jq(document).ready(function() {
		    jq('#teacher-topics').dataTable( { 
		    	paging: false, 
		    	searching: false, 
		    	"scrollY": "507px", 
		    	"scrollCollapse": true, 
		    	"order": [ [0,"desc"] ], 
		    	"columnDefs": [ {
	                "targets": [ 0 ],
	                "visible": false,
	                "searchable": false
	            } ] ,
	            "language": {
					"zeroRecords": "Agrega tareas para enviar al profesor si su alumno cancela la clase con menos de 48 horas."
				}
	        });

		    var body_height = parseInt(jq('#teacher-topics_wrapper .dataTables_scrollBody').height());

			jq('#teacher-topics_wrapper .dataTables_scrollBody').height(body_height + 30);
		} );
		</script>
		<table id="teacher-topics" class="table table-striped table-bordered text-center">
			<thead>
				<tr>
					<th class="text-center">ID</th>
					<th class="text-center" style="width: 200px">Título</th>
					<th class="text-center" style="width: 450px">Tema</th>
					<th class="text-center" style="width: 100px">Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php

				global $wpdb, $dias, $meses;
				$getTopics = $wpdb->get_results( "SELECT * FROM wp_bs_topics ORDER BY id_topic DESC", OBJECT );

				foreach ($getTopics as $topic) : 

				?>
				<tr>
					<td><?php echo $topic->id_topic; ?></th>
					<td style="width: 200px"><?php echo $topic->topic_name; ?></td>
					<td style="width: 450px"><?php echo $topic->topic_body; ?></td>
					<td style="width: 100px">
						<a href="#" id="deleteTopic-<?php echo $topic->id_topic; ?>" class="btn btn-secundary btn-xs btn-block" data-topic="<?php echo $topic->id_topic; ?>">Eliminar</a>
						<script>
		                var jq = jQuery;
		                jq("#deleteTopic-<?php echo $topic->id_topic; ?>").click( function(e) {
		                    e.preventDefault(); 

		                    var ID = jq(this).data("topic"); 

		                    
		                });
		                </script>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<script type="text/javascript">
			window.location.replace("<?php echo get_site_url() . '/admin-panel/'; ?>");
		</script>
	<?php endif; ?>
	</div>

<?php get_footer(); ?>