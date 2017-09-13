<style>
            .table { display: table; width: 100%; border-collapse: collapse; }
            .table-row { display: table-row; }
            //.table-cell { display: table-cell; padding: 1em; }
            //.table-cell img {width:100px;}
            .empty-td { background-color: rgba(213, 213, 213, 0.7);}
            table { border-collapse: collapse; width: 100%;}
            table, th, td {border: 1px solid black;}
           .table-cell .text-heading{color:#EC4758; font-weight: 900;}
           .table-cell .category-heading{color:#0088C8; font-weight: 900;}
            .table-cell1 { display: table-cell; border: 1px solid black; padding: 1em; }
            .table-cell1 img {width:100px;}
            .text-heading-view { color:#5c5c5c;}
            .text-heading-view .set-color{ color:#FF8C00;margin-left: 2px;}
            .text-heading-view .set-color1{ color:#4169E1;margin-left: 2px;}
            .text-heading-view .set-color2{ color:#f44271;margin-left: 2px;}
        </style>
<div class="row">
  <div class="clearfix"></div>
              <hr>
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <?php echo $table; ?>
                </div>
            </div>
    <div class="clearfix"></div>
              <hr>
            <?php $icount=1; $j=1; foreach($salesRepData as $sales){?>
             <div class="col-lg-12">
                 <div class="col-lg-12" colspan="3">    
                     <div class="text-heading-view text-center"><?php echo $title; ?>  
                      (<span class="set-color">&#10004; Self</span>
                       <span class="set-color1">&#10004; Leader</span>
                       <span class="set-color2">&#10004; Manager</span>)
                     </div>
                     
                </div>
            </div>
             
            <div class="col-lg-12">
                <div class="col-lg-12 text-center">
                    <b>Name: </b> <span class="text-heading "><?php echo $sales['name']; ?></span>
                </div>  
            </div>
              <div class="clearfix"></div>
              <hr>
           <?php         $category = category180Report($sales['id'],$sales['user_assessment_id']);

                         $categoryRadar = category180Report($sales['id'],$sales['user_assessment_id'],$sales['role_id']);
                        ?>
                        <div class="col-lg-12">
                            <div class="col-lg-12" colspan="3">
                              
                            </div>
                        </div>
                             <div class="col-lg-12">
                                
                                <div class="col-lg-12" colspan="3">
                                    
                                     <canvas id="radarChart<?php echo $j;?>"></canvas>
                                     <script>
                                     var radarData = {
                                            labels: <?php echo json_encode($categoryRadar['label'])?>,
                                            datasets: [
                                                {
                                                    label: "Self",
                                                    fillColor: "rgba(220,220,220,0.2)",
                                                    strokeColor: "rgb(255,140,0)",
                                                    pointColor: "rgb(255,140,0)",
                                                    pointStrokeColor: "#fff",
                                                    pointHighlightFill: "#fff",
                                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                                    data: <?php echo json_encode($categoryRadar['self'])?>
                                                },
                                                {
                                                    label: "Leader",
                                                    fillColor: "rgba(220,220,220,0.2)",
                                                    strokeColor: "rgb(65,105,225)",
                                                    pointColor: "rgb(65,105,225)",
                                                    pointStrokeColor: "#fff",
                                                    pointHighlightFill: "#fff",
                                                    pointHighlightStroke: "rgba(151,187,205,1)",
                                                    data: <?php echo json_encode($categoryRadar['leader'])?>
                                                }, 
                                                {
                                                    label: "Manager",
                                                    fillColor: "rgba(220,220,220,0.2)",
                                                    strokeColor: "rgb(244, 66, 113)",
                                                    pointColor: "rgb(244, 66, 113)",
                                                    pointStrokeColor: "#fff",
                                                    pointHighlightFill: "#fff",
                                                    pointHighlightStroke: "rgba(151,187,205,1)",
                                                    data: <?php echo json_encode($categoryRadar['manager'])?>
                                                },
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

                                    var ctx = document.getElementById("radarChart<?php echo $j;?>").getContext("2d");
                                    var myNewChart = new Chart(ctx).Radar(radarData, radarOptions);
                                     </script>
                                </div>
                                
                            </div>

                            <div class="col-lg-12">
                             <div class="col-lg-12" colspan="3">
                    <table class="table  table-bordered table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Scoring Category</th>
                                <?php if($isView == 'self'){
                                        echo "<th>Self</th>";
                                    }else if($isView == 'self_leader'){
                                         echo "<th>Self</th><th>Leader</th>";
                                    }else if($isView == 'self_leader_manager'){
                                         echo "<th>Self</th><th>Leader</th><th>Manager</th>";
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($category['category'])) {
                                foreach ($category['category'] as $cat) {
                                    ?>
                                    <tr class="gradeX">
                                        <td class="center"><?php echo $cat->category_name ?></td>
                                       <?php if($isView == 'self'){ ?>
                                        <td class="center"><?php echo (isset($category['self'][$cat->cat_id]) && !empty($category['self'][$cat->cat_id])) ? $category['self'][$cat->cat_id]->avg_point : '0'; ?></td>
                                       <?php }else if($isView == 'self_leader'){?>
                                         <td class="center"><?php echo (isset($category['self'][$cat->cat_id]) && !empty($category['self'][$cat->cat_id])) ? $category['self'][$cat->cat_id]->avg_point : '0'; ?></td>
                                         <td class="center"><?php echo (isset($category['leader'][$cat->cat_id]) && !empty($category['leader'][$cat->cat_id])) ? $category['leader'][$cat->cat_id]->avg_point : '0'; ?></td>
                                       <?php }else if($isView == 'self_leader_manager'){?>
                                          <td class="center"><?php echo (isset($category['self'][$cat->cat_id]) && !empty($category['self'][$cat->cat_id])) ? $category['self'][$cat->cat_id]->avg_point : '0'; ?></td>
                                          <td class="center"><?php echo (isset($category['leader'][$cat->cat_id]) && !empty($category['leader'][$cat->cat_id])) ? $category['leader'][$cat->cat_id]->avg_point : '0'; ?></td>
                                          <td class="center"><?php echo (isset($category['manager'][$cat->cat_id]) && !empty($category['manager'][$cat->cat_id])) ? $category['manager'][$cat->cat_id]->avg_point : '0'; ?></td>
                                       <?php }?>   
                                    </tr>
                                <?php }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                             </div>
            
            <?php  $i=1;if (!empty($category['category'])) {
                        foreach ($category['category'] as $cat) {
                            $statement = statement180Report($sales['id'], $cat->cat_id, 1, $sales['user_assessment_id']);
                            $statementGraph = statement180Report($sales['id'], $cat->cat_id, 2, $sales['user_assessment_id']);
                            ?>
                            <div class="col-lg-12">
                                <div class="col-lg-12" colspan="3">
                                    <b>Category: </b> <span class="category-heading text-success"><?php echo $statement['category_name']; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-12" colspan="3">
                                     <canvas id="lineChart<?php echo $icount;?>"></canvas>
                                     <script>
                                            var lineData = {
                                                    labels: <?php echo json_encode($statementGraph['labels'])?>,
                                                    datasets: [
                                                        {
                                                            label: "Self",
                                                            fillColor: "rgba(220,220,220,0.2)",
                                                            strokeColor: "rgb(255,140,0)",
                                                            pointColor: "rgb(255,140,0)",
                                                            pointStrokeColor: "#fff",
                                                            pointHighlightFill: "#fff",
                                                            pointHighlightStroke: "rgba(220,220,220,1)",
                                                            data: <?php echo json_encode($statementGraph['self'])?>
                                                        },
                                                        {
                                                            label: "Leader",
                                                            fillColor: "rgba(220,220,220,0.2)",
                                                            strokeColor: "rgb(65,105,225)",
                                                            pointColor: "rgb(65,105,225)",
                                                            pointStrokeColor: "#fff",
                                                            pointHighlightFill: "#fff",
                                                            pointHighlightStroke: "rgba(151,187,205,1)",
                                                            data: <?php echo json_encode($statementGraph['leader'])?>
                                                        },
                                                        {
                                                            label: "Manager",
                                                            fillColor: "rgba(220,220,220,0.2)",
                                                            strokeColor: "rgb(244, 66, 113)",
                                                            pointColor: "rgb(244, 66, 113)",
                                                            pointStrokeColor: "#fff",
                                                            pointHighlightFill: "#fff",
                                                            pointHighlightStroke: "rgba(151,187,205,1)",
                                                            data: <?php echo json_encode($statementGraph['manager'])?>
                                                        },
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


                                       var ctx = document.getElementById("lineChart<?php echo $icount;?>").getContext("2d");
                                       var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
                                    
                                     </script>
                                </div>
                                
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-12" colspan="3">
                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th>Scoring Statement</th>
                                        <?php if($isView == 'self'){
                                                echo "<th>Self</th>";
                                              }else if($isView == 'self_leader'){
                                                 echo "<th>Self</th><th>Leader</th>";
                                              }else if($isView == 'self_leader_manager'){
                                                 echo "<th>Self</th><th>Leader</th><th>Manager</th>";
                                              }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($statement['statement'])) {
                                        foreach ($statement['statement'] as $key => $stmt) { ?>
                                            <tr class="gradeX">
                                                <td class="center"><?php echo $stmt; ?></td>
                                                
                                            
                                               <?php if($isView == 'self'){ ?>
                                                 <td class="center"><?php echo (isset($statement['self'][$key]) && !empty($statement['self'][$key])) ? $statement['self'][$key] : '0'; ?></td>
                                               <?php }else if($isView == 'self_leader'){?>
                                                 <td class="center"><?php echo (isset($statement['self'][$key]) && !empty($statement['self'][$key])) ? $statement['self'][$key] : '0'; ?></td>
                                                 <td class="center"><?php echo (isset($statement['leader'][$key]) && !empty($statement['leader'][$key])) ? $statement['leader'][$key] : '0'; ?></td>
                                               <?php }else if($isView == 'self_leader_manager'){?>
                                                  <td class="center"><?php echo (isset($statement['self'][$key]) && !empty($statement['self'][$key])) ? $statement['self'][$key] : '0'; ?></td>
                                                  <td class="center"><?php echo (isset($statement['leader'][$key]) && !empty($statement['leader'][$key])) ? $statement['leader'][$key] : '0'; ?></td>
                                                  <td class="center"><?php echo (isset($statement['manager'][$key]) && !empty($statement['manager'][$key])) ? $statement['manager'][$key] : '0'; ?></td>
                                               <?php }?>  
                                            
                                            
                                            </tr>
                                <?php }
                            } ?>
                                </tbody>
                            </table>
                            </div>
                            </div>
                        <?php $i++;$icount++;}
                    }
            ?>
            <?php $j++;}?>
</div>