var options = 

{
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero : true,

    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines : true,

    //String - Colour of the grid lines
    scaleGridLineColor : "rgba(0,0,0,.05)",

    //Number - Width of the grid lines
    scaleGridLineWidth : 1,

    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,

    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,

    //Boolean - If there is a stroke on each bar
    barShowStroke : true,

    //Number - Pixel width of the bar stroke
    barStrokeWidth : 2,

    //Number - Spacing between each of the X value sets
    barValueSpacing : 5,

    //Number - Spacing between data sets within X values
    barDatasetSpacing : 1,

    legendTemplate : '<ul>'
                  +'<% for (var i=0; i<datasets.length; i++) { %>'
                    +'<li>'
                    +'<span style=\"background-color:<%=datasets[i].lineColor%>\"></span>'
                    +'<% if (datasets[i].label) { %><%= datasets[i].label %><% } %>'
                  +'</li>'
                +'<% } %>'
              +'</ul>'

}



$(document).ready(function() {

     $.get("http://frontend/analytics/json", function(response, status){

        var obj = jQuery.parseJSON(response);
        alert(obj[0].viewCount);

        var data = {
            labels: ["Interest Rate"],
            datasets: [
                {
                    label: "Views:",
                    fillColor: "rgba(220,220,220,0.5)",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [obj[0].viewCount]
                },
                {
                    label: "Clicks:",
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [obj[0].clickCount]
                }
            ]
        }


        var ctx = document.getElementById("DashboardChart").getContext("2d");
        var myBarChart = new Chart(ctx).Bar(data, options);
        var legend = myBarChart.generateLegend();

        //and append it to your page somewhere
        $("#legend").append(legend);

    });

})




// /** Demo Chart **/
// var data = [
//     {
//         value: 965,
//         color: "rgba(93,202,136,0.5)",
//         label: "Bewerbungen insgesamt"
//     },
//     {
//         value: 96,
//         color: "rgb(221,221,221)",
//         label: "Stellenanzeigen"
//     },
//     {
//         value: 84,
//         color: "rgb(221,221,221)",
//         label: "Übernahmen"
//     },
//     {
//         value: 10,
//         color: "rgb(221,221,221)",
//         label: "Klicks"
//     },
//     {
//         value: 20,
//         color: "rgb(221,221,221)",
//         label: "Views"
//     },
//     {
//         value: 30,
//         color: "rgb(221,221,221)",
//         label: "Bewerbungen"
//     },
//     {
//         value: 40,
//         color: "rgb(221,221,221)",
//         label: "Klicks"
//     },
//     {
//         value: 84,
//         color: "rgb(221,221,221)",
//         label: "Übernahmen"
//     }
// ];


