/**
 * Created by mkaraula on 28.04.15.
 */

$(document).ready(function(){

    $('#header .navbar-toggle').removeAttr('data-target');

});


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

