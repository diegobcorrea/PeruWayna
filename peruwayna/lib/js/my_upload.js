jQuery.noConflict();
(function($) {

$(document).ready(function() {
	var formfield, tbframe_interval;
	
	$('input.upload_img').live("click", function () {
    formfield = $(this).prev('input');
		
		//Change "insert into post" to "Use this Button"
		tbframe_interval = setInterval(function() {jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Use This File');}, 2000);
        		
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html) {
		
  		if (formfield) {
  		
  		  clearInterval(tbframe_interval);
  		  if ( $(html).html(html).find('img').length > 0 ) {
          itemurl = $('img',html).attr('src');
        } else {
          var htmlBits = html.split("'");
          itemurl = htmlBits[1]; // Use the URL to the file.
          	
          var itemtitle = htmlBits[2];
          
          itemtitle = itemtitle.replace( '>', '' );
          itemtitle = itemtitle.replace( '</a>', '' );
        }

        $(formfield).val(itemurl);

        tb_remove();
        
      } else {
        window.original_send_to_editor(html);
      }
    
      formfield = '';
    }
    
		tb_show('', 'media-upload.php?post_id=0&type=image&TB_iframe=1');		
		return false;
	});
});

})(jQuery);
