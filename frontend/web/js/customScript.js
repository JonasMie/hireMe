/**
 * Created by mkaraula on 28.04.15.
 */


/** Animation for Hamburger Icon on Mobile View */
var hamburgerClickedClass = false;

$('#header .navbar-header .navbar-toggle').click(function(){
    if (!hamburgerClickedClass) {
        $(this).addClass('clicked');
    } else {
        $(this).removeClass('clicked');
    }
    hamburgerClickedClass = !hamburgerClickedClass;
});

/** END Animation for Hamburger Icon on Mobile View */