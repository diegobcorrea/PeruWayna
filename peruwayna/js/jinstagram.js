// AJAX Functions
var jq = jQuery;

jq.extend({
    jInstagram: function( url ){
        var url;

        if(url === null){ return ""; }

        var instagram_json = "http://api.instagram.com/oembed?format=json&maxwidth=500&maxheight=380&url="+url; 
        var urlsplit = url.split("/");
        var code = urlsplit[4];

        jq.ajax({
            type: 'GET',
            url: instagram_json,
            jsonp: 'callback',
            dataType: 'jsonp',
            context: this,
            success: function (data) {
                console.log(data);
                var media_json = "https://api.instagram.com/v1/media/"+data.media_id+"?access_token=320057827.f59def8.ffb45d6a66c94b99b5826d310c6833d6"; 

                jq.ajax({
                    type: 'GET',
                    url: media_json,
                    jsonp: 'callback',
                    dataType: 'jsonp',
                    context: this,
                    success: function (media) {
                        console.log(media);
                        jq('.previewVideo .image').append(jq('<img src="'+media.data.images.low_resolution.url+'" />'));
                        jq('.previewVideo .image img').addClass('instagram');
                        jq('#videoID').val(code);
                        jq('#videoType').val('instagram');
                        jq('#videoImage').val(media.data.images.low_resolution.url);
                    }
                });
            }
        });
    }
});