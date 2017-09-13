<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>dataTables.buttons.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.flash.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.flash.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>jszip.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>pdfmake.min.js"></script>   
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>vfs_fonts.js"></script>  
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.html5.min.js"></script>  
<script src="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.print.min.js"></script>  
<link href="<?php echo base_url() . 'backend_asset/plugins/dataTables/datatablepdf/' ?>buttons.dataTables.min.css" rel="stylesheet">
<script>
    function generateReportDashboard(str) {

        $("#filterByUser").show("slow");
        var organization_id = document.querySelector('#organization_id');
        var assessment_type = document.querySelector('#assessment_type');
        var leader_user = document.querySelector('#leader_user');
        var sales_rep_user = document.querySelector('#sales_rep_user');
        var manager_user = document.querySelector('#manager_user');
        if (str != 'm' && str != 'l' && str != 's') {
            $("#leader_user").children().removeAttr("selected");
            $("#sales_rep_user").children().removeAttr("selected");
            getMangerUser(organization_id.value, assessment_type.value);
        }
        if (str != 'l' && str != 's') {
            $("#leader_user").children().removeAttr("selected");
            $("#sales_rep_user").children().removeAttr("selected");
            getLeaderUser(organization_id.value, manager_user.value, assessment_type.value);
        }
        if (str != 's') {
            $("#sales_rep_user").children().removeAttr("selected");
            getSalesRepUser(organization_id.value, leader_user.value, assessment_type.value);
        }
        if (str == 'all') {
            $("#leader_user").children().removeAttr("selected");
            $("#sales_rep_user").children().removeAttr("selected");
            $("#manager_user").children().removeAttr("selected");
        }

        $.ajax({
            url: '<?php echo base_url() . 'charts/generateReportDashboard' ?>',
            type: 'POST',
            data: {'organization_id': organization_id.value, 'manager_id': manager_user.value, 'leader_id': leader_user.value, 'self_id': sales_rep_user.value},
            beforeSend: function () {
                $(".loaders").fadeIn("slow");
            },
            success: function (data) {
                $("#dashboardReport").html(data);
                $('.dataTables-dashboard-180-tracking').dataTable({
                    "scrollX": true,
                    "ordering": false,
                    // dom: 'Bfrtip',
//                    buttons: [
//                        'excel', 'pdf'
//                    ],
                    "lengthChange": false,
                    "pageLength": 500
                });
                $(".loaders").fadeOut("slow");
                $("#dashboardReportTableAvg").html("");
                $("#dashboardReportStatementAverage").html("");
                $('#radarChart').remove();
                $('#graph-container').append('<canvas id="radarChart"></canvas>');
                $('#lineChart').remove();
                $('#graph-container-line').append('<canvas id="lineChart"></canvas>');
                $("#cateName").html("");
                $(".chartdiv").hide();
            }
        });
    }

    function getMangerUser(organization_id, assessment_type) {
        $.ajax({
            url: '<?php echo base_url() . 'charts/getMangerUser' ?>',
            type: 'POST',
            data: {'organization_id': organization_id, 'assessment_type': assessment_type},
            success: function (data) {
                $("#manager_user").html(data);
            }
        });
    }

    function getLeaderUser(organization_id, manager_id, assessment_type) {
        $.ajax({
            url: '<?php echo base_url() . 'charts/getLeaderUser' ?>',
            type: 'POST',
            data: {'organization_id': organization_id, 'manager_id': manager_id, 'assessment_type': assessment_type},
            success: function (data) {
                $("#leader_user").html(data);
            }
        });
    }

    function getSalesRepUser(organization_id, leader_id, assessment_type) {
        $.ajax({
            url: '<?php echo base_url() . 'charts/getSalesRepUser' ?>',
            type: 'POST',
            data: {'organization_id': organization_id, 'leader_id': leader_id, 'assessment_type': assessment_type},
            success: function (data) {
                $("#sales_rep_user").html(data);
            }
        });
    }

    function chartRadarCaregory(userId, roleId) {

        $.ajax({
            url: '<?php echo base_url() . 'charts/categoryAssessmentReport' ?>',
            type: 'POST',
            data: {'userId': userId, 'roleId': roleId},
            dataType: 'json',
            beforeSend: function () {
                $(".loaders").fadeIn("slow");
            },
            success: function (data) {
                if (data.status == 1) {
                    $(".chartdiv").show();
                    window.scrollTo(300, 400);
                    $(".loaders").fadeOut("slow");
                    var radarData = {
                        labels: data.label,
                        datasets: [
                            {
                                label: "Self",
                                fillColor: "rgba(220,220,220,0.2)",
                                strokeColor: "rgb(255,140,0)",
                                pointColor: "rgb(255,140,0)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: data.self
                            },
                            {
                                label: "Leader",
                                fillColor: "rgba(220,220,220,0.2)",
                                strokeColor: "rgb(65,105,225)",
                                pointColor: "rgb(65,105,225)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: data.leader
                            }
                        ]
                    };

                    var radarOptions = {
                        scaleShowLine: true,
                        angleShowLineOut: true,
                        scaleShowLabels: true,
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
                    }

                    var ctx = document.getElementById("radarChart").getContext("2d");
                    var myNewChart = new Chart(ctx).Radar(radarData, radarOptions);
                } else {
                    toastr.error('Record Not Found');
                    $(".loaders").fadeOut("slow");
                }

            }
        });
        setTimeout(function () {
            chartTable(userId);
        }, 1000);
    }

    function chartTable(user_id) {
        $.ajax({
            url: '<?php echo base_url() . 'charts/categoryAssessmentReport' ?>',
            type: 'POST',
            data: {'userId': user_id},
            success: function (data) {
                $("#dashboardReportTableAvg").html(data);
                $('#lineChart').remove();
                $('#graph-container-line').append('<canvas id="lineChart"></canvas>');
                $("#cateName").html("");
                $("#dashboardReportStatementAverage").html("");
            }
        });
    }

    function caregoryStatementChart(catId, userId) {

        $.ajax({
            url: '<?php echo base_url() . 'charts/caregoryStatementChart' ?>',
            type: 'POST',
            data: {'userId': userId, 'catId': catId, 'statement': 0},
            dataType: 'json',
            beforeSend: function () {
                $(".loaders").fadeIn("slow");
            },
            success: function (data) {
                if (data.status == 1) {
                    $(".loaders").fadeOut("slow");
                    $("#cateName").html(data.category_name);
                    $('#lineChart').remove();
                    $('#graph-container-line').append('<canvas id="lineChart"></canvas>');
                    var lineData = {
                        labels: data.labels,
                        datasets: [
                            {
                                label: "Self",
                                fillColor: "rgba(220,220,220,0.2)",
                                strokeColor: "rgb(255,140,0)",
                                pointColor: "rgb(255,140,0)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: data.self
                            },
                            {
                                label: "Leader",
                                fillColor: "rgba(220,220,220,0.2)",
                                strokeColor: "rgb(65,105,225)",
                                pointColor: "rgb(65,105,225)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: data.leader
                            }
                        ]
                    };

                    var lineOptions = {
                        scaleShowLine: true,
                        angleShowLineOut: true,
                        scaleShowLabels: true,
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
                    };


                    var ctx = document.getElementById("lineChart").getContext("2d");
                    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
                }
            }
        });
        setTimeout(function () {
            chartTableStatement(catId, userId);
        }, 1000);
    }

    function chartTableStatement(catId, userId) {
        $.ajax({
            url: '<?php echo base_url() . 'charts/caregoryStatementChart' ?>',
            type: 'POST',
            data: {'userId': userId, 'catId': catId, 'statement': 1},
            success: function (data) {
                $("#dashboardReportStatementAverage").html(data);
            }
        });
    }


    function dailyTrackingDashboard(str) {

        $("#filterByUser").show("slow");
        var organization_id = document.querySelector('#organization_id');
        var assessment_type = document.querySelector('#assessment_type');
        var leader_user = document.querySelector('#leader_user');
        var sales_rep_user = document.querySelector('#sales_rep_user');
        var manager_user = document.querySelector('#manager_user');
        var datesfrom = document.querySelector('#datesfrom');
        var datesto = document.querySelector('#datesto');
        var levels = document.querySelector('#levels');

        if (str != 'm' && str != 'l' && str != 's') {
            $("#leader_user").children().removeAttr("selected");
            $("#sales_rep_user").children().removeAttr("selected");
            getMangerUser(organization_id.value, assessment_type.value);
        }
        if (str != 'l' && str != 's') {
            $("#leader_user").children().removeAttr("selected");
            $("#sales_rep_user").children().removeAttr("selected");
            getLeaderUser(organization_id.value, manager_user.value, assessment_type.value);
        }
        if (str != 's') {
            $("#sales_rep_user").children().removeAttr("selected");
            getSalesRepUser(organization_id.value, leader_user.value, assessment_type.value);
        }
        if (str == 'all') {
            $("#leader_user").children().removeAttr("selected");
            $("#sales_rep_user").children().removeAttr("selected");
            $("#manager_user").children().removeAttr("selected");
        }

        $.ajax({
            url: '<?php echo base_url() . 'charts/dailyTrackingDashboard' ?>',
            type: 'POST',
            data: {'datesfrom': datesfrom.value, 'datesto': datesto.value, 'levels': levels.value, 'organization_id': organization_id.value, 'manager_id': manager_user.value, 'leader_id': leader_user.value, 'self_id': sales_rep_user.value},
            beforeSend: function () {
                $(".loaders").fadeIn("slow");
            },
            success: function (data) {
                
                if(data == '1'){
                    //toastr.error('From Date and To Date Can Not be Empty');
                    $("#errMessage").html('From Date and To Date Can Not be Empty');
                    $(".loaders").fadeOut("slow");
                    $("#dashboardReport").html("");
                }else if(data == '2'){
                    //toastr.error('The To date must be greater than the From date');
                    $("#errMessage").html('The To date must be greater than the From date');
                    $(".loaders").fadeOut("slow");
                    $("#dashboardReport").html("");
                }else{
                    $("#dashboardReport").html(data);
                    $('.dataTables-dashboard-180-tracking').dataTable({
                        "scrollX": true,
                        "ordering": false,
                        "lengthChange": false,
                        "pageLength": 500
                    });
                    $(".loaders").fadeOut("slow");
                    $("#dashboardReportTableAvg").html("");
                    $("#dashboardReportStatementAverage").html("");
                    $('#radarChart').remove();
                    $('#graph-container').append('<canvas id="radarChart"></canvas>');
                    $('#lineChart').remove();
                    $('#graph-container-line').append('<canvas id="lineChart"></canvas>');
                    $("#cateName").html("");
                    $("#errMessage").html("");
                    $('#dataTables-dashboard-daily-tracking').dataTable({
                         "paging": false,
                         "searching": false,
                         "columnDefs": [
                            { "orderable": false }
                         ],
                         "bLengthChange": false,
                         "scrollX": true,
                         "bInfo" : false
                    });
                     $("th").removeClass("sorting");
                     $("th").removeClass("sorting_asc");
              } 
            }
        });
    }
    
    function generateReportGraphView(str) {

        $("#filterByUser").show("slow");
        var organization_id = document.querySelector('#organization_id');
        var assessment_type = document.querySelector('#assessment_type');
        var leader_user = document.querySelector('#leader_user');
        var sales_rep_user = document.querySelector('#sales_rep_user');
        var manager_user = document.querySelector('#manager_user');
        var levels = document.querySelector('#levels');
        
        if (str != 'm' && str != 'l' && str != 's') {
            $("#leader_user").children().removeAttr("selected");
            $("#sales_rep_user").children().removeAttr("selected");
            getMangerUser(organization_id.value, assessment_type.value);
        }
        if (str != 'l' && str != 's') {
            $("#leader_user").children().removeAttr("selected");
            $("#sales_rep_user").children().removeAttr("selected");
            getLeaderUser(organization_id.value, manager_user.value, assessment_type.value);
        }
        if (str != 's') {
            $("#sales_rep_user").children().removeAttr("selected");
            getSalesRepUser(organization_id.value, leader_user.value, assessment_type.value);
        }
        if (str == 'all') {
            $("#leader_user").children().removeAttr("selected");
            $("#sales_rep_user").children().removeAttr("selected");
            $("#manager_user").children().removeAttr("selected");
        }

        $.ajax({
            url: '<?php echo base_url() . 'charts/exportsReport180AssessmentGraphView' ?>',
            type: 'POST',
            data: {'organization_id': organization_id.value, 'manager_user': manager_user.value, 'leader_user': leader_user.value, 'sales_rep_user': sales_rep_user.value, 'levels':levels.value},
            beforeSend: function () {
                $(".loaders").fadeIn("slow");
            },
            success: function (data) {
                $("#180-assessment-chart-view").html(data);
                $(".loaders").fadeOut("slow");
            }
        });
    }

    $('#datesfrom').datepicker({
        startView: 3,
        format: "mm/dd/yyyy",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
    });

    $('#datesto').datepicker({
        startView: 3,
        format: "mm/dd/yyyy",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
    });
    
   

</script>