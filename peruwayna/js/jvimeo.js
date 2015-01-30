// AJAX Functions
var jq = jQuery;

jq.extend({
    jVimeo: function( url, size ){
        var url, match;

        if(url === null){ return ""; }

        match = url.match(/^(?:https?:){0,}\/\/\w{0,3}\.?vimeo\.com\/(\d{1,10})/);
        if (match) {
            console.log('matched:' + match[1]);
            jq.ajax({
                type: 'GET',
                url: '//vimeo.com/api/v2/video/' + match[1] + '.json',
                jsonp: 'callback',
                dataType: 'jsonp',
                context: this,
                success: function (data) {
                    console.log(data[0].thumbnail_large);
                    jq('.previewVideo .image').append(jq('<img src="'+data[0].thumbnail_large+'" />'));
                    jq('.previewVideo .image img').addClass('vimeo');
                    jq('#videoID').val(match[1]);
                    jq('#videoType').val('vimeo');
                    jq('#videoImage').val(data[0].thumbnail_large);
                }
            });
        }
    }
});