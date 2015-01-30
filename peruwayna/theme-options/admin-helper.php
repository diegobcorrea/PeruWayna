<?php
if (!function_exists('reedwan_admin_head')) {

    function reedwan_admin_head() {
        ?>
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:700' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="<?php echo get_template_directory_uri()."/theme-options/"; ?>css/reedwan_css.css" />
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()."/theme-options/"; ?>css/colorpicker.css" />
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()."/theme-options/"; ?>css/custom_style.css" />

        <script type="text/javascript" src="<?php echo get_template_directory_uri()."/theme-options/"; ?>js/colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri()."/theme-options/"; ?>js/ajaxupload.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri()."/theme-options/"; ?>js/mainJs.js"></script>
        <?php
    }

}
?>