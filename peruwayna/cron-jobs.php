<?php 

// Make sure we have access to WP functions namely WPDB
include_once($_SERVER['DOCUMENT_ROOT'].'/clientes/peruwayna/wp-config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/clientes/peruwayna/wp-load.php');

echo $_SERVER['DOCUMENT_ROOT'];

$to = "ddumst@gmail.com";

$subject = 'Peruwayna - Clase Suspendida: '.$date;

$headers = "From: no-reply@peruwayna.com\r\n";
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

if(mail($to, $subject, $message, $headers)){
    echo "sendMail";
}else{
    echo "error";
} 