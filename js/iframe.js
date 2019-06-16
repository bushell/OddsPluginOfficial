jQuery(document).ready(function ($) {
    var iframe_width = jQuery('#appframe').parent().width();
    console.log('width: ' + iframe_width);
    jQuery('#appframe').css('width', iframe_width);
});


////////////////////////////////

jQuery('#appframe').mutate('height', function (element, info) {
    console.log('chnged');
    var iFrameID = document.getElementById('appframe');
    iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + 'px';
});

function iframeLoaded() { var iFrameID = document.getElementById('#appframe'); if (iFrameID) { iFrameID.height = ''; iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + 'px'; } }

/////////////////////////////////////

function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

jQuery('#appframe').mutate('height', function (element, info) {

    var iFrameID = document.getElementById('appframe');
    iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + 'px';

});

function iframeLoaded() {
    var iFrameID = document.getElementById('appframe');
    if (iFrameID) {
        // // here you can make the height, I delete it first, then I make it again
        iFrameID.height = '';

        iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + 'px';

    }

}

var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
// Listen for a message from the iframe.
eventer(messageEvent, function(e) {
  if (isNaN(e.data)) return;

  // replace #sizetracker with what ever what ever iframe id you need
  document.getElementById('iframe').style.height = e.data + 'px';

}, false);