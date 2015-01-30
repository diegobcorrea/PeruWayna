/* Pinterst blog: JS utils */

var pinThis = function(el) {
  var description = el.getAttribute('data-pin-description'), 
    url = el.getAttribute('data-pin-url'),
    media = '', img = '',
    section = el.parentNode.parentNode.parentNode.getElementsByTagName('SECTION')[0];
  if (section) {
    img = section.getElementsByTagName('IMG')[0];
    if (img && img.src) {
      var media = img.src;
    }
  }
  if (description && url && media) {       
    window.open('http://www.pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=' + encodeURIComponent(media) + '&description=' + encodeURIComponent(description), 'signin', 'width=665,height=300,scrollbars=1,resizable=1');
  }
};