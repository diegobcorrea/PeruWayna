// AJAX Functions
var jq = jQuery;

jq.extend({
    jYoutube: function( url, size ){
        if(url === null){ return ""; }

        size = (size === null) ? "big" : size;
        var vid;
        var results;

        results = url.match("[\\?&]v=([^&#]*)");

        vid = ( results === null ) ? url : results[1];

        if(size == "small"){
            jq('.previewVideo .image').append(jq('<img src="http://img.youtube.com/vi/'+vid+'/2.jpg" />'));
            jq('.previewVideo .image img').addClass('youtube');
            jq('#videoID').val(vid);
            jq('#videoType').val('youtube');
        }else {
            jq('.previewVideo .image').append(jq('<img src="http://img.youtube.com/vi/'+vid+'/0.jpg" />'));
            jq('.previewVideo .image img').addClass('youtube');
            jq('#videoID').val(vid);
            jq('#videoType').val('youtube');
            jq('#videoImage').val('http://img.youtube.com/vi/'+vid+'/0.jpg');
        }
    }
});