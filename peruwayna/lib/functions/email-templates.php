<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

include('phpmailer/class.phpmailer.php');

function email_template_cancelminus( $id_class ) {
    global $wpdb;

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_class = '$id_class'", OBJECT );
    $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = '$getClass->id_teacher'", OBJECT );

    $getTopic = $wpdb->get_row( "SELECT * FROM wp_bs_topics ORDER BY id_topic ASC LIMIT 1", OBJECT );

    $date = explode("-", $getClass->date_class);
    $date = strtotime( $date[2].'/'.$date[0].'/'.$date[1] ); 

    $date = $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1];

    $to = $getTeacher->email_c_teacher;
    //$to = 'ddumst@gmail.com';

    $subject = 'Peruwayna - Clase Cancelada -';

    $headers = "From: support@peruwayna.com\r\n";
    $headers .= "CC: ".$getTeacher->email_p_teacher. "\r\n";
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
                                            <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Clase Cancelada!</h1>
                                            <p>Uno de tus alumnos ha cancelado la clase que tenia contigo.</p>
                                            <p>Los detalles de la clase son:</p>

                                            <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                                <tbody>
                                                    <tr>
                                                        <td>Fecha: ".$date."</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hora: De ".$getClass->start_class." a ".$getClass->end_class."</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <p>Registramos que la clase ha sido cancelada con menos de 48 horas de anticipación por lo que este tiempo de trabajo lo invertirás en el desarrollo
                                                de materiales de estudio y se te remunerará por este tiempo de clase.</p>
                                            <p>El estado de esta clase cancelada será mostrada en tu Registro de horas laboradas como <span style='color: #ff4546;'>'Cancelada -'</span>.</p>
                                            <p>El material de estudios que debes de hacer durante este tiempo es:</p>

                                            <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                                <tbody>
                                                    <tr>
                                                        <td>Título: ".$getTopic->topic_name."</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tema: ".$getTopic->topic_body."</td>
                                                    </tr>
                                                </tbody>
                                            </table>

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
        $delete = $wpdb->query("DELETE FROM wp_bs_topics WHERE id_topic = '$getTopic->id_topic'");
        echo "sendMail";
    }else{
        echo "error";
    }
}

function email_template_cancelplus( $id_class ) {
    global $wpdb;

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_class = '$id_class'", OBJECT );
    $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = '$getClass->id_teacher'", OBJECT );

    $date = explode("-", $getClass->date_class);
    $date = strtotime( $date[2].'/'.$date[0].'/'.$date[1] ); 

    $date = $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1];

    $to = $getTeacher->email_c_teacher;
    //$to = 'ddumst@gmail.com';

    $subject = 'Peruwayna - Clase Cancelada +';

    $headers = "From: support@peruwayna.com\r\n";
    $headers .= "CC: ".$getTeacher->email_p_teacher. "\r\n";
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
                                            <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Clase Cancelada!</h1>
                                            <p>Uno de tus alumnos ha cancelado la clase que tenia contigo con más de 48 horas de anticipación.</p>
                                            <p>Los detalles de la clase son:</p>

                                            <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                                <tbody>
                                                    <tr>
                                                        <td>Fecha: ".$date."</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hora: De ".$getClass->start_class." a ".$getClass->end_class."</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <p>Nuestro sistema dejará de enviarte alertas para que asistas a esta clase. También puedes ver los detalles de la cancelación
                                            en la sección de Programación de clases y clases próximas.</p>

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
        echo "error";
    }
}

function email_template_classconfirm( $id_class ){
    global $wpdb;

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_class = '$id_class'", OBJECT );
    $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = '$getClass->id_teacher'", OBJECT );
    $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = '$getClass->id_student'", OBJECT );

    $date = explode("-", $getClass->date_class);
    $date = strtotime( $date[2].'/'.$date[0].'/'.$date[1] ); 

    $date = $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1];

    $to = $getTeacher->email_c_teacher;
    //$to = 'ddumst@gmail.com';

    $subject = 'Peruwayna: Clase Nueva - '.$date;

    $headers = "From: support@peruwayna.com\r\n";
    $headers .= "CC: ".$getTeacher->email_p_teacher. "\r\n";
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
                                            <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Tienes una nueva clase!</h1>
                                            <p>Un alumno ha reservado una clase contigo.</p>

                                            <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Nombre del alumno</strong>: ".$getStudent->name_student." ".$getStudent->lastname_student."</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Skype del alumno</strong>: ".$getStudent->skype_student."</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>País</strong>: ".$getStudent->country_student."</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Correo electrónico</strong>: ".$getStudent->email_student."</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                            <p>Los detalles de la clase reservada son:</p>

                                            <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                                <tbody>
                                                    <tr>
                                                        <td>Fecha: ".$date."</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hora: De ".$getClass->start_class." a ".$getClass->end_class."</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <p>Puedes ver el detalle de tus clases reservadas en la página de \"Mi Programación de clases y mis clases próximas\".</p>
                                            <p>Adicionalmente si deseas ver el perfil completo de tus estudiantes puedes hacerlo en la página de \"Ver la información de mis estudiante/actualizar los datos de un estuduante\".</p>

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
        echo "error";
    }
}

function email_template_classconfirm_student( $classes, $email ){
    global $wpdb;

    // $to = $email;
    $to = 'ddumst@gmail.com';

    $subject = 'Peruwayna: Mi lista de clases reservadas';

    $headers = "From: support@peruwayna.com\r\n";
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
                                            <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Felicitaciones!</h1>
                                            <p>¡Has agendado exitosamente clases de español en línea!<br/>
                                            <i>You have succesfully scheduled Spanish classes online!</i></p>
                                            
                                            <p>Los detalles de la clase reservada son:<br/>
                                            <i>The details for your scheduled classes are:</i></p>

                                            <p>";

                                            foreach ($classes as $class):
                                                $id_class = $class;
                                                $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_class = '$id_class'", OBJECT );

                                                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
                                                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

                                                $date = explode("-", $getClass->date_class);
                                                $date = strtotime( $date[2].'/'.$date[0].'/'.$date[1] ); 

                                                $date = $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date)." de ".$getClass->start_class." a ".$getClass->end_class;

    $message.=                             "<strong>".$date."</strong><br/>";                                                
                                            endforeach;

    $message.=                             "</p>

                                            <p><strong>Notar:</strong> Todas las horas de clase mostradas son horas locales de Perú (UTC -5:00)<br/>
                                            <i><strong>Please:</strong> All class hours are displayed in Peruvian local time (UTC -5:00)</i></p>

                                            <p>Si deseas ver más detalles de tus clases reservadas o si deseas cancelar alguna de ellas puedes hacerlo en la <a href='". get_site_url() ."/sistema-de-reservas/'>página principal</a> de tu cuenta.</p>
                                            <p>Por favor recuerda que las cancelaciones con menos de 48 horas de anticipación antes del inicio de tu clase se considerarán como clases perdidas y no podrán ser recuparadas en el futuro.</p>

                                            <p>If you want to check the scheduled classes full details or if you want to cancel one of them you can do it on your account's <a href='". get_site_url() ."/sistema-de-reservas/'>main page</a></p>
                                            <p>Please remember that all cancellations with less than 48 hours before your class is to begin will be considered as missing and won't be subject to refund.</p>

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
        echo "error";
    }
}

function email_template_suspend( $id_class ) {
    global $wpdb;

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $getClass = $wpdb->get_row( "SELECT * FROM wp_bs_class WHERE id_class = '$id_class'", OBJECT );
    $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = '$getClass->id_teacher'", OBJECT );
    $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = '$getClass->id_student'", OBJECT );

    $today = date('m-d-Y',time()-($ms));

    $wpdb->insert('wp_bs_freehours',
    array('id_student'          => $getClass->id_student,
          'date_class'          => $today,
          'free_time'           => 15,
          'type'                => 'Por suspensión',
    ),
    array('%d',                 // ID STUDENT
          '%s',                 // DATE
          '%d',                 // TIME
          '%s',                 // TYPE
    ));

    $hours = $getStudent->hours_in_balance +  45;
    $update = $wpdb->query("UPDATE wp_bs_student SET hours_in_balance = '$hours' WHERE id_student = '$getStudent->id_student'");

    $date = explode("-", $getClass->date_class);
    $date = strtotime( $date[2].'/'.$date[0].'/'.$date[1] ); 

    $date = $dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1];

    //$to = $getTeacher->email_c_teacher;
    $to = $getStudent->email_student;

    $subject = 'Peruwayna - Clase Suspendida: '.$date;

    $headers = "From: support@peruwayna.com\r\n";
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
                                            <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Importante!</h1>
                                            <p>Por motivos de emergencia tu profesor ha cancelado una de las clases que habías reservado.</p>
                                            
                                            <p>Los detalles de la clase reservada son:</p>

                                            <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                                <tbody>
                                                    <tr>
                                                        <td>Fecha: ".$date."</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hora: De ".$getClass->start_class." a ".$getClass->end_class."</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <p>Como señal de disculpa porque tu clase fue cancelada nos gustaría regalarte el 50% del tiempo de tu clase cancelada, lo cual equivale a <strong>¡15 minutos de clase gratis!</strong></p>

                                            <p>Estos 15 minutos de regalo han sido cargados automáticamente a tu balance de horas disponibles para que lo puedas utilizar cuando quieras.</p>

                                            <p>Finalmente desde ahora nuestro sistema ya no te enviará recordatorios para que asistas a tu clase y también puedes ver el detalle de la cancelación en el menú principal de nuestro sistema de reservas.</p>

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
        echo "error";
    }  
}

function email_template_recoverpass( $email, $password ) {
    global $wpdb;

    $getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE email_student = '$email'", OBJECT );

    //$to = $getTeacher->email_c_teacher;
    $to = $email;

    $subject = 'Peruwayna - Contraseña cambiada';

    $headers = "From: support@peruwayna.com\r\n";
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
                                            <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Contraseña cambiada!</h1>
                                            <p>Los detalles de su nueva contraseña son:</p>

                                            <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                                <tbody>
                                                    <tr>
                                                        <td>Contraseña nueva: ".$password."</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <p>Para cambiarla, debe ingresar al sistema y ir a la opción \"Mi perfil\".</p>

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
        echo "sendMail to: " . $email;
    }else{
        echo "errorMail";
    }  
}

function email_template_recoverpass2( $email, $password ) {
    global $wpdb;

    $getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE email_p_teacher = '$email'", OBJECT );

    //$to = $getTeacher->email_c_teacher;
    $to = $email;

    $subject = 'Peruwayna - Contraseña cambiada';

    $headers = "From: support@peruwayna.com\r\n";
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
                                            <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Contraseña cambiada!</h1>
                                            <p>Los detalles de su nueva contraseña son:</p>

                                            <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                                <tbody>
                                                    <tr>
                                                        <td>Contraseña nueva: ".$password."</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <p>Para cambiarla, debe ingresar al sistema y ir a la opción \"Mi perfil\".</p>

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
        echo "send mail to " . $email;
    }else{
        echo "error send mail to " . $email;
    }  
}