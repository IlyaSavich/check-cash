$(function () {
    var areaChartCanvas = $("#income-graph").get(0).getContext("2d");
    var areaChart = new Chart(areaChartCanvas);
    var arrayData = JSON.parse($("#income-graph-data").html());
    var areaChartData = {
        labels: arrayData["keys"]["income"],
        datasets: [
            {
                label: "Доход",
                fillColor: "rgba(255,255,255,0.9)",
                strokeColor: "rgba(255, 255, 255, 0.8)",
                pointColor: "#ffffff",
                pointStrokeColor: "rgba(255,255,255,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(255,255,255,1)",
                data: arrayData["values"]["income"]
            }
        ]
    };

    var areaChartOptions = {
        //Boolean - If we should show the scale at all
        showScale: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(255, 255, 255, 1)",
        //Number - Width of the grid lines
        scaleGridLineWidth: .4,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: false,
        //Boolean - Whether the line is curved between points
        bezierCurve: true,
        //Number - Tension of the bezier curve between points
        bezierCurveTension: 0.2,
        //Boolean - Whether to show a dot for each point
        pointDot: true,
        //Number - Radius of each point dot in pixels
        pointDotRadius: 5,
        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth: 0,
        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius: 20,
        //Boolean - Whether to show a stroke for datasets
        datasetStroke: false,
        //Number - Pixel width of dataset stroke
        datasetStrokeWidth: 2,
        //Boolean - Whether to fill the dataset with a color
        datasetFill: false,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        scaleLineColor: "rgba(255, 255, 255, 0)",
        scaleFontColor: "#fff"
    };
    areaChart.Line(areaChartData, areaChartOptions);

    areaChartCanvas = $("#incexp-graph").get(0).getContext("2d");
    areaChartOptions.datasetFill = false;
    areaChartOptions.scaleGridLineColor = "rgba(0,0,0,.1)";
    areaChartOptions.scaleLineColor = "rgba(0, 0, 0, 0.1)";
    areaChartOptions.scaleFontColor = "#000";
    areaChartOptions.pointDot = false;
    areaChart = new Chart(areaChartCanvas);
    areaChartData = {
        labels: arrayData["keys"]["expense"],
        datasets: [
            {
                label: "Расход",
                fillColor: "rgba(210, 214, 222, 1)",
                strokeColor: "rgba(210, 214, 222, 1)",
                pointColor: "rgba(210, 214, 222, 1)",
                pointStrokeColor: "#c1c7d1",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: arrayData["values"]["expense"]
            },
            {
                label: "Приход",
                fillColor: "rgba(60,141,188,0.9)",
                strokeColor: "rgba(60,141,188,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "rgba(60,141,188,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(60,141,188,1)",
                data: arrayData["values"]["receipt"]
            }
        ]
    };
    areaChart.Line(areaChartData, areaChartOptions);
});