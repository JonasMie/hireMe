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
    barShowStroke : false,

    //Number - Spacing between each of the X value sets
    barValueSpacing : 5,

    //Number - Spacing between data sets within X values
    barDatasetSpacing : 1,

    // Boolean - whether or not the chart should be responsive and resize when the browser does.
    responsive: false,

    // Boolean - Determines whether to draw tooltips on the canvas or not
    showTooltips: true,
};

$(document).ready(function() {

     $.get("/analytics/json", function(response, status){

        var obj = jQuery.parseJSON(response);

        var viewClickData = {
            labels: ["Views","Clicks"],
            datasets: [
                {
                    fillColor: "rgba(93,202,136,0.5)",
                    strokeColor: "rgba(93,202,136,0.5)",
                    highlightFill: "rgba(93,202,136,1.0)",
                    highlightStroke: "rgba(93,202,136,1.0)",
                    data: [obj.viewCount,obj.clickCount]
                }
            ]
        }

         var interestRateData = [

             {
                 value: [obj.interestRate],
                 color:"rgba(93,202,136,0.5)",
                 highlight: "rgba(93,202,136,1.0)",
                 label: ""
             },
             {
                 value: 100 - [obj.interestRate],
                 color: "rgba(157,157,157,0.5)",
                 highlight: "rgba(157,157,157,1.0)",
                 label: ""
                 }
         ]

        var clickApplicationData = {
            labels: ["Clicks","Bewerbungen"],
            datasets: [
                {
                    fillColor: "rgba(93,202,136,0.5)",
                    strokeColor: "rgba(93,202,136,0.5)",
                    highlightFill: "rgba(93,202,136,1.0)",
                    highlightStroke: "rgba(93,202,136,1.0)",
                    data: [obj.clickCount,obj.applierCount]
                }
            ]
        }

        var applicationRateData = [

            {
                value: [obj.applicationRate],
                color:"rgba(93,202,136,0.5)",
                highlight: "rgba(93,202,136,1.0)",
                label: ""
            },
            {
                value: 100 - [obj.applicationRate],
                color: "rgba(157,157,157,0.5)",
                highlight: "rgba(157,157,157,1.0)",
                label: ""
            }
        ]

        var interviewApplicationData = {
            labels: ["Bewerbungen","Vorstellungsgespräche"],
            datasets: [
                {
                    fillColor: "rgba(93,202,136,0.5)",
                    strokeColor: "rgba(93,202,136,0.5)",
                    highlightFill: "rgba(93,202,136,1.0)",
                    highlightStroke: "rgba(93,202,136,1.0)",
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
                    fillColor: "rgba(93,202,136,0.5)",
                    strokeColor: "rgba(93,202,136,0.5)",
                    highlightFill: "rgba(93,202,136,1.0)",
                    highlightStroke: "rgba(93,202,136,1.0)",
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
        var interestRate = new Chart(ctx2).Pie(interestRateData, options);

        // CLICKS APPLICAIONS + APPLICATION RATE
        var ctx3 = document.getElementById("clicksApplicationChart").getContext("2d");
        var ctx4 = document.getElementById("applicationRateChart").getContext("2d");
        var clicksApplication = new Chart(ctx3).Bar(clickApplicationData, options);
        var applicationRate = new Chart(ctx4).Pie(applicationRateData, options);

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

});

