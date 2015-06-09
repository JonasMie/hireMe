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
            easing: "easeOutQuad",
            duration: 400,
            step : function(val){
                c.attr("r", val);
            }
        }
    );
});

/** END Touch Ripple Function **/


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

