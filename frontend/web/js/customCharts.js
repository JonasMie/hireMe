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
}

$(document).ready(function() {

     $.get("/analytics/json", function(response, status){

        var obj = jQuery.parseJSON(response);

        var viewClickData = {
            labels: ["Views","Clicks"],
            datasets: [
                {
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [obj.viewCount,obj.clickCount]
                }
            ]
        }

         var interestRateData = {
            labels: ["Interest Rate"],
            datasets: [
                {
                    label: "InterestRate:",
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [obj.interestRate]
                }
            ]
        }

        var clickApplicationData = {
            labels: ["Clicks","Bewerbungen"],
            datasets: [
                {
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [obj.clickCount,obj.applierCount]
                }
            ]
        }

        var applicationRateData = {
            labels: ["Application Rate"],
            datasets: [
                {
                    label: "Application Rate:",
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [obj.applicationRate]
                }
            ]
        }

        var interviewApplicationData = {
            labels: ["Bewerbungen","Vorstellungsgespräche"],
            datasets: [
                {
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [obj.applierCount,obj.interviewCount]
                }
            ]
        }

         var interviewRateData = {
            labels: ["Interview Rate"],
            datasets: [
                {
                    label: "Interview Rate:",
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [obj.interviewRate]
                }
            ]
        }

        var applicationHiredData = {
            labels: ["Bewerbungen","Eingestellt"],
            datasets: [
                {
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [obj.applierCount,obj.hiredCount]
                }
            ]
        }

         var conversionRateData = {
            labels: ["Conversion Rate"],
            datasets: [
                {
                    label: "Conversion Rate:",
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [obj.conversionRate]
                }
            ]
        }

        // VIEWS CLICKS + INTEREST RATE
        var ctx1 = document.getElementById("viewClickChart").getContext("2d");
        var ctx2 = document.getElementById("interestRateChart").getContext("2d");
        var viewClicks = new Chart(ctx1).Bar(viewClickData, options);
        var interestRate = new Chart(ctx2).Bar(interestRateData, options);

        // CLICKS APPLICAIONS + APPLICATION RATE
        var ctx3 = document.getElementById("clicksApplicationChart").getContext("2d");
        var ctx4 = document.getElementById("applicationRateChart").getContext("2d");
        var clicksApplication = new Chart(ctx3).Bar(clickApplicationData, options);
        var applicationRate = new Chart(ctx4).Bar(applicationRateData, options);

        // APPLICATIONS INTERVIEWS + INTERVIEW RATE
        var ctx5 = document.getElementById("interviewApplicationChart").getContext("2d");
        var ctx6 = document.getElementById("interviewRateChart").getContext("2d");
        var interviewApplication = new Chart(ctx5).Bar(interviewApplicationData, options);
        var interviewRate = new Chart(ctx6).Bar(interviewRateData, options);

        // APPLICATIONS HIRED + CONVERSION RATE
        var ctx5 = document.getElementById("applicationHiredChart").getContext("2d");
        var ctx6 = document.getElementById("conversionRateChart").getContext("2d");
        var interviewApplication = new Chart(ctx5).Bar(applicationHiredData, options);
        var interviewRate = new Chart(ctx6).Bar(conversionRateData, options);


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


