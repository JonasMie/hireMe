var options =

{
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero: true,

    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: true,

    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",

    //Number - Width of the grid lines
    scaleGridLineWidth: 1,

    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,

    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,

    //Boolean - If there is a stroke on each bar
    barShowStroke: false,

    //Number - Spacing between each of the X value sets
    barValueSpacing: 5,

    //Number - Spacing between data sets within X values
    barDatasetSpacing: 1,

    // Boolean - whether or not the chart should be responsive and resize when the browser does.
    responsive: true,

    // Boolean - Determines whether to draw tooltips on the canvas or not
    showTooltips: true,

    //Number - Amount of animation steps
    animationSteps: 20,

};

$(document).ready(function () {

    $.get("/analytics/json", function (response, status) {

        var obj = jQuery.parseJSON(response);

        // Check nulls

        var viewClickNull = false;
        if(obj.viewCount == 0) {viewClickNull = true;}

        var clickApplyIsNull = false;
        if(obj.clickCount == 0 && obj.applierCount == 0) {clickApplyIsNull = true;}

        var interviewApplyIsNull = false;
        if(obj.applierCount == 0 &&  obj.interviewCount == 0) {interviewApplyIsNull = true;}

        var applyHiredIsNull = false;
        if(obj.applierCount == 0 &&  obj.hiredCount == 0) {applyHiredIsNull = true;}


        var viewClickData = {
            labels: ["Views", "Clicks"],
            datasets: [
                {
                    fillColor: "rgba(93,202,136,0.5)",
                    strokeColor: "rgba(93,202,136,0.5)",
                    highlightFill: "rgba(93,202,136,1.0)",
                    highlightStroke: "rgba(93,202,136,1.0)",
                    data: [obj.viewCount, obj.clickCount]
                }
            ]
        }

        var interestRateData = [

            {
                value: [obj.interestRate],
                color: "rgba(93,202,136,0.5)",
                highlight: "rgba(93,202,136,1.0)",
                label: "Clicks in Prozent"
            },
            {
                value: 100 - [obj.interestRate],
                color: "rgba(157,157,157,0.5)",
                highlight: "rgba(157,157,157,1.0)",
                label: "Views in Prozent"
            }
        ]


        var clickApplicationData = {
            labels: ["Clicks", "Bewerbungen"],
            datasets: [
                {
                    fillColor: "rgba(93,202,136,0.5)",
                    strokeColor: "rgba(93,202,136,0.5)",
                    highlightFill: "rgba(93,202,136,1.0)",
                    highlightStroke: "rgba(93,202,136,1.0)",
                    data: [obj.clickCount, obj.applierCount]
                }
            ]
        }

        var applicationRateData = [

            {
                value: [obj.applicationRate],
                color: "rgba(93,202,136,0.5)",
                highlight: "rgba(93,202,136,1.0)",
                label: "Bewerbungen in Prozent"
            },
            {
                value: 100 - [obj.applicationRate],
                color: "rgba(157,157,157,0.5)",
                highlight: "rgba(157,157,157,1.0)",
                label: "Clicks in Prozent"
            }
        ]

        var interviewApplicationData = {
            labels: ["Bewerbungen", "Interviews"],
            datasets: [
                {
                    fillColor: "rgba(93,202,136,0.5)",
                    strokeColor: "rgba(93,202,136,0.5)",
                    highlightFill: "rgba(93,202,136,1.0)",
                    highlightStroke: "rgba(93,202,136,1.0)",
                    data: [obj.applierCount, obj.interviewCount]
                }
            ]
        }

        var interviewRateData = [

            {
                value: [obj.interviewRate],
                color: "rgba(93,202,136,0.5)",
                highlight: "rgba(93,202,136,1.0)",
                label: "Interviews in Prozent"
            },
            {
                value: 100 - [obj.interviewRate],
                color: "rgba(157,157,157,0.5)",
                highlight: "rgba(157,157,157,1.0)",
                label: "Bewerbungen in Prozent"
            }
        ]

        var applicationHiredData = {
            labels: ["Bewerbungen", "Eingestellt"],
            datasets: [
                {
                    fillColor: "rgba(93,202,136,0.5)",
                    strokeColor: "rgba(93,202,136,0.5)",
                    highlightFill: "rgba(93,202,136,1.0)",
                    highlightStroke: "rgba(93,202,136,1.0)",
                    data: [obj.applierCount, obj.hiredCount]
                }
            ]
        }

        var conversionRateData = [

            {
                value: [obj.conversionRate],
                color: "rgba(93,202,136,0.5)",
                highlight: "rgba(93,202,136,1.0)",
                label: "Eingestellt in Prozent"
            },
            {
                value: 100 - [obj.conversionRate],
                color: "rgba(157,157,157,0.5)",
                highlight: "rgba(157,157,157,1.0)",
                label: "Bewerbungen in Prozent"
            }
        ]

        var lastValue;

        //function getRandomHipsterColor() {
        //
        //    var hue = 'rgba('
        //        + (Math.floor(Math.random() * 256)) + ','
        //        + (Math.floor(Math.random() * 256)) + ','
        //        + (Math.floor(Math.random() * 256)) + ','
        //        + (Math.floor(Math.random() * 100) / 100 + 0.2) + ')';
        //    // console.log(hue);
        //    return hue;
        //}

        var compareViewsData = [];

        for (var i = 0; i < obj.viewArray.length; i++) {
            var tmp = obj.viewArray[i];

            var subObject = '{';
             var value = (tmp.views / obj.viewCount).toFixed(2) * 100;
            if(jQuery.isNumeric(value)) {
            subObject += '"value":' + value + ',';
            }
            else {subObject += '"value":0,';}
            if (i % 2 == 0) {
                subObject += '"color": "rgba(93,202,136,0.5)",';
                subObject += '"highlight": "rgba(93,202,136,1.0)",';
            } else {
                subObject += '"color": "rgba(157,157,157,0.5)",';
                subObject += '"highlight": "rgba(157,157,157,1.0)",';
            }
            subObject += '"label": "' + tmp.title + '"';
            subObject += '}';
            // console.log(subObject);
            console.log(subObject);
            compareViewsData.push($.parseJSON(subObject));
        }

        var compareClicksData = [];

        for (var i = 0; i < obj.clickArray.length; i++) {

            var tmp = obj.clickArray[i];
            var subObject = '{';
            var value = (tmp.clicks / obj.clickCount).toFixed(2) * 100;
            if(jQuery.isNumeric(value)) {
            subObject += '"value":' + value + ',';
            }
            else {subObject += '"value":0,';}
            if (i % 2 == 0) {
                subObject += '"color": "rgba(93,202,136,0.5)",';
                subObject += '"highlight": "rgba(93,202,136,1.0)",';
            } else {
                subObject += '"color": "rgba(157,157,157,0.5)",';
                subObject += '"highlight": "rgba(157,157,157,1.0)",';
            }
            subObject += '"label": "' + tmp.title + '"';
            subObject += '}';
             console.log(subObject);
            compareClicksData.push($.parseJSON(subObject));
        }


        // VIEWS CLICKS + INTEREST RATE
        if(!viewClickNull) {
        var ctx1 = document.getElementById("viewClickChart").getContext("2d");
        ctx1.canvas.width = 200;
        ctx1.canvas.height = 100;

        var ctx2 = document.getElementById("interestRateChart").getContext("2d");
        var viewClicks = new Chart(ctx1).Bar(viewClickData, options);
        var interestRate = new Chart(ctx2).Doughnut(interestRateData, options);
        $("#viewClickIsNull").addClass("hidden");
        }   

        // CLICKS APPLICAIONS + APPLICATION RATE
        if(!clickApplyIsNull) {
        var ctx3 = document.getElementById("clicksApplicationChart").getContext("2d");
        ctx3.canvas.width = 200;
        ctx3.canvas.height = 100;

        var ctx4 = document.getElementById("applicationRateChart").getContext("2d");
        var clicksApplication = new Chart(ctx3).Bar(clickApplicationData, options);
        var applicationRate = new Chart(ctx4).Doughnut(applicationRateData, options);
        $("#clickApplyIsNull").addClass("hidden");
        }

        if(!interviewApplyIsNull) {
        // APPLICATIONS INTERVIEWS + INTERVIEW RATE
        var ctx5 = document.getElementById("interviewApplicationChart").getContext("2d");
        ctx5.canvas.width = 200;
        ctx5.canvas.height = 100;

        var ctx6 = document.getElementById("interviewRateChart").getContext("2d");
        var interviewApplication = new Chart(ctx5).Bar(interviewApplicationData, options);
        var interviewRate = new Chart(ctx6).Doughnut(interviewRateData, options);
        $("#interviewApplyIsNull").addClass("hidden");
        }

        if(!applyHiredIsNull) {
        // APPLICATIONS HIRED + CONVERSION RATE
        var ctx7 = document.getElementById("applicationHiredChart").getContext("2d");
        ctx7.canvas.width = 200;
        ctx7.canvas.height = 100;
        var ctx8 = document.getElementById("conversionRateChart").getContext("2d");
        var interviewApplication = new Chart(ctx7).Bar(applicationHiredData, options);
        var interviewRate = new Chart(ctx8).Doughnut(conversionRateData, options);
        $("#applyHiredIsNull").addClass("hidden");
        }

        if(obj.viewCount != 0) {
        var ctx9 = document.getElementById("viewCompareChart").getContext("2d");
        var viewCompare = new Chart(ctx9).Doughnut(compareViewsData, options);
        $("#viewComparisonIsNull").addClass("hidden");
        }
        if(obj.clickCount != 0) {
        var ctx10 = document.getElementById("clickCompareChart").getContext("2d");
        var clickCompare = new Chart(ctx10).Doughnut(compareClicksData, options);
        $("#clickComparisonIsNull").addClass("hidden");
        }

    });

});

