$( document ).ready(function() {
    
    var ctx1 = document.getElementById("chart1").getContext("2d");
    var data1 = {
        labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
        datasets: [
            {
                label: "My Second dataset",
                fillColor: "rgba(243,245,246,0.9)",
                strokeColor: "#81F7F3",
                pointColor: "#81F7F3",
                pointStrokeColor: "#81F7F3",
                pointHighlightFill: "#81F7F3",
                pointHighlightStroke: "rgba(243,245,246,0.9)",
                data: [70, 70, 70, 70, 70, 70, 70,70, 70, 70, 70, 70, 70, 70,70, 70, 70, 70, 70, 70, 70,70, 70, 70, 70, 70, 70, 70,70,70]
            },
            {
                label: "My First dataset",
                fillColor: "#A9E2F3",
                strokeColor: "rgba(44,171,227,0.8)",
                pointColor: "rgba(44,171,227,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(44,171,227,1)",
                data: [30, 40, 50, 30, 40, 60, 50,60, 30, 40, 60, 50, 20, 30,30, 60, 40, 60, 30, 40, 60,50, 40, 50, 60, 60, 60, 60,50,60]
            }
            
        ]
    };
    
    var chart1 = new Chart(ctx1).Line(data1, {
        scaleShowGridLines : true,
        scaleGridLineColor : "rgba(0,0,0,.005)",
        scaleGridLineWidth : 0,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        bezierCurve : true,
        bezierCurveTension : 0.4,
        pointDot : true,
        pointDotRadius : 4,
        pointDotStrokeWidth : 1,
        pointHitDetectionRadius : 2,
        datasetStroke : true,
        tooltipCornerRadius: 2,
        datasetStrokeWidth : 2,
        datasetFill : true,
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        responsive: true
    });
    
    
});