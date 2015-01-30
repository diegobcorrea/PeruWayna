<?php 

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', '../../../../../');

require_once(ABSPATH . 'wp-config.php');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

require_once(ABSPATH . 'wp-load.php');
require_once(ABSPATH . 'wp-includes/wp-db.php');
require_once(ABSPATH . 'wp-includes/pluggable.php');

if($_GET['type'] == 'email'):
    
    if (!empty($_GET['email'])) :
        global $wpdb;
      
        $results = $wpdb->get_row("SELECT * FROM wp_bs_student WHERE email_student = '" . $_GET['email'] . "'", 'ARRAY_A');

        if($results['email_student'] == $_GET['email'])
        {
            $valid = false;
        }
        else
        {
            $valid = true;
        }
    else :
        $valid = false;
    endif;

    echo json_encode($valid);

elseif($_GET['type'] == 'recoverPass'):

    if (!empty($_GET['student_email'])) :
        global $wpdb;
      
        $results = $wpdb->get_row("SELECT * FROM wp_bs_student WHERE email_student = '" . $_GET['student_email'] . "'", 'ARRAY_A');

        if($results['email_student'] == $_GET['student_email'])
        {
            $valid = true;
        }
        else
        {
            $valid = false;
        }
    else :
        $valid = true;
    endif;

    echo json_encode($valid);

elseif($_GET['type'] == 'skype'):

    if (!empty($_GET['skypeID'])) :
        global $wpdb;
      
        $results = $wpdb->get_row("SELECT * FROM wp_bs_student WHERE skype_student = '" . $_GET['skypeID'] . "'", 'ARRAY_A');

        if($results['skype_student'] == $_GET['skypeID'])
        {
            $valid = false;
        }
        else
        {
            $valid = true;
        }
    else :
        $valid = false;
    endif;

    echo json_encode($valid);

endif;


?>