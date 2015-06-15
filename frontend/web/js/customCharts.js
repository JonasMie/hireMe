/**
 * Created by mkaraula on 15.06.15.
 */



/** Demo Chart **/
var data = [
    {
        value: 965,
        color: "rgba(93,202,136,0.5)",
        label: "Bewerbungen insgesamt"
    },
    {
        value: 96,
        color: "rgb(221,221,221)",
        label: "Stellenanzeigen"
    },
    {
        value: 84,
        color: "rgb(221,221,221)",
        label: "Übernahmen"
    },
    {
        value: 10,
        color: "rgb(221,221,221)",
        label: "Klicks"
    },
    {
        value: 20,
        color: "rgb(221,221,221)",
        label: "Views"
    },
    {
        value: 30,
        color: "rgb(221,221,221)",
        label: "Bewerbungen"
    },
    {
        value: 40,
        color: "rgb(221,221,221)",
        label: "Klicks"
    },
    {
        value: 84,
        color: "rgb(221,221,221)",
        label: "Übernahmen"
    }




];


var ctx = document.getElementById("DashboardChart").getContext("2d");
var myNewChart = new Chart(ctx).Doughnut(data);
/** END Demo**/