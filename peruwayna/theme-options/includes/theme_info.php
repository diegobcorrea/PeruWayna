<?php
$reedwan_theme_data = get_theme_data(get_template_directory() . '/style.css');
define('THEME_NAME', $reedwan_theme_data['Name']);
define('THEME_AUTHOR', $reedwan_theme_data['Author']);
define('THEME_VERSION', trim($reedwan_theme_data['Version']));
define('FRAMEWORK_NAME', 'BlogSaga - Moda');
?>
