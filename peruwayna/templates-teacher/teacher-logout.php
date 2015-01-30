<?php
/**
 * Template Name: Teacher Panel - Logout
 */

    unset($_COOKIE["teacher_mail"]);
    setcookie("teacher_mail", '', time()-300);  
    setcookie("teacher_mail", '', time()-1000, '/');

    unset($_COOKIE["teacher_password"]);
    setcookie("teacher_password", '', time()-300);  
    setcookie("teacher_password", '', time()-1000, '/');

    unset($_COOKIE["teacher_online"]);
    setcookie("teacher_online", '', time()-300);  
    setcookie("teacher_online", '', time()-1000, '/');

    unset($_COOKIE["teacher_staylogin"]);
    setcookie("teacher_staylogin", '', time()-300);  
    setcookie("teacher_staylogin", '', time()-1000, '/');

?>

<script type="text/javascript">
	window.location.replace("<?php echo get_site_url() . '/modulo-profesor/'; ?>");
</script>