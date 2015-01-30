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

if($_GET['type'] == 'email1'):
    
    if (!empty($_GET['email1'])) :
        global $wpdb;
      
        $results = $wpdb->get_row("SELECT * FROM wp_bs_teacher WHERE email_p_teacher = '" . $_GET['email1'] . "'", 'ARRAY_A');

        if($results['email_p_teacher'] == $_GET['email1'])
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

elseif($_GET['type'] == 'email2'):

    if (!empty($_GET['email2'])) :
        global $wpdb;
      
        $results = $wpdb->get_row("SELECT * FROM wp_bs_teacher WHERE email_c_teacher = '" . $_GET['email2'] . "'", 'ARRAY_A');

        if($results['email_c_teacher'] == $_GET['email2'])
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

elseif($_GET['type'] == 'skype'):

    if (!empty($_GET['skype'])) :
        global $wpdb;
      
        $results = $wpdb->get_row("SELECT * FROM wp_bs_teacher WHERE skype_teacher = '" . $_GET['skype'] . "'", 'ARRAY_A');

        if($results['skype_teacher'] == $_GET['skype'])
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