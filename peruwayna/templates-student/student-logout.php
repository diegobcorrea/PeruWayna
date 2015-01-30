<?php
/**
 * Template Name: Student Panel - Logout
 */

    unset($_COOKIE["student_mail"]);
    setcookie("student_mail", '', time()-300);  
    setcookie("student_mail", '', time()-1000, '/');

    unset($_COOKIE["student_password"]);
    setcookie("student_password", '', time()-300);  
    setcookie("student_password", '', time()-1000, '/');

    unset($_COOKIE["student_online"]);
    setcookie("student_online", '', time()-300);  
    setcookie("student_online", '', time()-1000, '/');

    unset($_COOKIE["student_staylogin"]);
    setcookie("student_staylogin", '', time()-300);  
    setcookie("student_staylogin", '', time()-1000, '/');

?>

<script type="text/javascript">
	window.location.replace("<?php echo get_site_url() . '/sistema-de-reservas/'; ?>");
</script>