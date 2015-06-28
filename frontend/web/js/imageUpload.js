/**
 * Created by jonas on 12.06.15.
 */

$('#settingsmodel-picture').change(fileSelectHandler);

// convert bytes into friendly format
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};

// check for selected crop region
function checkForm() {
    if (parseInt($('#w').val())) return true;
    $('.error').html('Please select a crop region and then press Upload').show();
    return false;
};

// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
    $('#x').val(e.x);
    $('#y').val(e.y);
    $('#w').val(e.w);
    $('#h').val(e.h);
};

// clear info by cropping (onRelease event handler)
function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
};

// Create variables (in this scope) to hold the Jcrop API and image size
var jcrop_api, boundx, boundy;

function fileSelectHandler() {

    // get selected file
    var oFile = $('#settingsmodel-picture')[0].files[0];

    // preview element
    var oImage = document.getElementById('settingsmodel-picture-jcrop');

    // prepare HTML5 FileReader
    var oReader = new FileReader();
    oReader.onload = function(e) {
        // remove class 'img-responsive', because it causes a miscalculation of scaled images
        $('#current-img').hide();
        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;

        oImage.onload = function () { // onload event handler

            // destroy Jcrop if it is existed
            if (typeof jcrop_api != 'undefined') {
                jcrop_api.destroy();
                jcrop_api = null;
                $('#settingsmodel-picture-jcrop').width(oImage.naturalWidth);
                $('#settingsmodel-picture-jcrop').height(oImage.naturalHeight);
            }

            //setTimeout(function(){
                // initialize Jcrop
                $('#settingsmodel-picture-jcrop').Jcrop({
                    minSize: [100, 100], // min crop size
                    aspectRatio : 1, // keep aspect ratio 1:1
                    bgFade: true, // use fade effect
                    bgOpacity: .3, // fade opacity
                    onChange: updateInfo,
                    onSelect: updateInfo,
                    onRelease: clearInfo,
                    boxWidth: $('#imgPreviewWrap').width()
                    //boxHeight: $('#imgPreviewWrap').height()
                }, function(){

                    // use the Jcrop API to get the real image size
                    var bounds = this.getBounds();
                    boundx = bounds[0];
                    boundy = bounds[1];
                    ratio  = 1;
                    var x = 0, y = 0, x_ = boundx, y_ = boundy;

                    var x_r = (x_ / ratio) - y_;
                    var y_r = (y_ / ratio) - x_;

                    if (x_r > 0) {
                        x = x_r / 2;
                    }
                    if (y_r > 0) {
                        y = y_r / 2;
                    }

                    this.setSelect([x, y, boundx, boundy]);
                    // Store the Jcrop API in the jcrop_api variable
                    jcrop_api = this;
                });
            //},3000);

        };
    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}