<?php
/**
 * Template Name: Email template
 */
?>
<html><body><style type='text/css'>p, td { font-size: 12px; }</style>
	
<table width='784' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; font-size: 12px;'>
    <tbody>
        <tr>
            <td style='padding: 20px 0; vertical-align: top;'><img src='<?php echo get_template_directory_uri(); ?>/images/email/logo-email.png'></td>
            <td style='padding: 20px 20px 20px 0; vertical-align: top;'>
            <table width='610' cellspacing='0' cellpadding='0' border='0'>
                <tbody>
                    <tr>
                        <td>
                            <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Clase Cancelada!</h1>
                            <p>Uno de tus alumnos ha cancelado la clase que tenia contigo.</p>
                            <p>Los detalles de la clase son:</p>

                            <table width='300' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                <tbody>
                                    <tr>
                                        <td>Fecha: Viernes 13 de Junio</td>
                                    </tr>
                                    <tr>
                                        <td>Hora: De 9:00am a 9:30am</td>
                                    </tr>
                                </tbody>
                            </table>

                            <p>Registramos que la clase ha sido cancelada con menos de 48 horas de anticipación por lo que este tiempo de trabajo lo invertirás en el desarrollo
                                de materiales de estudio y se te remunerará por este tiempo de clase.</p>
                            <p>El estado de esta clase cancelada será mostrada en tu Registro de horas laboradas como <span style='color: #ff4546;'>'Cancelada -'</span>.</p>
                            <p>El material de estudios que debes de hacer durante este tiempo es:</p>

                            <table width='300' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
                                <tbody>
                                    <tr>
                                        <td>Título: Lectura graduada Básico</td>
                                    </tr>
                                    <tr>
                                        <td>Tema: Las frutas</td>
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
</table>
</body>
</html>