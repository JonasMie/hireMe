/**
 * Created by mkaraula on 28.04.15.
 */

$(document).ready(function(){

    $('#header .navbar-toggle').removeAttr('data-target');
	
	/** Insert Slideout-Helper for Scrollable Mobile Navigation */
	$('#header-collapse').wrapInner( '<div class="slideout-helper"></div>' );
	/** END Insert Slideout-Helper for Scrollable Mobile Navigation */
	
	/** Focus input field with class "typeStart" when typing randomly on page */
	if ($('.typeStart')[0]){
		var default_input_handler = function() {
			$('.typeStart').focus();
			$(document).off('keydown', default_input_handler);
		}

		$(document).on('keydown', default_input_handler);

		$('input, textarea, select').on('focus', function() {
			$(document).off('keydown', default_input_handler);
		});
	}
	/** END Focus input field with class "typeStart" when typing randomly on page */

    /** INITIALIZING ICHECK **/
    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat'
    });


});


/** Frontpage: Check if elements are in viewport */
/** See: http://www.jqueryscript.net/animation/jQuery-Plugin-For-Element-Fade-Slide-Effects-As-You-Scroll-FadeThis.html */

$(document).ready(function() {
$(window).fadeThis({
baseName:       "slide-",
speed:          500, // <a href="http://www.jqueryscript.net/animation/">Animation</a> speed in milliseconds.
easing:         "swing", // Animation easing.
offset:         0, // <a href="http://www.jqueryscript.net/tags.php?/Scroll/">Scroll</a> offset, allowing to fire fading a little after or before the element appear.
reverse:        false, // Make element disappear again when scrolled out, and fade again when scrolled in. 
distance:       50, // Element distance to its emplacement, before animation.
scrolledIn:     null, // Function to call when the element come in viewport. 
scrolledOut:    null // Function to call when the element go out of the viewport. 
});
});

/** Frontpage: Check if elements are in viewport */


/** Animation for Hamburger Icon on Mobile View */
var hamburgerClickedClass = false;

$('#header .navbar-header .navbar-toggle').click(function(){
    if (!hamburgerClickedClass) {
        $(this).addClass('clicked');
        $('.wrap > .container').addClass('out');
        $('body').addClass('overflowx');
        $('#header-collapse').addClass('slidedout');
    } else {
        $(this).removeClass('clicked');
        $('.wrap > .container').removeClass('out');
        $('body').removeClass('overflowx');
        $('#header-collapse').removeClass('slidedout');
    }
    hamburgerClickedClass = !hamburgerClickedClass;
});
/** END Animation for Hamburger Icon on Mobile View */


/** Helper function for the header dropdown **/
    $('.dropdown').on('show.bs.dropdown', function () {
            $(this).find('.dropdown-menu').first().stop(false, false).slideDown(200);
    });

    $('.dropdown').on('hide.bs.dropdown', function () {
            $(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
    });
/** END Helper function for the header dropdown **/


/** Touch Ripple Function **/
$(".ripple").on("click", function(e){

    e.preventDefault();

    var x = e.pageX;
    var y = e.pageY;
    var clickY = y - $(this).offset().top;
    var clickX = x - $(this).offset().left;
    var box = this;

    var setX = parseInt(clickX);
    var setY = parseInt(clickY);
    $(this).find("svg").remove();
    $(this).append('<svg><circle cx="'+setX+'" cy="'+setY+'" r="'+0+'"></circle></svg>');

    var c = $(box).find("circle");
    c.animate(
        {
            "r" : $(box).outerWidth()
        },
        {
            easing: "linear",
            duration: 400,
            step : function(val){
                c.attr("r", val);
            },
            complete: function() {
                location.href = $(box).attr('href');
            }
        }
    );
});
/** END Touch Ripple Function **/


/** Helper Function for Input Forms **/
$('input[type=text]').focus(function () {
    if ($(this).attr('class') == 'form-control tt-input') { //Typeahead Fix
        $(this).parent().parent().prev().addClass('typeahead-label-in-focus');
    } // END Typeahead Fix
    $(this).parent().addClass('input-in-focus');
}).blur(function () {
    $(this).parent().removeClass('input-in-focus');
});
/** END Helper Function for Input Forms **/


/** Replace all SVG images with inline SVG **/
jQuery('img.svg').each(function(){
    var $img = jQuery(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');

    jQuery.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = jQuery(data).find('svg');

        // Add replaced image's ID to the new SVG
        if(typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if(typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass+' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Replace image with new SVG
        $img.replaceWith($svg);

    }, 'xml');
});
/** END Replace all SVG images with inline SVG **/


/** Demo Chart **/
var data = [
    {
        value: 965,
        color: "rgba(93,202,136,0.5)",
        label: "Bewerbungen"
    },
    {
        value: 84,
        color: "rgb(221,221,221)",
        label: "Stellenanzeigen"
    }
];


var ctx = document.getElementById("DashboardChart").getContext("2d");
var myNewChart = new Chart(ctx).Doughnut(data);
/** END Demo**/






