<?php
/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;

define("THEME_THEMENAME", 'PERUWAYNA');

define("THEME_LIB_URL", get_template_directory_uri(). '/lib/');
define('THEME_FRAMEWORK', get_template_directory() . '/lib/');
define("THEME_ADMIN", THEME_FRAMEWORK . '/admin');
define("THEME_IMAGES_URL", get_template_directory_uri(). '/lib/images/');
define("THEME_FUNCTIONS_PATH", TEMPLATEPATH . '/lib/functions/');
define("THEME_CSS_URL", get_template_directory_uri() . '/lib/css/');
define("THEME_SCRIPT_URL", get_template_directory_uri() . '/lib/js/');
define("THEME_UTILS_URL", get_template_directory_uri() . '/lib/utils/');
define("THEME_TIMTHUMB_URL", THEME_UTILS_URL . 'timthumb.php');

$uploadsdir=wp_upload_dir();
define("THEME_UPLOADS_URL", $uploadsdir['url']);

if(is_admin()){

	add_action('admin_enqueue_scripts', 'theme_admin_init');
	add_action('admin_head', 'theme_admin_head_add');

	/**
	 * Enqueues the JavaScript files needed depending on the current section.
	 */
	function theme_admin_init(){

		//enqueue the script and CSS files for the TinyMCE editor formatting buttons and Upload functionality
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('theme-page-options',THEME_SCRIPT_URL.'page-options.js');
		wp_enqueue_script('theme-metaboxes-options',THEME_SCRIPT_URL.'metaboxes_scripts.js');
		wp_enqueue_script('theme-myupload-options',THEME_SCRIPT_URL.'my_upload.js');
		wp_enqueue_script('theme-options',THEME_SCRIPT_URL.'options.js');
		
		

		//set the style files
		add_editor_style('lib/formatting-buttons/custom-editor-style.css');
		wp_enqueue_style('theme-page-style',THEME_CSS_URL.'page_style.css');
		wp_enqueue_style('theme-metaboxes-style',THEME_CSS_URL.'metaboxes_styles.css');

	}

	/**
	 * Inserts scripts for initializing the JavaScript functionality for the relevant section.
	 */
	function theme_admin_head_add(){
		
		//create JavaScript variables that will be accessible globally from all scripts
		echo '<script type="text/javascript">
		pexetoUploadHandlerUrl="'.THEME_UTILS_URL.'upload-handler.php",
		pexetoUploadsUrl="'.THEME_UPLOADS_URL.'";
		</script>';
	}

}

//------ THEME OPTIONS PANEL ------//
require_once('theme-options/options-init.php');

require_once (THEME_FUNCTIONS_PATH.'meta.php');  // adds the custom meta fields to the posts and pages
require_once (THEME_FUNCTIONS_PATH.'ajax.php');  // add custom ajax functions
require_once (THEME_FUNCTIONS_PATH.'email-templates.php');  // add custom email templates

function theme_setup() {

	load_theme_textdomain( 'theme', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	//------ Post Formats ------//
	add_theme_support( 'post-formats', array( 'video', 'audio', 'gallery' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'theme' ) );
	register_nav_menu( 'top', __( 'Top Menu', 'theme' ) );
	register_nav_menu( 'left', __( 'Left Menu', 'theme' ) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
	add_image_size( 'homepage-thumb', 230, 130, true );
	add_image_size( 'slider-image', 630, 280, true );
}
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Add intermediate image sizes to media gallery modal dialog
 */
 
function image_sizes_attachment_fields_to_edit( $form_fields, $post ) {
    if ( !is_array( $imagedata = wp_get_attachment_metadata( $post->ID ) ) )
        return $form_fields;
 
    if ( is_array($imagedata['sizes']) ) :
        foreach ( $imagedata['sizes'] as $size => $val ) :
            if ( $size != 'thumbnail' && $size != 'medium' && $size != 'large' ) :
                $css_id = "image-size-{$size}-{$post->ID}";
                $html .= '<div class="image-size-item"><input type="radio" name="attachments[' . $post->ID . '][image-size]" id="' . $css_id . '" value="' . $size . '" />';
                $html .= '<label for="' . $css_id . '">' . $size . '</label>';
                $html .= ' <label for="' . $css_id . '" class="help">' . sprintf( __("(%d&nbsp;&times;&nbsp;%d)"), $val['width'], $val['height'] ). '</label>';
                $html .= '</div>';
            endif;
        endforeach;
    endif;
 
    $form_fields['image-size']['html'] .= $html;
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'image_sizes_attachment_fields_to_edit', 100, 2 );

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function theme_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	wp_enqueue_script('jquery');
	wp_enqueue_script('theme-js-bootstrap', get_template_directory_uri() . '/js/bootstrap.js');
	wp_enqueue_script('theme-js-validate', get_template_directory_uri() . '/js/jquery.validate.js');
	wp_enqueue_script('theme-js-getURLparam', get_template_directory_uri() . '/js/jquery.getURLparam.js');
	wp_enqueue_script('theme-js-cookie', get_template_directory_uri() . '/js/jquery.cookie.js');
	wp_enqueue_script('theme-js-moment', get_template_directory_uri() . '/js/jquery.moment.js');
	wp_enqueue_script('theme-js-datetimepicker', get_template_directory_uri() . '/js/jquery.datetimepicker.js');
	wp_enqueue_script('theme-js-bootstrap-datepicker', get_template_directory_uri() . '/js/bootstrap-datepicker.js');
	wp_enqueue_script('theme-js-dataTables', get_template_directory_uri() . '/js/jquery.dataTables.js');
	wp_enqueue_script('theme-js-chosen', get_template_directory_uri() . '/js/chosen.jquery.js');
	wp_enqueue_script('theme-js-global', get_template_directory_uri() . '/js/global.js');
	//wp_enqueue_script('jquery-ui-datepicker');


    wp_localize_script( 'theme-js-global', 'apfajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_script('theme-js-ajax', get_template_directory_uri() . '/js/ajax.js', '', '', true );

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );

	wp_enqueue_style( 'theme-CSS-mCustomScrollbar', get_template_directory_uri() . '/css/jquery.mCustomScrollbar.css', array( 'theme-style' ), '20141004' );

	wp_enqueue_style( 'theme-base', get_template_directory_uri() . '/css/base.css', array( 'theme-style' ), '20131002' );
	wp_enqueue_style( 'theme-layout', get_template_directory_uri() . '/css/layout.css', array( 'theme-style' ), '20131002' );
	wp_enqueue_style( 'theme-skeleton', get_template_directory_uri() . '/css/skeleton.css', array( 'theme-style' ), '20131002' );

	wp_enqueue_style( 'theme-chosen', get_template_directory_uri() . '/css/chosen.css', array( 'theme-style' ), '20131002' );

	wp_enqueue_style( 'theme-css-bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array( 'theme-style' ), '20131002' );
	wp_enqueue_style( 'theme-css-bootstrap-theme', get_template_directory_uri() . '/css/bootstrap-theme.css', array( 'theme-style' ), '20131002' );
	wp_enqueue_style( 'theme-css-bootstrapdatetime-theme', get_template_directory_uri() . '/css/bootstrap-datetimepicker.css', array( 'theme-style' ), '20131002' );
	wp_enqueue_style( 'theme-css-bootstrapdatepicker-theme', get_template_directory_uri() . '/css/datepicker3.css', array( 'theme-style' ), '20131002' );

	/*
	 * Loads the Internet Explorer specific stylesheet.
	 */
	wp_enqueue_style( 'theme-ie', get_template_directory_uri() . '/css/ie.css', array( 'theme-style' ), '20131002' );
	$wp_styles->add_data( 'theme-ie', 'conditional', 'lt IE 9' );

	if( is_page( 'admin-panel' ) ){

		wp_enqueue_script('theme-page-options',THEME_SCRIPT_URL.'page-options.js');
		wp_enqueue_script('theme-ajaxupload-options', get_template_directory_uri() .'/theme-options/js/ajaxupload.js');
		wp_enqueue_script('theme-myupload-options',THEME_SCRIPT_URL.'my_upload.js');
		wp_enqueue_script('theme-options',THEME_SCRIPT_URL.'options.js');

		//create JavaScript variables that will be accessible globally from all scripts
		echo '<script type="text/javascript">
		pexetoUploadHandlerUrl="'.THEME_UTILS_URL.'upload-handler.php",
		pexetoUploadsUrl="'.THEME_UPLOADS_URL.'";
		</script>';
	}

	if( is_page( 'registro' ) || is_page( 'perfil' ) || is_page( 'mi-perfil' ) ){

		wp_enqueue_script('theme-page-options',THEME_SCRIPT_URL.'page-options.js');
		wp_enqueue_script('theme-ajaxupload-options', get_template_directory_uri() .'/theme-options/js/ajaxupload.js');
		wp_enqueue_script('theme-myupload-options',THEME_SCRIPT_URL.'my_upload.js');
		wp_enqueue_script('theme-options',THEME_SCRIPT_URL.'options.js');

		//create JavaScript variables that will be accessible globally from all scripts
		echo '<script type="text/javascript">
		pexetoUploadHandlerUrl="'.THEME_UTILS_URL.'upload-handler-front.php",
		pexetoUploadsUrl="'.THEME_UPLOADS_URL.'";
		</script>';
	}
}
add_action( 'wp_enqueue_scripts', 'theme_scripts_styles' );

function theme_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'theme' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'theme_wp_title', 10, 2 );

function my_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
};

function _login_member() {
	global $post;
 
	if(isset($_POST['login_username']) && wp_verify_nonce($_POST['login_nonce'], 'login-nonce')) {
 
		// this returns the user ID and other info from the user name
		$user = get_userdatabylogin($_POST['login_username']);
 
		if(!$user) {
			// if the user name doesn't exist
			_errors()->add('empty_username', __('El usuario es incorrecto.'));
		}
 
		if(!isset($_POST['login_password']) || $_POST['login_password'] == '') {
			// if no password was entered
			_errors()->add('empty_password', __('El campo contraseña está vacío.'));
		}
 
		// check the user's login with their password
		if(!wp_check_password($_POST['login_password'], $user->user_pass, $user->ID)) {
			// if the password is incorrect for the specified user
			_errors()->add('empty_password', __('La contraseña que introdujo no es correcta'));
		}
 
		// retrieve all error messages
		$errors = _errors()->get_error_messages();
 
		// only log the user in if there are no errors
		if(empty($errors)) {
 
			wp_setcookie($_POST['login_username'], $_POST['login_password'], true);
			wp_set_current_user($user->ID, $_POST['login_username']);	
			do_action('wp_login', $_POST['login_username']);
 
			wp_redirect( get_site_url() . '/admin-panel/' ); exit;
		}
	}
}
add_action('init', '_login_member');

function _login_student() {
	global $post;
 
	if(isset($_POST['student_username']) && wp_verify_nonce($_POST['student_nonce'], 'student-nonce')) {

		session_start();
 
 		global $wpdb;
 		$user = $wpdb->get_row( 'SELECT * FROM wp_bs_student WHERE email_student = "'.$_POST['student_username'].'"', OBJECT );
	 
		if($user->email_confirm == 0) {
			// if the user name doesn't exist
			_errors()->add('empty_confirmation', __('Aún no confirmas tu correo de validación.'));
		}
		else if($user->email_student != $_POST['student_username']) {
			// if the user name doesn't exist
			_errors()->add('empty_username', __('El usuario es incorrecto.'));
		}
	 	else{
			if(!isset($_POST['student_password']) || $_POST['student_password'] == '') {
				// if no password was entered
				_errors()->add('empty_password', __('El campo contraseña está vacío.'));
			}
	 
			// check the user's login with their password
			if($user->password_student != md5($_POST['student_password'])) {
				// if the password is incorrect for the specified user
				_errors()->add('empty_password', __('La contraseña que introdujo no es correcta'));
			}
	 
			// retrieve all error messages
			$errors = _errors()->get_error_messages();
	 
			// only log the user in if there are no errors
			if(empty($errors)) {

				if(isset($_POST['student_staylogin']) AND $_POST['student_staylogin'] == 'yes'){
					setcookie ("student_staylogin", "1", time() + 3600*24*90, '/');
					setcookie ("student_mail", $_POST['student_username'], time() + 3600*24*90, '/');
		 			setcookie ("student_password", md5($_POST['student_password']), time() + 3600*24*90, '/');
		 			setcookie ("student_online", "1", time() + 3600*24*90, '/');
				}else{
					setcookie ("student_mail", $_POST['student_username'], 0, '/');
		 			setcookie ("student_password", md5($_POST['student_password']), 0, '/');
		 			setcookie ("student_online", "1", 0, '/');
				}
	 
				wp_redirect( get_site_url() . '/sistema-de-reservas/' ); exit;
			}
		}
	}
}
add_action('init', '_login_student');

function _login_teacher() {
	global $post;
 
	if(isset($_POST['teacher_email']) && wp_verify_nonce($_POST['teacher_nonce'], 'teacher-nonce')) {

		session_start();
 
 		global $wpdb;
		$user = $wpdb->get_row( 'SELECT * FROM wp_bs_teacher WHERE email_c_teacher = "'.$_POST['teacher_email'].'"', OBJECT );
	 
		if($user->email_c_teacher != $_POST['teacher_email']) {
			// if the user name doesn't exist
			_errors()->add('empty_username', __('El correo electrónico es incorrecto.'));
		}
		else{
			if(!isset($_POST['teacher_password']) || $_POST['teacher_password'] == '') {
				// if no password was entered
				_errors()->add('empty_password', __('El campo contraseña está vacío.'));
			}
	 
			// check the user's login with their password
			if($user->password_teacher != md5($_POST['teacher_password'])) {
				// if the password is incorrect for the specified user
				_errors()->add('empty_password', __('La contraseña que introdujo no es correcta'));
			}
	 
			// retrieve all error messages
			$errors = _errors()->get_error_messages();
	 
			// only log the user in if there are no errors
			if(empty($errors)) {

				if(isset($_POST['teacher_staylogin']) AND $_POST['teacher_staylogin'] == 'yes'){
					setcookie ("teacher_staylogin", "1", time() + 3600*24*90, '/');
					setcookie ("teacher_mail", $_POST['teacher_email'], time() + 3600*24*90, '/');
		 			setcookie ("teacher_password", md5($_POST['teacher_password']), time() + 3600*24*90, '/');
		 			setcookie ("teacher_online", "1", time() + 3600*24*90, '/');
				}else{
					setcookie ("teacher_mail", $_POST['teacher_email'], 0, '/');
		 			setcookie ("teacher_password", md5($_POST['teacher_password']), 0, '/');
		 			setcookie ("teacher_online", "1", 0, '/');
				}
	 
				wp_redirect( get_site_url() . '/modulo-profesor/' ); exit;
			}

		}
	}
}
add_action('init', '_login_teacher');

function show_error_messages() {
	if($codes = _errors()->get_error_codes()) {
		echo '<div id="login_error">';
		    // Loop error codes and display errors
		   foreach($codes as $code){
		        $message = _errors()->get_error_message($code);
		        echo '<strong>' . __('Error') . '</strong>: ' . $message . '<br/>';
		    }
		echo '</div>';
	}	
}

// used for tracking error messages
function _errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

function getClassStatus( $class, $disabled = false ) {
	if($disabled == true){
		switch ($class) {
			case 'CANCELADA +':
				$_class = 'disabled';
				break;
			case 'CANCELADA -':
				$_class = 'disabled';
				break;
			case 'SUSPENDIDA':
				$_class = 'disabled';
				break;
			case 'SUSPENDIDA SIN ALUMNO':
				$_class = 'disabled';
				break;
		};
	}else{
		switch ($class) {
			case 'DISPONIBLE':
				$_class = 'available';
				break;
			case 'CONFIRMADA':
				$_class = 'confirm';
				break;
			case 'COMPLETADA':
				$_class = 'complete';
				break;
			case 'CANCELADA +':
				$_class = 'cancel';
				break;
			case 'CANCELADA -':
				$_class = 'cancel';
				break;
			case 'SUSPENDIDA':
				$_class = 'cancel';
				break;
			case 'SUSPENDIDA SIN ALUMNO':
				$_class = 'cancel';
				break;
			case 'ALUMNO FALTÓ':
				$_class = 'miss';
				break;
		};
	};
	echo $_class;
}

function m2h($mins) { 
    if ($mins < 0) { 
        $min = ABS($mins); 
    } else { 
        $min = $mins; 
    } 
    $H = FLOOR($min / 60); 
    $M = ($min - ($H * 60)); 
    if(STRLEN($M) < 2) { 
		$M = $M . 0; 
	}
    $hours = $H. ":" .$M; 
    
    return $hours; 
}  

add_filter( 'cron_schedules', 'cron_add_params' );
 
function cron_add_params( $schedules ) {

 	$schedules['twice_hour'] = array(
 		'interval' => 1800,
 		'display' => __( 'Cada 30 minutos' )
 	);
 	$schedules['every_minute'] = array(
 		'interval' => 60,
 		'display' => __( 'Cada minuto' )
 	);
 	$schedules['every_five'] = array(
 		'interval' => 300,
 		'display' => __( 'Cada 5 minutos' )
 	);
 	return $schedules;
}

add_action( 'prefix_twice_hour_event', 'prefix_do_this_hourly' );
function prefix_do_this_hourly() {
	// Make sure we have access to WP functions namely WPDB
	include_once($_SERVER['DOCUMENT_ROOT'].'/clientes/peruwayna/wp-config.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/clientes/peruwayna/wp-load.php');

	global $wpdb, $dias, $meses, $to;
	
	$h = "5";
    $hm = $h * 60; 
    $ms = $hm * 60;

	$now = date('m-d-Y',time()-($ms));
	$time = date('h:i A',time()-($ms));
	$getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE status = 'CONFIRMADA' AND reminder = '0' ORDER BY date_class ASC", OBJECT );

	foreach ($getClasses as $key => $class) : 
		$date = explode("-", $class->date_class);
		$formatDate = $date[0].'-'.$date[1].'-'.$date[2] . $class->start_class;
		$date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] . $class->start_class ); 

		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	    $today = date('Y-m-d h:i A',time()-($ms));

		$dteStart = new DateTime($today); 
		$dteEnd   = new DateTime($formatDate);

		$dteDiff  = $dteStart->diff($dteEnd);
		$hours = $dteDiff->h;
		$hours = $hours + ($dteDiff->days*24);
		$minutes = $dteDiff->i;

		if($class->status == 'CONFIRMADA'){
			if($hours <= 23 AND $minutes <= 59){

				if($class->id_student != 0){
					$getStudent = $wpdb->get_row( "SELECT * FROM wp_bs_student WHERE id_student = $class->id_student", OBJECT );

					$studentName = $getStudent->name_student .' '.$getStudent->lastname_student;
					$to = $getStudent->email_student;

					$getTeacher = $wpdb->get_row( "SELECT * FROM wp_bs_teacher WHERE id_teacher = $class->id_teacher", OBJECT );
					$toTeacher = $getTeacher->email_p_teacher;

					$teacherName = $getTeacher->name_teacher .' '.$getTeacher->lastname_teacher;

					$subject = 'Peruwayna - Recordatorio de Clase';

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
					                                        <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Recordatorio de clase!</h1>
					                                        <p>Recuerda que tienes esta clase pronto, toma las medidas necesarias para poder asistir.</p>
					                                        
					                                        <p>Los detalles de la clase reservada son:</p>

					                                        <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
				                                                <tbody>
				                                                    <tr>
				                                                        <td>Fecha: ".$dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date)."</td>
				                                                    </tr>
				                                                    <tr>
				                                                        <td>Hora: De ".$class->start_class." a ".$class->end_class."</td>
				                                                    </tr>
				                                                    <tr>
				                                                        <td>Nombre del Profesor: ".$teacherName."</td>
				                                                    </tr>
				                                                    <tr>
				                                                        <td>Skype: ".$getTeacher->skype_teacher."</td>
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

				    	$subject = 'Peruwayna - Recordatorio de Clase';

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
				    	                                        <h1 style='color: #ff4546; font-family: Arial; font-size: 36px; line-height: 1em;'>¡Recordatorio de clase!</h1>
				    	                                        <p>Recuerda que tienes esta clase pronto, toma las medidas necesarias para poder asistir.</p>
				    	                                        
				    	                                        <p>Los detalles de la clase reservada son:</p>

				    	                                        <table width='270' cellspacing='0' cellpadding='0' style='border: 2px solid #000; font-family: Arial; padding: 10px;'>
				                                                    <tbody>
				                                                        <tr>
				                                                            <td>Fecha: ".$dias[date('w', $date)]." ".date('d',$date)." de ". $meses[date('n', $date)-1]. " del ".date('Y', $date)."</td>
				                                                        </tr>
				                                                        <tr>
				                                                            <td>Hora: De ".$class->start_class." a ".$class->end_class."</td>
				                                                        </tr>
				                                                        <tr>
				                                                            <td>Nombre del Alumno: ".$studentName."</td>
				                                                        </tr>
				                                                        <tr>
				                                                            <td>Skype: ".$getStudent->skype_student."</td>
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

				        $mail->AddAddress($toTeacher);

				        $mail->Subject = utf8_decode($subject);

				        $mail->MsgHTML( utf8_decode($message) );

				        if( $mail->Send() ) {
				        	echo "sendMail";
				    		$wpdb->update( 'wp_bs_class', array('reminder' => '1'), array('id_class' => $class->id_class), array('%d'), array('%d') );
				    	}
					}else{
					    echo "errorMail";
					} 

				}

			}
		}
	endforeach;

}

add_action( 'updatestatus_twice_hour_event', 'updatestatus_do_this_twice' );
function updatestatus_do_this_twice() {
	// Make sure we have access to WP functions namely WPDB
	include_once($_SERVER['DOCUMENT_ROOT'].'/clientes/peruwayna/wp-config.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/clientes/peruwayna/wp-load.php');

	global $wpdb, $dias, $meses;
	
	$h = "5";
    $hm = $h * 60; 
    $ms = $hm * 60;

	$now = date('Y-m-d',time()-($ms));
	$time = date('h:i A',time()-($ms));
	$getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE status = 'CONFIRMADA' ORDER BY date_class ASC", OBJECT );

	foreach ($getClasses as $key => $class) : 
		$date = explode("-", $class->date_class);
		$formatDate = $date[0].'-'.$date[1].'-'.$date[2] . $class->end_class;
		$date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] . $class->start_class ); 

		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	    $today = date('Y-m-d h:i A',time()-($ms));

		$dteStart = new DateTime($today); 
		$dteEnd   = new DateTime($formatDate);

		$dteDiff  = $dteStart->diff($dteEnd);
		$hours = $dteDiff->h;
		$minutes = $dteDiff->i;
		$second = $dteDiff->s;

		if($class->status == 'CONFIRMADA'){
			if($hours == 0 AND $minutes == 0 AND $second == 0 OR $dteDiff->invert == 1){
				$wpdb->update( 'wp_bs_class', array('status' => 'COMPLETADA'), array('id_class' => $class->id_class), array('%s'), array('%d') );
				$wpdb->query("DELETE FROM wp_bs_availability WHERE id_teacher = '$class->id_teacher' AND available_date = '$class->date_class' AND available_time = '$class->start_class'");
			}
		}
	endforeach;

}

add_action( 'updatedisponibletwice_hour_event', 'updatestatus_disponible_this_twice' );
function updatestatus_disponible_this_twice() {
	// Make sure we have access to WP functions namely WPDB
	include_once($_SERVER['DOCUMENT_ROOT'].'/clientes/peruwayna/wp-config.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/clientes/peruwayna/wp-load.php');

	global $wpdb, $dias, $meses;
	
	$h = "5";
    $hm = $h * 60; 
    $ms = $hm * 60;

	$now = date('Y-m-d',time()-($ms));
	$time = date('h:i A',time()-($ms));
	$getClasses = $wpdb->get_results( "SELECT * FROM wp_bs_class WHERE status = 'DISPONIBLE' ORDER BY date_class ASC", OBJECT );

	foreach ($getClasses as $key => $class) : 
		$date = explode("-", $class->date_class);
		$formatDate = $date[0].'-'.$date[1].'-'.$date[2] . $class->start_class;
		$date = strtotime( $date[0].'/'.$date[1].'/'.$date[2] . $class->start_class ); 

		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	    $today = date('Y-m-d h:i A',time()-($ms));

		$dteStart = new DateTime($today); 
		$dteEnd   = new DateTime($formatDate);

		$dteDiff  = $dteStart->diff($dteEnd);
		$hours = $dteDiff->h;
		$minutes = $dteDiff->i;
		$second = $dteDiff->s;

		if($class->status == 'DISPONIBLE'){
			if($hours == 0 AND $minutes == 0 AND $second == 0 OR $dteDiff->invert == 1){
				$wpdb->update( 'wp_bs_class', array('status' => 'EXPIRADA'), array('id_class' => $class->id_class), array('%s'), array('%d') );
				$wpdb->query("DELETE FROM wp_bs_availability WHERE id_teacher = '$class->id_teacher' AND available_date = '$class->date_class' AND available_time = '$class->start_class'");
			}
		}
	endforeach;

}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}