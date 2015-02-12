<?php 
/**
 * AJAX Functions
 *
 * All of these functions enhance the responsiveness of the user interface in
 * the default theme by adding AJAX functionality.
 *
 * For more information on how the custom AJAX functions work, see
 * http://codex.wordpress.org/AJAX_in_Plugins.
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function dateConvert($date) {
    $date = explode("-", $date);
    $date = $date[2].'-'.$date[0].'-'.$date[1]; 

    return $date;
}

function dateViewFormat($date) {
    $date = explode("-", $date);
    $date = $date[2].'/'.$date[1].'/'.$date[0]; 

    return $date;
}

/**
 * Register AJAX handlers for functionality.
 */
function ajax_register_actions() {
  $actions = array(
    // Directory filters
    'add_teacher'       => 'add_teacher_callback',
    'add_student'       => 'add_student_callback',
    'add_teacher_hour'  => 'add_teacher_hour_callback',
    'get_teacher_hour'  => 'get_teacher_hour_callback',
    'fetchFreeDays'     => 'fetchFreeDays_callback',

    'teacher_suspend_class' => 'teacher_suspend_class_callback',
    'teacher_workedtime'    => 'teacher_workedtime_callback',
    'teacher_expiredtime'   => 'teacher_expiredtime_callback',
    'teacher_updatestatus'  => 'teacher_updatestatus_callback',
    'teacher_getstudent'    => 'teacher_getstudent_callback',
    'teacher_savestudent'   => 'teacher_savestudent_callback',

    'student_suspend_class' => 'student_suspend_class_callback',
    'get_teacher_info'      => 'get_teacher_info_callback',
    'classesByTeacher'      => 'classesByTeacher_callback',
    'get_available_hour'    => 'get_available_hour_callback',
    'choose_classhour'      => 'choose_classhour_callback',
    'save_class_student'    => 'save_class_student_callback',
    'save_class_byhour'     => 'save_class_byhour_callback',
    'finish_booking'        => 'finish_booking_callback',

    'admin_teacherHours'    => 'admin_teacherHours_callback',
    'admin_teacherExcel'    => 'admin_teacherExcel_callback',
    'admin_studentHours'    => 'admin_studentHours_callback',
    'admin_allclassesHours' => 'admin_allclassesHours_callback',
    'admin_seeFreeHours'    => 'admin_seeFreeHours_callback',
    'admin_giveFreeHours'   => 'admin_giveFreeHours_callback',

    'recover_password'      => 'recover_password_callback',
    'updateProfileStudent'  => 'updateProfileStudent_callback',
    'recover_tpassword'     => 'recover_tpassword_callback',
    'updateProfileTeacher'  => 'updateProfileTeacher_callback',

    'classesByHour'         => 'classesByHour_callback',
    'get_all_hour'          => 'get_all_hour_callback',
    'choose_classteacher'   => 'choose_classteacher_callback',
    'validateClasses'       => 'validateClasses_callback',
    'addTopic'              => 'addTopic_callback'
  );

  /**
   * Register all of these AJAX handlers
   *
   * The "wp_ajax_" action is used for logged in users, and "wp_ajax_nopriv_"
   * executes for users that aren't logged in. This is for backpat with BP <1.6.
   */
  foreach( $actions as $name => $function ) {
    add_action( 'wp_ajax_'        . $name, $function );
    add_action( 'wp_ajax_nopriv_' . $name, $function );
  } 
}
add_action( 'after_setup_theme', 'ajax_register_actions', 20 );

function add_teacher_callback() {
    global $wpdb;

    $results = '';

    $h = "5";
    $hm = $h * 60; 
    $ms = $hm * 60;

    $date     = gmdate('Y-m-d H:i:s', time()-($ms));

    if ( $_POST['name'] != '' OR $_POST['email1'] != '' OR $_POST['password'] != '' OR $_POST['skype'] != '' ) {
        $wpdb->insert( 
            'wp_bs_teacher', 
            array( 
                'name_teacher'        => $_POST['name'], 
                'lastname_teacher'    => $_POST['lastname'], 
                'photo_teacher'       => $_POST['picture'],
                'email_p_teacher'     => $_POST['email1'],
                'email_c_teacher'     => $_POST['email2'],
                'skype_teacher'       => $_POST['skype'],
                'country_teacher'     => $_POST['country'],
                'birthday_teacher'    => $_POST['birthday'],
                'password_teacher'    => md5($_POST['password']),
                'register_date'       => $date
            ), 
            array( 
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ) 
        );

        $results = 'success';
    }
    else {
        $results = 'error';
    }
    // Return the String
    die($results);
}

function add_student_callback() {
    global $wpdb;

    $results = '';

    $h = "5";
    $hm = $h * 60; 
    $ms = $hm * 60;

    $date     = gmdate('Y-m-d H:i:s', time()-($ms));
    $motivation = $_POST['moti_one'] . ' ' . $_POST['moti_two'] . ' ' . $_POST['moti_three'] . ' ' . $_POST['moti_four'];

    if ( $_POST['name'] != '' OR $_POST['email'] != '' OR $_POST['password'] != '' OR $_POST['skype'] != '' ) {
        $wpdb->insert( 
            'wp_bs_student', 
            array( 
                'name_student'              => $_POST['name'], 
                'lastname_student'          => $_POST['lastname'], 
                'photo_student'             => $_POST['picture'],
                'email_student'             => $_POST['email'],
                'email_confirm'             => 0,
                'skype_student'             => $_POST['skype'],
                'country_student'           => $_POST['country'],
                'city_student'              => $_POST['city'],
                'birthday_student'          => $_POST["birthday"],
                'native_language_student'   => $_POST['lang'],
                'other_language_student'    => $_POST['otherlang'],
                'campo_student'             => $_POST['ocupation'],
                'motivation_student'        => $motivation,
                'offers_student'            => $_POST['newsletter'],
                'hours_in_balance'          => 0,
                'level_student'             => '',
                'annotation_student'        => '',
                'password_student'          => md5($_POST['password']),
                'register_date'             => $date
            ), 
            array( 
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s'
            ) 
        );

        $results = 'success';
    }
    else {
        $results = 'error';
    }

    if( $results === 'success' ) {
        $to = $_POST['email'];

        $subject = 'Registro nuevo usuario - Sistema de Reservas';

        $headers = "From: admin@peruwayna.com \r\n";;
        $headers .= "CC: ".$_POST['email']. "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $message = "<html><body><style type='text/css'>p, td { font-size: 12px; }</style>";
        $message.= "<table width='744' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; font-size: 12px;'>
                        <tbody>
                            <tr>
                                <td style='padding: 20px 0; vertical-align: top;'><img src='" . get_template_directory_uri() . "/images/email/logo-email.png'></td>
                                <td style='padding: 20px 20px 20px 0; vertical-align: top;'>
                                <table width='570' cellspacing='0' cellpadding='0' border='0'>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h1 style='color: #ccc; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Hola!</h1>
                                                <h4 style='color: #ccc; font-family: Arial; font-size: 18px; line-height: 1em;'>¡Gracias por crear una nueva cuenta!</h4>
                                                
                                                <p>Como paso final, por favor demuestra que esta dirección de correo realmente te pertenece haciendo <a href='". get_site_url() ."/sistema-de-reservas/confirmar?i=".$_POST['skype']."'>click en este link</a></p>

                                                <p>Thanks for signing up for a new account!<br/>
                                                As a final step, please let us know that you own this email address by <a href='". get_site_url() ."/sistema-de-reservas/confirmar?i=".$_POST['skype']."'>clicking this link</a></p>

                                                <p style='float: right; font-style: italic;'>El equipo Peruwayna</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>";

        $message.= "</body></html>";

        $mail = new PHPMailer(); // defaults to using php "mail()"
        $mail->IsSendmail(); // telling the class to use SendMail transport

        $mail->SetFrom('support@peruwayna.com', 'PeruWayna');

        $mail->AddAddress($to);

        $mail->Subject = utf8_decode($subject);

        $mail->MsgHTML( utf8_decode($message) );

        if( $mail->Send() ) {
            echo "sendMail";
        }else{
            echo "errorMail";
        }
    }
    // Return the String
    die($results);
}

function add_teacher_hour_callback() {
    global $wpdb;

    $results = '';
    $end_hour = date("h:i A", strtotime('+30 minutes', strtotime($_POST['hour']) ) );

    if ( $_POST['hour'] != '' OR $_POST['date'] != '' OR $_POST['teacher'] ) {
        $wpdb->insert( 
            'wp_bs_availability', 
            array( 
                'id_teacher'            => $_POST['teacher'], 
                'available_date'        => $_POST['date'], 
                'available_time'        => $_POST['hour'],
            ), 
            array( 
                '%d',
                '%s',
                '%s',
            ) 
        );

        $wpdb->insert( 
            'wp_bs_class', 
            array( 
                'id_student'            => '', 
                'id_teacher'            => $_POST['teacher'], 
                'status'                => 'DISPONIBLE', 
                'date_class'            => $_POST['date'], 
                'start_class'           => $_POST['hour'],
                'end_class'             => $end_hour,
            ), 
            array( 
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
            ) 
        );

        $results = $_POST['hour'];
    }
    else {
        $results = 'error';
    };

    // Return the String
    die($results);
}

function get_teacher_hour_callback() {
    global $wpdb;

    $results    = '';
    $teacher    = $_POST['teacher'];
    $date       = $_POST['date'];

    if ( $_POST['date'] != '' OR $_POST['teacher'] != '' ) {
        $getHours = $wpdb->get_results( "SELECT available_time FROM wp_bs_availability WHERE id_teacher = '$teacher' AND available_date = '$date'", OBJECT );

        $time = array();

        if ($getHours) {
            foreach($getHours as $getH):
                $time[] = $getH->available_time;
            endforeach;
            $results = json_encode($time);
        }else{
            $results = 'nothing';
        }
    }
    else {
        $results = 'error';
    };

    // Return the String
    die($results);
}

function fetchFreeDays_callback() {
    global $wpdb;
     
    $results = '';
    $id_teacher = $_POST['id_teacher'];

    $h = "5";
    $hm = $h * 60; 
    $ms = $hm * 60;

    if( !isset($_POST['month']) ){
        $month = date('m',time()-($ms)); 
    }else{
        $month = date("m", strtotime($_POST['month']));
    }

    $year = date('Y',time()-($ms));
    $day = date('d',time()-($ms));  
    $startdate = $year . '-'. $month . '-' . $day;
    $enddate = $year . '-' . $month . '-31'; 

    if($id_teacher):
        $getHours = $wpdb->get_results( "SELECT available_date FROM wp_bs_availability WHERE id_teacher = $id_teacher AND available_date >= '$startdate' AND available_date <= '$enddate' GROUP BY available_date", OBJECT );
    else:
        $getHours = $wpdb->get_results( "SELECT available_date FROM wp_bs_availability WHERE available_date >= '$startdate' AND available_date <= '$enddate' GROUP BY available_date", OBJECT );
    endif; 

    $time = array();

    if ($getHours) {
        foreach($getHours as $getH):
            $date = explode("-", $getH->available_date);
            $date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] ); 
            $time[] = date('j',$date);
        endforeach;
        $results = json_encode($time);
    }

    // Return the String
    die($results);
}

function teacher_suspend_class_callback() {
    global $wpdb;
     
    $results = '';

    $wpdb->update( 'wp_bs_class', array('status' => $_POST['status']), array('id_class' => $_POST['id_class']), array('%s'), array('%d') );

    if($_POST['id_student'] == 0){
        $results = 'sin alumno';
    }else{
        $results = 'con alumno';

        email_template_suspend( $_POST['id_class'] );
    }

    // Return the String
    die($results);
}

function teacher_workedtime_callback() {
    global $wpdb, $dias, $meses;
     
    $results    = '';
    $id_teacher = $_POST['idTeacher'];
    $startDate  = dateConvert($_POST['startDate']);
    $endDate    = dateConvert($_POST['endDate']);

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getWorkedTtime = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_teacher = $id_teacher AND date_class >= '$startDate' AND date_class <= '$endDate' 
                    AND status NOT LIKE 'EXPIRADA' AND status NOT LIKE 'CANCELADA +' AND status NOT LIKE 'CONFIRMADA' AND status NOT LIKE 'DISPONIBLE' AND status NOT LIKE 'SUSPENDIDA' AND status NOT LIKE 'SUSPENDIDA SIN ALUMNO' ORDER BY date_class", OBJECT );

    $getHoursWorked = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_teacher = $id_teacher AND date_class >= '$startDate' AND date_class <= '$endDate' 
                    AND status NOT LIKE 'EXPIRADA' AND status NOT LIKE 'CANCELADA +' AND status NOT LIKE 'CONFIRMADA' AND status NOT LIKE 'DISPONIBLE' AND status NOT LIKE 'SUSPENDIDA' AND status NOT LIKE 'SUSPENDIDA SIN ALUMNO' ORDER BY date_class" );

    $getWT = array();

    if($getWorkedTtime){
        foreach($getWorkedTtime as $getDay => $value):
            $date = explode("-", $value->date_class);
            $date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] ); 

            $date = $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date);

            if($value->id_student != 0){
                $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $value->id_student", OBJECT );

                $studentName = $getStudent->name_student .' '.$getStudent->lastname_student;
            }else{
                $studentName = ' - ';
            }

            $getWT['day'][$getDay]['id_class'] = $value->id_class;
            $getWT['day'][$getDay]['student_name'] = $studentName;
            $getWT['day'][$getDay]['date'] = $date;
            $getWT['day'][$getDay]['start_class'] = $value->start_class;
            $getWT['day'][$getDay]['end_class'] = $value->end_class;
            $getWT['day'][$getDay]['status'] = $value->status;
        endforeach;    

        $startMinutes = ($getHoursWorked[0]->total * 30);
        $finalMinutes = $startMinutes;
        $hours = gmdate("H:i", ($finalMinutes * 60));

        $getWT['timeworked'] = $hours;  

        $results = json_encode($getWT);
    }
    else {
        $results = "fail";
    }

    // Return the String
    die($results);   
}

function teacher_expiredtime_callback() {
    global $wpdb, $dias, $meses;
     
    $results    = '';
    $id_teacher = $_POST['idTeacher'];
    $startDate  = dateConvert($_POST['startDate']);
    $endDate    = dateConvert($_POST['endDate']);

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getWorkedTtime = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_teacher = $id_teacher AND date_class >= '$startDate' AND date_class <= '$endDate' 
                    AND status = 'EXPIRADA' ORDER BY date_class", OBJECT );

    $getHoursWorked = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_teacher = $id_teacher AND date_class >= '$startDate' AND date_class <= '$endDate' 
                    AND status = 'EXPIRADA' ORDER BY date_class" );

    $getWT = array();

    if($getWorkedTtime){
        foreach($getWorkedTtime as $getDay => $value):
            $date = explode("-", $value->date_class);
            $date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] ); 

            $date = $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date);

            if($value->id_student != 0){
                $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $value->id_student", OBJECT );

                $studentName = $getStudent->name_student .' '.$getStudent->lastname_student;
            }else{
                $studentName = ' - ';
            }

            $getWT['day'][$getDay]['id_class'] = $value->id_class;
            $getWT['day'][$getDay]['student_name'] = $studentName;
            $getWT['day'][$getDay]['date'] = $date;
            $getWT['day'][$getDay]['start_class'] = $value->start_class;
            $getWT['day'][$getDay]['end_class'] = $value->end_class;
            $getWT['day'][$getDay]['status'] = $value->status;
        endforeach;    

        $startMinutes = ($getHoursWorked[0]->total * 30);
        $finalMinutes = $startMinutes;
        $hours = gmdate("H:i", ($finalMinutes * 60));

        $getWT['timeworked'] = $hours;  

        $results = json_encode($getWT);
    }
    else {
        $results = "fail";
    }

    // Return the String
    die($results);   
}

function teacher_updatestatus_callback() {
    global $wpdb;
     
    $results    = '';
    $id_teacher = $_POST['id_teacher'];
    $id_class   = $_POST['id_class'];
    $status     = $_POST['status'];

    $update = $wpdb->query("UPDATE wp_bs_class SET status = '$status' WHERE id_class = '$id_class' AND (status LIKE '%COMPLETADA%' OR status LIKE '%ALUMNO FALTÓ%')");
    if (json_encode($update) > 0){
        $results = true;
    }else{
        $results = false;    
    }

    // Return the String
    die($results);   
}

function teacher_getstudent_callback() {
    global $wpdb;

    $results    = '';
    $id_student = $_POST['id_student'];
    $id_teacher = $_POST['id_teacher'];

    $getStudent = $wpdb->get_row( "SELECT wp_bs_student.* FROM wp_bs_class JOIN wp_bs_student WHERE wp_bs_class.id_teacher = {$id_teacher} AND wp_bs_class.id_student = {$id_student} GROUP BY wp_bs_class.id_student", OBJECT );
    // $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $id_student", OBJECT );

    $user = array();

    if($getStudent):

        $user['id'] = $getStudent->id_student;
        $user['name'] = $getStudent->name_student;
        $user['lastname'] = $getStudent->lastname_student;
        $user['skype'] = $getStudent->skype_student;
        $user['email'] = $getStudent->email_student;
        $user['country'] = $getStudent->country_student;
        $user['city'] = $getStudent->city_student;
        $user['birthday'] = $getStudent->birthday_student;
        $user['language'] = $getStudent->native_language_student;
        $user['olanguage'] = $getStudent->other_language_student;
        $user['work'] = $getStudent->campo_student;
        $user['level'] = $getStudent->level_student;
        $user['annotation'] = $getStudent->annotation_student;

        $results = json_encode($user);

    else:

        $results = "fail";

    endif;

    // Return the String
    die($results);   
}

function teacher_savestudent_callback() {
    global $wpdb;
     
    $results    = '';
    $id_student = $_POST['id_student'];
    $level_student = $_POST['level_student'];
    $annotation_student = $_POST['annotation_student'];

    $update = $wpdb->query("UPDATE wp_bs_student SET level_student = '$level_student', annotation_student = '$annotation_student' WHERE id_student = '$id_student'");
    if (json_encode($update) > 0){
        $results = true;
    }else{
        $results = false;    
    }

    // Return the String
    die($results);   
}

function student_suspend_class_callback() {
    global $wpdb;
     
    $results = '';
    $id_student = $_POST['id_student'];
    $id_class = $_POST['id_class'];

    $wpdb->update( 'wp_bs_class', array('status' => $_POST['status']), array('id_class' => $_POST['id_class']), array('%s'), array('%d') );

    if($_POST['status'] == 'CANCELADA +'){
        $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = '$id_student'", OBJECT );
        $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_class = '$id_class'", OBJECT );
        $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = '$getClass->id_teacher'", OBJECT );

        $wpdb->insert('wp_bs_availability',
        array('id_teacher'          => $getClass->id_teacher,
              'available_date'      => $getClass->date_class,
              'available_time'      => $getClass->start_class
        ),
        array('%s',                 // ID
              '%s',                 // DATE
              '%s'                 // TIME
        ));

        $hours_in_balance = $getStudent->hours_in_balance + 30;

        $update = $wpdb->query("UPDATE wp_bs_student SET hours_in_balance = '$hours_in_balance' WHERE id_student = '$id_student'");
        if (json_encode($update) > 0){
            $results = 'Sumo horas';
        }else{
            $results = 'No sumo nada';    
        }

        // Function send email
        email_template_cancelplus( $id_class );

    }else{
        $results = 'No suma horas';

        // Function send email
        email_template_cancelminus( $id_class );
    }

    // Return the String
    die($results);
}

function get_teacher_info_callback() {
    global $wpdb;
     
    $results = '';
    $id_teacher = $_POST['id_teacher'];

    $month = date('m');  
    $year = date('Y');  

    $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = $id_teacher", OBJECT );

    ?>

    <div class="jumbotron">
        <div style="width: 75%; display: inline-block; vertical-align: top;">
            <h3><?php echo $getTeacher->name_teacher; ?> <?php echo $getTeacher->lastname_teacher; ?></h3>
            <p><?php echo $getTeacher->description_teacher; ?></p>
        </div>
        <div style="width: 20%; display: inline-block; margin: 0 20px;">
            <img src="<?php echo get_template_directory_uri(); ?>/lib/utils/timthumb.php?src=<?php echo $getTeacher->photo_teacher; ?>&h=170&w=170" class="img-circle" />
        </div>
    </div>

    <p class="add-bottom"><strong>Notar:</strong> Todas las horas de clase mostradas son horas locales de Perú (UTC -5:00)<br/>
        <strong>Please Note:</strong> All class hours are displayed in Peruvian local time (UTC -5:00)</p>

    <script type="text/javascript">
        var id_teacher = <?php echo $id_teacher; ?>;
        classesByTeacher();
    </script>

    <div class="col-md-6">
        <div class="col-md-12">
            <div class="inner-box">
                <div class="loader"></div>
                <div class="datepicker-embed"><div id="choosePicker"></div></div>
                <form class="availableHours">
                    <div class="chooseDate"></div>
                    <div class="availableH"></div>
                    <input type="hidden" id="chooseDate" name="chooseDate">
                    <input type="hidden" id="id_teacher" name="id_teacher" value="<?php echo $id_teacher; ?>">
                </form>
            </div>
        </div>
        <div class="col-md-12 legendColor">
            <div class="active"><span></span>Seleccionado</div>
            <div class="oneclass"><span></span>Disponible</div>
            <div class="noclass"><span></span>No disponible</div>
        </div>
    </div>
    <div class="col-md-6">
        <script type="text/javascript">
        jq(document).ready(function() {
            jq('#selected-hours').dataTable( {
                "scrollY":        "250px",
                "scrollCollapse": true,
                "paging":         false,
                "order": [ [0,"asc"],[1,"asc"] ]
            } );

            var body_height = parseInt(jq('#selected-hours_wrapper .dataTables_scrollBody').height());

            jq('#selected-hours_wrapper .dataTables_scrollBody').height(body_height + 30);
        } );
        </script>
        <table id="selected-hours" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 118px">Día</th>
                    <th class="text-center" style="width: 117px">Desde</th>
                    <th class="text-center" style="width: 117px">Hasta</th>
                    <th class="text-center" style="width: 117px">Acción</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <a href="#" id="confirm-classes" class="btn btn-secundary btn-sm pull-right" data-teacher="'<?php echo $id_teacher; ?>">Confirmar mis clases</a>
        <script type="text/javascript">
        var jq = jQuery;

        jq('#confirm-classes').click( function(e) {
            e.preventDefault();

            var toJSON = JSON.stringify(sessionStorage);

            jq.ajax({
                type: 'POST',         
                url: apfajax.ajaxurl,
                data: {
                    action: 'save_class_student',
                    classes: toJSON,
                    id_student: id_student,
                },
                success: function(data, textStatus, XMLHttpRequest) {       
                    console.log(data);
                    sessionStorage.clear();
                    window.location.replace('<?php echo get_site_url() . "/sistema-de-reservas/confirmas-clases/"; ?>');
                    
                },
                error: function(MLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });
        </script>
    </div>

    <?php

    // Return the String
    die($results);
}

function classesByTeacher_callback() {
    global $wpdb;
     
    $results = '';

    if( !isset($_POST['month']) ){
        $month = date('m');   
        $time = strtotime("-1 day", time());
        $day = date('d', $time); 
    }else{
        $month = date("m", strtotime($_POST['month']));
        $day = '01';   
    }

    $year = date('Y');
    $startdate = $year . '-'. $month . '-' . $day;
    $enddate = $year . '-' . $month . '-31'; 

    $id_teacher = $_POST['id_teacher'];

    $currentTime = date('h:i A');

    $getHours = $wpdb->get_results( "SELECT available_date FROM wp_bs_availability WHERE id_teacher = $id_teacher AND available_date >= '$startdate' AND available_date <= '$enddate' GROUP BY available_date ASC", OBJECT );

    $time = array();

    if ($getHours) {
        foreach($getHours as $getH):
            $date = explode("-", $getH->available_date);
            $date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] ); 
            $time[] = date('j',$date);
        endforeach;
        $results = json_encode($time);
    }

    // Return the String
    die($results);  
}

function get_available_hour_callback() {
    global $wpdb;

    $results    = '';
    $id_teacher = $_POST['id_teacher'];
    $date       = $_POST['date'];

    if ( $_POST['date'] != '' OR $_POST['teacher'] != '' ) :
        $getHours = $wpdb->get_results( "SELECT available_time FROM wp_bs_availability WHERE id_teacher = '$id_teacher' AND available_date = '$date' ORDER BY available_time ASC", OBJECT );

        $time = array(); ?>

        <script type="text/javascript">
        jq(document).ready(function() {
            jq('#available_time-hours').dataTable( {
                "scrollY":        "180px",
                "scrollCollapse": true,
                "paging":         false,
                "order": [ [0,"asc"] ],
                "columnDefs": [ {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                } ],
                "language": {
                    "zeroRecords": "Hubo un error! Es nuestra culpa, vuelve a elegir un día por favor!"
                }
            } );

            var body_height = parseInt(jq('#available_time-hours_wrapper .dataTables_scrollBody').height());

            jq('#available_time-hours_wrapper .dataTables_scrollBody').height(body_height + 30);
            jq('#available_time-hours_wrapper .dataTables_scrollHead').hide();
        } );
        </script>
        <table id="available_time-hours" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center" style="width: 70px">Horario</th>
                    <th class="text-center" style="width: 30px"></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($getHours) : foreach($getHours as $getH): 

                $newDate = date("d-m-Y");
                $formatedHour = date('H:i', strtotime($newDate . ' ' . $getH->available_time) );
                $hourID = str_replace(' ','-',str_replace(':','-',$getH->available_time));

                ?>
                <tr>
                    <td><?php echo $formatedHour; ?></td>
                    <td><?php echo $getH->available_time; ?></td>
                    <td><input type="checkbox" value="<?php echo $getH->available_time; ?>" data-id="<?php echo $id_teacher; ?>_<?php echo $date; ?>_<?php echo $hourID; ?>"></td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    <?php endif;

    // Return the String
    die($results);  
}

function choose_classhour_callback() {
    global $wpdb;

    $results = '';
    $id_teacher = $_POST['id_teacher'];
    $arreglo = stripslashes($_POST['classes']);
    $classes = json_decode("$arreglo");

    $getData = array();

    foreach ($classes as $class => $value) {
        $data = explode("_", $class);
        $id_teacher = $data[0];
        $day_class = $data[1];
        $hour_class = str_replace('-',':',$data[2]);

        $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = $id_teacher", OBJECT );
        $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_teacher = $id_teacher AND date_class = '$day_class' AND start_class = '$value'", OBJECT );
        
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['id'] = $id_teacher;
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['day_class'] = dateViewFormat($getClass->date_class);
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['start_class'] = $value;
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['end_class'] = date("h:i A", strtotime('+30 minutes', strtotime($value) ) );
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['action'] = '<a href="#" id="data-'.$id_teacher.'-'.$day_class.'-'.$data[2].'" class="btn btn-secundary btn-xs btn-block" data-date="'.$day_class.'" data-hour="'.$data[2].'" data-teacher="'.$id_teacher.'">Eliminar clase</a>
                <script>
                var jq = jQuery;
                jq("#data-'.$id_teacher.'-'.$day_class.'-'.$data[2].'").click( function(e) {
                    e.preventDefault(); 

                    var date = jq(this).data("date"); 
                    var hour = jq(this).data("hour"); 
                    var teacher = jq(this).data("teacher"); 

                    jq(this).addClass("disabled");
                    jq("a#'.$id_teacher.'_'.$day_class.'_'.$data[2].'").removeClass("removeTeacher").addClass("addTeacher").text("Seleccionar clase");
                    
                    sessionStorage.removeItem("'.$id_teacher.'_'.$day_class.'_'.$data[2].'");

                    if(sessionStorage.length < 1){
                        jq("a#confirm-classes").addClass("disabled");
                    }

                });
                </script>';
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['status'] = 'active';
    }

    $results = json_encode($getData);

    // Return the String
    die($results);  
}

function save_class_student_callback() {
    global $wpdb;

    session_start();

    $results = '';
    $arreglo = stripslashes($_POST['classes']);
    $classes = json_decode("$arreglo");
    $id_student = $_POST['id_student'];

    $get = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $id_student", OBJECT );

    $numClass = 0;
    $idClasses = array();

    foreach ($classes as $class => $value) {
        $data = explode("_", $class);
        $id_teacher = $data[0];
        $day_class = $data[1];
        $hour_class = str_replace('-',':',$data[2]);
        $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_teacher = $id_teacher AND date_class = '$day_class' AND start_class = '$value'", OBJECT );

        $idClasses[] = $getClass->id_class;
        $numClass++;
    }

    $numClass = $numClass * 30;
    $hours_in_balance = $get->hours_in_balance;

    $_SESSION['ids'] = $idClasses;
    $_SESSION['numClass'] = $numClass;
    $_SESSION['hours_in_balance'] = $hours_in_balance;

    $results = $numClass;

    // Return the String
    die(json_encode($idClasses));  
}

function finish_booking_callback() {
    global $wpdb;

    session_start();

    $results = '';
    $classes = $_SESSION['ids'];
    $id_student = $_POST['id_student'];

    foreach ($classes as $class):
        $id_class = $class;
        $update = $wpdb->query("UPDATE wp_bs_class SET status = 'CONFIRMADA', id_student = '$id_student' WHERE id_class = '$id_class'");
        $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_class = '$id_class'", OBJECT );
        $delete = $wpdb->query("DELETE FROM wp_bs_availability WHERE id_teacher = '$getClass->id_teacher' AND available_date = '$getClass->date_class' AND available_time = '$getClass->start_class'");

        email_template_classconfirm( $id_class );
    endforeach;

    $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = '$id_student'", OBJECT );

    email_template_classconfirm_student( $classes, $getStudent->email_student );

    $hours_in_balance = $getStudent->hours_in_balance - $_SESSION['numClass'];

    $update = $wpdb->query("UPDATE wp_bs_student SET hours_in_balance = '$hours_in_balance' WHERE id_student = '$id_student'");

    if (json_encode($update) > 0){
        $results = true;
    }else{
        $results = false;    
    }

    // Return the String
    die($results);  
}

function admin_studentHours_callback() {
    global $wpdb, $dias, $meses;
     
    $results    = '';
    $student    = $_POST['student'];
    $startDate  = dateConvert($_POST['startDate']);
    $endDate    = dateConvert($_POST['endDate']);

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getTeacerClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_student = $student AND date_class >= '$startDate' AND date_class <= '$endDate' ORDER BY date_class ASC", OBJECT );

    $getHours_cancelminus = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $student AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'CANCELADA -' ORDER BY date_class" );
    $getHours_cancelplus = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $student AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'CANCELADA +' ORDER BY date_class" );
    $getHours_suspend = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $student AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'SUSPENDIDA' ORDER BY date_class" );
    $getHours_confirm = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $student AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'CONFIRMADA' ORDER BY date_class" );
    $getHours_nocomplete = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $student AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'ALUMNO FALTÓ' ORDER BY date_class" );
    $getHours_complete = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_student = $student AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'COMPLETADA' ORDER BY date_class" );

    $getWT = array();

    if($getTeacerClasses){
        foreach($getTeacerClasses as $getDay => $value):
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

            $getWT['day'][$getDay]['date'] = $date;
            $getWT['day'][$getDay]['start_class'] = $value->start_class;
            $getWT['day'][$getDay]['end_class'] = $value->end_class;
            $getWT['day'][$getDay]['teacher_name'] = $teacherName;
            $getWT['day'][$getDay]['student_name'] = $studentName;
            $getWT['day'][$getDay]['status'] = $value->status;
        endforeach; 

        $cancelminus = m2h($getHours_cancelminus[0]->total * 30);
        $cancelplus = m2h($getHours_cancelplus[0]->total * 30);
        $suspend = m2h($getHours_suspend[0]->total * 30);
        $confirm = m2h($getHours_confirm[0]->total * 30);
        $nocomplete = m2h($getHours_nocomplete[0]->total * 30);
        $complete = m2h($getHours_complete[0]->total * 30);
        
        $getWT['cancelminus'] = $cancelminus;
        $getWT['cancelplus'] = $cancelplus;
        $getWT['suspend'] = $suspend;
        $getWT['confirm'] = $confirm;
        $getWT['nocomplete'] = $nocomplete;
        $getWT['complete'] = $complete;

        $results = json_encode($getWT);     
    }
    else{
        $results = 'fail';
    }

    // Return the String
    die($results);   
}

function admin_teacherHours_callback() {
    global $wpdb, $dias, $meses;
     
    $results    = '';
    $teacherID  = $_POST['teacher'];
    $startDate  = dateConvert($_POST['startDate']);
    $endDate    = dateConvert($_POST['endDate']);

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getTeacherClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_teacher = '$teacherID' AND date_class >= '$startDate' AND date_class <= '$endDate' ORDER BY date_class ASC", OBJECT );

    $getHours_cancelminus = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_teacher = '$teacherID' AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'CANCELADA -' ORDER BY date_class" );
    $getHours_cancelplus = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_teacher = '$teacherID' AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'CANCELADA +' ORDER BY date_class" );
    $getHours_suspend = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_teacher = '$teacherID' AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'SUSPENDIDA' ORDER BY date_class" );
    $getHours_suspendwos = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_teacher = '$teacherID' AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'SUSPENDIDA SIN ALUMNO' ORDER BY date_class" );
    $getHours_nocomplete = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_teacher = '$teacherID' AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'ALUMNO FALTÓ' ORDER BY date_class" );
    $getHours_complete = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE id_teacher = '$teacherID' AND date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'COMPLETADA' ORDER BY date_class" );

    $getWT = array();

    if(!empty($getTeacherClasses) ){
        foreach($getTeacherClasses as $getDay => $value):
            $date = explode("-", $value->date_class);
            $date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] ); 

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

            $getWT['day'][$getDay]['date'] = $date;
            $getWT['day'][$getDay]['start_class'] = $value->start_class;
            $getWT['day'][$getDay]['end_class'] = $value->end_class;
            $getWT['day'][$getDay]['teacher_name'] = $teacherName;
            $getWT['day'][$getDay]['student_name'] = $studentName;
            $getWT['day'][$getDay]['status'] = $value->status;
        endforeach;      

        $cancelminus = m2h($getHours_cancelminus[0]->total * 30);
        $cancelplus = m2h($getHours_cancelplus[0]->total * 30);
        $suspend = m2h($getHours_suspend[0]->total * 30);
        $suspendwos = m2h($getHours_suspendwos[0]->total * 30);
        $nocomplete = m2h($getHours_nocomplete[0]->total * 30);
        $complete = m2h($getHours_complete[0]->total * 30);
        
        $getWT['cancelminus'] = $cancelminus;
        $getWT['cancelplus'] = $cancelplus;
        $getWT['suspend'] = $suspend;
        $getWT['suspendwos'] = $suspendwos;
        $getWT['nocomplete'] = $nocomplete;
        $getWT['complete'] = $complete;

        $results = json_encode($getWT);
    }
    else{
        $results = 'fail';
    }

    // Return the String
    die($results);   
}

function admin_teacherExcel_callback() {
    global $wpdb, $dias, $meses;

    $results    = '';
    $name       = $_POST['teacher_name'];
    $lastname   = $_POST['teacher_lastname'];
    $startDate  = $_POST['startDate'];
    $endDate    = $_POST['endDate'];

    if(require_once dirname(__FILE__) . '/Classes/PHPExcel.php') {
        $results = 'cargo';
    }else{
        $results = 'no cargo';
    };

    $teacherName = $name . ' ' . $lastname;
    $teacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE name_teacher = '$name' AND lastname_teacher = '$lastname'", OBJECT );

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $result = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE id_teacher = $teacher->id_teacher AND date_class >= '$startDate' AND date_class <= '$endDate' ORDER BY date_class ASC", OBJECT );

    die($results);
}

function admin_allclassesHours_callback() {
    global $wpdb, $dias, $meses;
     
    $results    = '';
    $startDate  = dateConvert($_GET['startDate']);
    $endDate    = dateConvert($_GET['endDate']);

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE date_class >= '$startDate' AND date_class <= '$endDate' ORDER BY date_class ASC", OBJECT );

    $getHours_cancelminus = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'CANCELADA -' ORDER BY date_class" );
    $getHours_cancelplus = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'CANCELADA +' ORDER BY date_class" );
    $getHours_suspend = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'SUSPENDIDA' ORDER BY date_class" );
    $getHours_suspendwos = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'SUSPENDIDA SIN ALUMNO' ORDER BY date_class" );
    $getHours_confirm = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'CONFIRMADA' ORDER BY date_class" );
    $getHours_nocomplete = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'ALUMNO FALTÓ' ORDER BY date_class" );
    $getHours_complete = $wpdb->get_results( "SELECT COUNT(*) as total FROM wp_bs_class WHERE date_class >= '$startDate' AND date_class <= '$endDate' AND status = 'COMPLETADA' ORDER BY date_class" );

    $getWT = array();

    if($getClasses){
        foreach($getClasses as $getDay => $value):
            $date = explode("-", $value->date_class);
            $timeNow = strtotime($date[0].'/'.$date[1].'/'.$date[2] . ' '. $value->start_class);
            $date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] ); 

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

            $getWT['day'][$getDay]['index'] = $timeNow;
            $getWT['day'][$getDay]['date'] = $date;
            $getWT['day'][$getDay]['start_class'] = $value->start_class;
            $getWT['day'][$getDay]['end_class'] = $value->end_class;
            $getWT['day'][$getDay]['teacher_name'] = $teacherName;
            $getWT['day'][$getDay]['student_name'] = $studentName;
            $getWT['day'][$getDay]['status'] = $value->status;
        endforeach;     

        $cancelminus = m2h($getHours_cancelminus[0]->total * 30);
        $cancelplus = m2h($getHours_cancelplus[0]->total * 30);
        $suspend = m2h($getHours_suspend[0]->total * 30);
        $suspendwos = m2h($getHours_suspendwos[0]->total * 30);
        $confirm = m2h($getHours_confirm[0]->total * 30);
        $nocomplete = m2h($getHours_nocomplete[0]->total * 30);
        $complete = m2h($getHours_complete[0]->total * 30);
        
        $getWT['cancelminus'] = $cancelminus;
        $getWT['cancelplus'] = $cancelplus;
        $getWT['suspend'] = $suspend;
        $getWT['suspendwos'] = $suspendwos;
        $getWT['confirm'] = $confirm;
        $getWT['nocomplete'] = $nocomplete;
        $getWT['complete'] = $complete;

        $results = json_encode($getWT); 
    }
    else {
        $results = "fail";
    }

    // Return the String
    die($results);   
}

function admin_seeFreeHours_callback() {
    global $wpdb, $dias, $meses;
     
    $results    = '';
    $startDate  = dateConvert($_POST['startDate']);
    $endDate    = dateConvert($_POST['endDate']);

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_freehours WHERE date_class >= '$startDate' AND date_class <= '$endDate' ORDER BY date_class ASC", OBJECT );

    $getWT = array();

    if($getClasses){
        foreach($getClasses as $getDay => $value):

            if($value->id_student != 0){
                $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $value->id_student", OBJECT );

                $studentName = $getStudent->name_student .' '.$getStudent->lastname_student;
            }else{
                $studentName = ' - ';
            }

            $getWT['day'][$getDay]['date'] = dateViewFormat($value->date_class);
            $getWT['day'][$getDay]['student_name'] = $studentName;
            $getWT['day'][$getDay]['freetime'] = m2h($value->free_time);
        endforeach;      
    }

    $results = json_encode($getWT);

    // Return the String
    die($results);   
}

function admin_giveFreeHours_callback() {
    global $wpdb;
     
    $results    = '';
    $idstudent  = $_POST['idstudent'];
    $minutes    = $_POST['minutes'];
    $today      = date('Y-m-d',time()-($ms));

    $student = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = '$idstudent'", OBJECT );

    if($student):
        $id_student = $student->id_student;
        $hours = $student->hours_in_balance + $minutes;

        $wpdb->update( 'wp_bs_student', array('hours_in_balance' => $hours), array('id_student' => $id_student), array('%s'), array('%d') );
        $wpdb->insert('wp_bs_freehours',
        array('id_student'          => $id_student,
              'date_class'          => $today,
              'free_time'           => $minutes,
              'type'                => 'Cortesía',
        ),
        array('%d',                 // ID STUDENT
              '%s',                 // DATE
              '%d',                 // TIME
              '%s',                 // TYPE
        ));

        $results = 'true';
    else:
        $results = 'false';
    endif;

    // Return the String
    die($results); 

}

function recover_password_callback() {
    global $wpdb;
     
    $results    = '';
    $email      = $_POST['email'];

    $student = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE email_student = '$email'", OBJECT );

    if($student):
        $id_student = $student->id_student;
        $new_password = randomPassword();
        $md5_newpass = md5($new_password);

        $wpdb->update( 'wp_bs_student', array('password_student' => $md5_newpass), array('id_student' => $id_student), array('%s'), array('%d') );
        email_template_recoverpass( $email, $new_password );
    else:
        echo 'password not change';
    endif;

    // Return the String
    die(); 
}

function updateProfileStudent_callback() {
    global $wpdb;

    $results = '';

    $h = "5";
    $hm = $h * 60; 
    $ms = $hm * 60;

    $email = $_POST['email'];

    $student = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE email_student = '$email'", OBJECT );
    $id_student = $student->id_student;

    if($_POST['password'] != ''):
        $password = md5($_POST['password']);
    else:
        $password = $student->password_student;
    endif;

    $motivation = $_POST['moti_one'] . ' ' . $_POST['moti_two'] . ' ' . $_POST['moti_three'] . ' ' . $_POST['moti_four'];

    if ( $_POST['name'] != '' OR $_POST['email'] != '' OR $_POST['skype'] != '' ) {
        $wpdb->update( 
            'wp_bs_student', 
            array( 
                'name_student'              => $_POST['name'], 
                'lastname_student'          => $_POST['lastname'], 
                'photo_student'             => $_POST['picture'],
                'email_student'             => $_POST['email'],
                'skype_student'             => $_POST['skype'],
                'country_student'           => $_POST['country'],
                'city_student'              => $_POST['city'],
                'birthday_student'          => $_POST["birthday"],
                'native_language_student'   => $_POST['lang'],
                'other_language_student'    => $_POST['otherlang'],
                'campo_student'             => $_POST['ocupation'],
                'motivation_student'        => $motivation,
                'offers_student'            => $_POST['newsletter'],
                'password_student'          => $password,
            ), 
            array('id_student' => $id_student), 
            array( 
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            ), 
            array('%d') 
        );

        $results = $id_student;
    }
    else {
        $results = 'error';
    }

    // Return the String
    die($results);
}

function recover_tpassword_callback() {
    global $wpdb;
     
    $results    = '';
    $email      = $_POST['email'];

    $teacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE email_p_teacher = '$email'", OBJECT );

    if($teacher):
        $id_teacher = $teacher->id_teacher;
        $new_password = randomPassword();
        $md5_newpass = md5($new_password);

        $wpdb->update( 'wp_bs_teacher', array('password_teacher' => $md5_newpass), array('id_teacher' => $id_teacher), array('%s'), array('%d') );
        email_template_recoverpass2( $email, $new_password );

        $results = $new_password;
    else:
        $results = 'error';
    endif;

    // Return the String
    die($results); 
}

function updateProfileTeacher_callback() {
    global $wpdb;

    $results = '';

    $h = "5";
    $hm = $h * 60; 
    $ms = $hm * 60;

    $email = $_POST['ecorp'];

    $teacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE email_c_teacher = '$email'", OBJECT );
    $id_teacher = $teacher->id_teacher;

    if($_POST['password'] != ''):
        $password = md5($_POST['password']);
    else:
        $password = $teacher->password_teacher;
    endif;

    if ( $_POST['name'] != '' OR $_POST['email'] != '' OR $_POST['skype'] != '' ) {
        $wpdb->update( 
            'wp_bs_teacher', 
            array( 
                'name_teacher'              => $_POST['name'], 
                'lastname_teacher'          => $_POST['lastname'], 
                'photo_teacher'             => $_POST['picture'],
                'email_p_teacher'           => $_POST['email'],
                'email_c_teacher'           => $_POST['ecorp'],
                'skype_teacher'             => $_POST['skype'],
                'country_teacher'           => $_POST['country'],
                'birthday_teacher'          => $_POST["birthday"],
                'description_teacher'       => $_POST['description'],
                'password_teacher'          => $password,
            ), 
            array('id_teacher' => $id_teacher), 
            array( 
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ), 
            array('%d') 
        );

        $results = $id_teacher;
    }
    else {
        $results = 'error';
    }

    // Return the String
    die($results);
}

function classesByHour_callback() {
    global $wpdb;
     
    $results = '';

    if( !isset($_POST['month']) ){
        $month = date('m');   
        $time = strtotime("-1 day", time());
        $day = date('d', $time); 
    }else{
        $month = date("m", strtotime($_POST['month']));
        $day = '01';   
    }

    $year = date('Y');
    $startdate = $year . '-'. $month . '-' . $day;
    $enddate = $year . '-' . $month . '-31'; 

    $id_teacher = $_POST['id_teacher'];

    $currentTime = date('h:i A');

    $getHours = $wpdb->get_results( "SELECT available_date FROM wp_bs_availability WHERE available_date >= '$startdate' AND available_date <= '$enddate' GROUP BY available_date ASC", OBJECT );

    $time = array();

    if ($getHours) {
        foreach($getHours as $getH):
            $date = explode("-", $getH->available_date);
            $date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] ); 
            $time[] = date('j',$date);
        endforeach;
        $results = json_encode($time);
    }

    // Return the String
    die($results);  
}

function get_all_hour_callback() {
    global $wpdb;

    $results    = '';
    $date       = $_POST['date'];

    if ( $_POST['date'] != '' ) {
        $getHours = $wpdb->get_results( "SELECT available_time FROM wp_bs_availability WHERE available_date = '$date' GROUP BY available_time ORDER BY available_time ASC", OBJECT ); ?>
        <script type="text/javascript">
        jq(document).ready(function() {
            jq('#available_time-hours').dataTable( {
                "scrollY":        "200px",
                "scrollCollapse": true,
                "paging":         false,
                "order": [ [0,"asc"] ],
                "columnDefs": [ {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                } ],
                "language": {
                    "zeroRecords": "Sigue las instrucciones en la parte superior para mostrar resultados"
                }
            } );

            var body_height = parseInt(jq('#available_time-hours_wrapper .dataTables_scrollBody').height());

            jq('#available_time-hours_wrapper .dataTables_scrollBody').height(body_height + 30);
        } );
        </script>
        <table id="available_time-hours" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 70px">ID</th>
                    <th class="text-center" style="width: 150px">Horario</th>
                    <th class="text-center" style="width: 50px">Acción</th>
                </tr>
            </thead>
            <tbody>


        <?php
        if ($getHours) {
            foreach($getHours as $getH): 

                $newDate = date("d-m-Y");
                $formatedHour = date('HH:ii', strtotime($newDate . ' ' . $getH->available_time) );

                ?>
                <tr>
                    <td><?php echo $formatedHour; ?></td>
                    <td><?php echo $getH->available_time; ?></td>
                    <td><input type="checkbox" value="<?php echo $getH->available_time; ?>"></td>
                </tr>
            <?php endforeach;
        } ?>
            </tbody>
        </table>
        <?php
    }

    // Return the String
    die($results);  
}

function choose_classteacher_callback() {
    global $wpdb;

    $results = '';
    $hour = $_POST['hour'];
    $date = $_POST['date'];

    $getData = array();

    if ( $_POST['hour'] != '' AND $_POST['date'] != '') {
        $getTeachers = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE date_class = '$date' AND start_class = '$hour'", OBJECT );

        $day = explode("-", $date);

        //$hourID = str_replace(':','-',substr($getTeachers->start_class, 0, -3));

        if ($getTeachers) {
            foreach($getTeachers as $getT): 

                $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = $getT->id_teacher", OBJECT );

                $hourID = str_replace(':','-',substr($getT->start_class, 0, -3));

                $getData['teacher'][$getT->id_teacher]['name'] = $getTeacher->name_teacher .' '. $getTeacher->lastname_teacher; 
                $getData['teacher'][$getT->id_teacher]['image'] = '<img src="' .get_template_directory_uri() .'/lib/utils/timthumb.php?src='. $getTeacher->photo_teacher .'&h=100&w=100" class="img-circle" />';
                $getData['teacher'][$getT->id_teacher]['description'] = $getTeacher->description_teacher;
                $getData['teacher'][$getT->id_teacher]['action'] = '<a href="#" id="'.$getT->id_teacher.'_'.$date.'_'.$hourID.'" class="btn btn-secundary btn-xs btn-block addTeacher" data-date="'.$date.'" data-hour="'.$hour.'" data-teacher="'.$getT->id_teacher.'" style="margin: 40px 0;">Seleccionar clase</a>
                <script>
                var jq = jQuery;
                jq("#'.$getT->id_teacher.'_'.$date.'_'.$hourID.'").click( function(e) {
                    e.preventDefault(); 
                    var date = jq(this).data("date"); 
                    var hour = jq(this).data("hour"); 
                    var teacher = jq(this).data("teacher"); 

                    if( jq(this).hasClass("addTeacher") ){
                        jq("a:regex(id, .*'.$date.'_'.$hourID.'.*)").addClass("disabled");
                        jq(this).removeClass("addTeacher").removeClass("disabled").addClass("removeTeacher").text("Quitar clase");

                        sessionStorage.setItem("'.$getT->id_teacher.'_'.$date.'_'.$hourID.'" , "'.$getT->start_class.'");

                        jq("#validateClasses").slideDown(1000);
                    }
                    else if( jq(this).hasClass("removeTeacher") ){
                        jq("#selected-hours").find("a").removeClass("disabled");
                        jq(this).removeClass("removeTeacher").addClass("addTeacher").text("Seleccionar clase");

                        sessionStorage.removeItem("'.$getT->id_teacher.'_'.$date.'_'.$hourID.'");   
                    }
                });
                </script>';
                $getData['teacher'][$getT->id_teacher]['id'] = $getT->id_teacher.'_'.$date.'_'.$hourID;
            endforeach;

            $results = json_encode($getData);
        }
    }

    // Return the String
    die($results);  
}

function validateClasses_callback() {
    global $wpdb;

    $results = '';
    $arreglo = stripslashes($_POST['classes']);
    $classes = json_decode("$arreglo");

    $getData = array();

    foreach ($classes as $class => $value) {
        $data = explode("_", $class);
        $id_teacher = $data[0];
        $day_class = $data[1];
        $hour_class = str_replace('-',':',$data[2]);

        $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = $id_teacher", OBJECT );
        $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_teacher = $id_teacher AND date_class = '$day_class'", OBJECT );
        
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['id'] = $id_teacher;
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['day_class'] = $getClass->date_class;
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['start_class'] = $value;
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['end_class'] = date("h:i A", strtotime('+30 minutes', strtotime($value) ) );
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['teacher_name'] = $getTeacher->name_teacher .' '. $getTeacher->lastname_teacher;
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['action'] = '<a href="#" id="data-'.$id_teacher.'-'.$day_class.'-'.$data[2].'" class="btn btn-secundary btn-xs btn-block" data-date="'.$day_class.'" data-hour="'.$data[2].'" data-teacher="'.$id_teacher.'">Eliminar clase</a>
                <script>
                var jq = jQuery;
                jq("#data-'.$id_teacher.'-'.$day_class.'-'.$data[2].'").click( function(e) {
                    e.preventDefault(); 

                    var date = jq(this).data("date"); 
                    var hour = jq(this).data("hour"); 
                    var teacher = jq(this).data("teacher"); 

                    jq(this).addClass("disabled");
                    jq("a#'.$id_teacher.'_'.$day_class.'_'.$data[2].'").removeClass("removeTeacher").addClass("addTeacher").text("Seleccionar clase");
                    
                    sessionStorage.removeItem("'.$id_teacher.'_'.$day_class.'_'.$data[2].'");

                    if(sessionStorage.length < 1){
                        jq("a#confirm-classes").addClass("disabled");
                    }

                });
                </script>';
        $getData['data'][$id_teacher.'-'.$day_class.'-'.$data[2]]['status'] = 'active';
    }

    $results = json_encode($getData);

    // Return the String
    die($results);  
}

function save_class_byhour_callback() {
    global $wpdb;

    session_start();

    $results = '';
    $arreglo = stripslashes($_POST['classes']);
    $classes = json_decode("$arreglo");
    $id_student = $_POST['id_student'];

    $get = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $id_student", OBJECT );

    $numClass = 0;
    $idClasses = array();

    foreach ($classes as $class => $value) {
        $data = explode("_", $class);
        $id_teacher = $data[0];
        $day_class = $data[1];
        $hour_class = str_replace('-',':',$data[2]);
        $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_teacher = $id_teacher AND date_class = '$day_class'", OBJECT );

        $idClasses[] = $getClass->id_class;
        $numClass++;
    }

    $numClass = $numClass * 30;
    $hours_in_balance = $get->hours_in_balance;

    $_SESSION['ids'] = $idClasses;
    $_SESSION['numClass'] = $numClass;
    $_SESSION['hours_in_balance'] = $hours_in_balance;

    $results = $numClass; 

    // Return the String
    die($results);  
}

function addTopic_callback() {
    global $wpdb;

    $results = '';
    $title = $_POST['title'];
    $topic = $_POST['topic'];

    $getData = array();

    $wpdb->insert( 
        'wp_bs_topics', 
        array( 
            'topic_name'      => $title, 
            'topic_body'      => $topic, 
        ), 
        array( 
            '%s',
            '%s'
        ) 
    );

    $getTopics = $wpdb->get_results( "SELECT * FROM wp_bs_topics ORDER BY id_topic", OBJECT );
    foreach ($getTopics as $topic) : 
        $getData['topic'][$topic->id_topic]['id'] = $topic->id_topic;
        $getData['topic'][$topic->id_topic]['title'] = $topic->topic_name;
        $getData['topic'][$topic->id_topic]['topic'] = $topic->topic_body;
        $getData['topic'][$topic->id_topic]['action'] = '<a href="#" id="deleteTopic-'.$topic->id_topic.'" class="btn btn-secundary btn-xs btn-block" data-topic="'.$topic->id_topic.'">Eliminar</a>
                <script>
                var jq = jQuery;
                jq("#deleteTopic-'.$topic->id_topic.'").click( function(e) {
                    e.preventDefault(); 

                    var ID = jq(this).data("topic"); 

                    
                });
                </script>';
    endforeach;

    $results = json_encode($getData);

    // Return the String
    die($results);  
}


