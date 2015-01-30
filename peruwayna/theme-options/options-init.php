<?php


if (is_admin()) {
    // Theme options
    include_once 'options/theme_options.php';
    include_once 'admin-helper.php';
    include_once 'ajax-image.php';
    include_once 'generate-options.php';
    new reedwan_theme_options($options);

    add_action('admin_head', 'reedwan_admin_head');
}
?>
