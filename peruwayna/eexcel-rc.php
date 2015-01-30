<?php 

/** Sets up WordPress vars and included files. */
require_once('../../../wp-load.php');

global $wpdb, $dias, $meses;

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

if($_GET['type'] == 'reserved'):
	$teacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE name_teacher = '$name' AND lastname_teacher = '$lastname'", OBJECT );

	$getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_teacher = $teacher->id_teacher AND date_class >= '$startDate' AND date_class <= '$endDate' ORDER BY date_class ASC", OBJECT );
else:
	$student = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE name_student = '$name' AND lastname_student = '$lastname'", OBJECT );

	$getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_teacher = $student->id_student AND date_class >= '$startDate' AND date_class <= '$endDate' ORDER BY date_class ASC", OBJECT );
endif;

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"PeruWayna_Horas_".$startDate."-".$endDate.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PeruWayna - Horas Profesor</title>

<style type="text/css">
.text-center {
	text-align: center;
}
.available, .confirm, .complete {
    color: #00b63e;
}
.cancel, .suspend {
    color: #f8040e;
}
.miss {
    color: #581fde;
}
</style>
<body>
	
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-striped table-bordered text-center">
    <thead>
        <tr>
			<th class="text-center" style="width: 140px">Día</th>
			<th class="text-center" style="width: 100px">Desde</th>
			<th class="text-center" style="width: 100px">Hasta</th>
			<th class="text-center" style="width: 160px">Profesor</th>
			<th class="text-center" style="width: 160px">Alumno</th>
			<th class="text-center" style="width: 160px">Estado</th>
		</tr>
    </thead>
    <tbody id="dinamic_content">
    <?php if(!empty($getClasses)) : ?>
		<?php foreach($getClasses as $class): ?>
		<?php 

		$date = explode("-", $class->date_class);
        $date = strtotime( $date[2].'/'.$date[0].'/'.$date[1] ); 

        $date = $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date);

        if($class->id_student != 0){
            $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $class->id_student", OBJECT );

            $studentName = $getStudent->name_student .' '.$getStudent->lastname_student;
        }else{
            $studentName = ' - ';
        }

        if($class->id_teacher != 0){
            $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = $class->id_teacher", OBJECT );

            $teacherName = $getTeacher->name_teacher .' '.$getTeacher->lastname_teacher;
        }else{
            $teacherName = ' - ';
        }

        ?>
        <tr>
            <td class="text-center"><?php echo $class->date_class ?></td>
            <td class="text-center"><?php echo $class->start_class; ?></td>								
            <td class="text-center"><?php echo $class->end_class; ?></td>
            <td class="text-center"><?php echo $teacherName; ?></td>
            <td class="text-center"><?php echo $studentName; ?></td>
            <td class="text-center"><?php echo $class->status; ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>