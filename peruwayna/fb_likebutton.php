<?php 

$ID = $_GET['postID'];
$url = $_GET['url'];
$num = $_GET['num'];

?>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
  <title>Ficha #<?php echo $num ?> - Pichanga Tottus</title>
</head>

<script type='text/javascript' src='http://www.blogsagafalabella.com/moda/wp-includes/js/jquery/jquery.js?ver=1.11.0'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var ajax_object = {"ajax_url":"http:\/\/www.maspormenos.com.pe\/pichangatottus\/wp-admin\/admin-ajax.php"};
/* ]]> */
</script>

<script type="text/javascript">

var jq = jQuery;

jq(document).ready(function(){
  window.fbAsyncInit = function() {

    FB.init({
      appId      : '721748604513126',
      xfbml      : true,
      version    : 'v2.0'
    });

    FB.Event.subscribe('edge.create', function(response) {
      var ID = <?php echo $ID; ?>;

      jq.ajax({
          type: 'POST',
          url: 'http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/update-votes.php',
          data: { 
              id: ID, 
              type: 'plus',
          },
          success: function(msg){
            console.log(msg);
          }
      });

    });

    FB.Event.subscribe('edge.remove', function(response) {
      var ID = <?php echo $ID; ?>;

      jq.ajax({
          type: 'POST',
          url: 'http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/update-votes.php',
          data: { 
              id: ID,
              type: 'minus', 
          },
          success: function(msg){
            console.log(msg);    
          }
      });

    });
  }  
});

</script>

<style type="text/css">
body { margin: 0px; }
</style>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=257796824412950&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div style="position: relative">
  <div style="position: absolute"></div>
  <div class="fb-like" data-href="<?php echo $url; ?>" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
</div>

</body>
</html>