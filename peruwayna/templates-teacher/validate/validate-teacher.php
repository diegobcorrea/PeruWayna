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

if($_GET['type'] == 'oldPassword'):
    
    if (!empty($_GET['oldPassword'])) :
        global $wpdb;
      
        $results = $wpdb->get_row("SELECT * FROM wp_bs_teacher WHERE password_teacher = '" . md5($_GET['oldPassword']) . "'", 'ARRAY_A');

        if($results['password_teacher'] == md5($_GET['oldPassword']))
        {
            $valid = true;
        }
        else
        {
            $valid = false;
        }
    else :
        $valid = false;
    endif;

    echo json_encode($valid);

endif;


?>