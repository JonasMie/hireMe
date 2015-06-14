/**
 * Created by mkaraula on 28.04.15.
 */

$(document).ready(function(){

    $('#header .navbar-toggle').removeAttr('data-target');
	
	/** Insert Slideout-Helper for Scrollable Mobile Navigation */
	$('#header-collapse').wrapInner( '<div class="slideout-helper"></div>' );
	/** END Insert Slideout-Helper for Scrollable Mobile Navigation */

});

/** Focus input field with class "typeStart" when typing randomly on page */

if ($(".typeStart")[0]){
	$(document).bind('keydown',function(e){
		$('.typeStart').focus();
		$(document).unbind('keydown');
	});
}
/** END Focus input field with class "typeStart" when typing randomly on page */



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