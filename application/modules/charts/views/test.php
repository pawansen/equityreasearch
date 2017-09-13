<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script src="<?php echo base_url(); ?>backend_asset/js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url(); ?>backend_asset/js/plugins/chartJs/Chart.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js" ></script>
        <style>
            .table { display: table; width: 100%; border-collapse: collapse; }
            .table-row { display: table-row; }
            .table-cell { display: table-cell; border: 1px solid black; padding: 1em; }
            .table-cell img {width:100px;}
            .empty-td { background-color: rgba(213, 213, 213, 0.7);}
            table {
                border-collapse: collapse;
            }

            table, th, td {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <div class="table">
            <div class="table-row">
                <div class="table-cell">dfsdf</div>
                <div class="table-cell"><b>Company: </b> sdfsdf</div>
            </div>
            <div class="table-row">
                <div class="table-cell" colspan="2"> <b>Assessment Type:</b>180 Assessment</div>
            </div>
            <div class="table-row">
                <div class="table-cell" colspan="2">
                    <div id='graph-container'>
                        <canvas id="radarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <canvas id="cool-canvas" width="600" height="300"></canvas>
        </div>

        <div style="height:0; width:0; overflow:hidden;">
            <canvas id="supercool-canvas" width="1200" height="600"></canvas>
        </div>

        <button type="button" id="download-pdf" >
            Download PDF
        </button>

        <button type="button" id="download-pdf2" >
            Download Higher Quality PDF
        </button>
        <img src="" id='imagesshow' />
        <a href ="" download = "customName.png" id = "download">Click here to download image</a>
<canvas></canvas>
        <script>
            $(function () {


                document.getElementById('download-pdf').addEventListener("click", downloadPDF);
                function downloadPDF() {
                    var canvas = document.querySelector('#radarChart');
                    //creates image
                    var canvasImg = canvas.toDataURL("image/png", 1.0);
                    
                    var imagesshow = document.querySelector('#imagesshow');
                    var download = document.querySelector('#download');
                    download.href=canvasImg;
                    //creates PDF from img
                    var doc = new jsPDF('landscape');
                    doc.setFontSize(20);
                    doc.text(15, 15, "Cool Chart");
                    doc.addImage(canvasImg, 'JPEG', 10, 10, 280, 150);
                    doc.save('canvas.pdf');
                }

                var radarData = {
                    labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
                    datasets: [
                        {
                            label: "My First dataset",
                            fillColor: "rgba(220,220,220,0.2)",
                            strokeColor: "rgba(220,220,220,1)",
                            pointColor: "rgba(220,220,220,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: [65, 59, 90, 81, 56, 55, 40]
                        },
                        {
                            label: "My Second dataset",
                            fillColor: "rgba(26,179,148,0.2)",
                            strokeColor: "rgba(26,179,148,1)",
                            pointColor: "rgba(26,179,148,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(151,187,205,1)",
                            data: [28, 48, 40, 19, 96, 27, 100]
                        }
                    ]
                };

                var radarOptions = {
                    scaleShowLine: true,
                    angleShowLineOut: true,
                    scaleShowLabels: false,
                    scaleBeginAtZero: true,
                    angleLineColor: "rgba(0,0,0,.1)",
                    angleLineWidth: 1,
                    pointLabelFontFamily: "'Arial'",
                    pointLabelFontStyle: "normal",
                    pointLabelFontSize: 10,
                    pointLabelFontColor: "#666",
                    pointDot: true,
                    pointDotRadius: 3,
                    pointDotStrokeWidth: 1,
                    pointHitDetectionRadius: 20,
                    datasetStroke: true,
                    datasetStrokeWidth: 2,
                    datasetFill: true,
                    responsive: true,
                    bezierCurve: true,
                }

                var ctx = document.getElementById("radarChart").getContext("2d");
                var myNewChart = new Chart(ctx).Radar(radarData, radarOptions);
            });

        </script>
    </body>
</html>