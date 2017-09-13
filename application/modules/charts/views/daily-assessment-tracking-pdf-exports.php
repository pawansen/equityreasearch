<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
             table, th, td {border: 1px solid black;}
            .table-cell1 {
                border: 1px solid;
                font-size: 15px;
                font-weight: 900;
                padding: 12px;
            }
            .search-table-outter {overflow-x:scroll;}
            .search-table, td, th{border-collapse:collapse; border:1px solid #777;}
            .search-table-th{color:#444; background:#66C2E0;}
            .search-table-td{font-weight: 900}
            .search-table-td-first{font-weight: 900}
/*            .table { display: table; width: 100%; border-collapse: collapse; }
            .table-row { display: table-row; }
            .table-cell { display: table-cell; padding: 1em; }
            .table-cell img {width:100px;}
            .empty-td { background-color: rgba(213, 213, 213, 0.7);}
             //table, th, td {border: 1px solid black;}
            table { border-collapse: collapse; width: 100%;}
            table, th, td {border: 1px solid black;}
            .table-cell .text-heading{color:#EC4758; font-weight: 900;}
            .table-cell .category-heading{color:#0088C8; font-weight: 900;}
            .table-cell1 { display: table-cell; border: 1px solid black; padding: 1em; }
            .table-cell1 img {width:100px;}
            .text-heading-view { color:#5c5c5c;}
            .text-heading-view .set-color{ color:#FF8C00;margin-left: 2px;}
            .text-heading-view .set-color1{ color:#4169E1;margin-left: 2px;}
            .text-heading-view .set-color2{ color:#f44271;margin-left: 2px;}*/
        </style>
    </head>
    <body>
        <div class="tables">
            <div class="table-row">
                <div class="table-cell1"><img src='<?php echo $logo; ?>' /></div>
                <div class="table-cell1"><b>Company: </b> <?php echo $organization; ?></div>
                <div class="table-cell1"> <b>Assessment Type:</b>Daily Assessment Reports
                    <div></div>
                </div>
            </div>
            <div class="table-row">
                <div class="table-cell" colspan="3">
                    <div class="search-table-outter wrapper">
                        <table class="table-bordered search-table inner" id="dataTables-dashboard-daily-trackings">
                            <thead>
                                <tr>
                                    <th>Users</th>
                                    <?php
                                    if (!empty($allDates)) {
                                        foreach ($allDates as $dates) {
                                            ?>
                                            <th class="search-table-th"><?php echo date('d M', strtotime($dates)); ?></th>   
                                        <?php }
                                    }
                                    ?>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                if (!empty($allUsers)) {
                                    foreach ($allUsers as $users) {
                                        if (isset($users['name']) && !empty($users['name'])) {
                                            $leader = (isset($users['leader']) && !empty($users['leader'])) ? $users['leader'] : "";
                                            $manager = (isset($users['manager']) && !empty($users['manager'])) ? $users['manager'] : "";
                                            $bullets_in_month_date = $users['bullets_in_month_date'];
                                            ?>
                                            <tr class="text-success">
                                                <td class="search-table-td-first"><?php echo $users['name']; ?></td>
                                                <?php
                                                if (!empty($allDates)) {
                                                    foreach ($allDates as $dates) {
                                                        ?>
                                                        <td class="search-table-td"><?php
                                                            if (in_array(date('m/d/Y', strtotime($dates)), $bullets_in_month_date)) {
                                                                echo dailyTrackingCheckAssessmentBulletIn($users['id'], $users['assessment_id'], $dates);
                                                            } else {
                                                                echo dailyTrackingCheckAssessmentBulletOut($users['id'], $users['assessment_id'], $dates);
                                                            }
                                                            ?></td>
                                                <?php }
                                            }
                                            ?> 
                                            </tr>

                                                <?php if (!empty($leader)) {
                                                    $leader_bullets = $leader->bullets_in_month_date;
                                                    ?>
                                                <tr style="color: #f4418b;"> <td class="search-table-td-first"><?php echo $leader->name . " - " . $users['name']; ?></td>
                                                        <?php
                                                        if (!empty($allDates)) {
                                                            foreach ($allDates as $dates) {
                                                                ?>
                                                            <td class="search-table-td"><?php
                                                                if (!empty($leader_bullets)) {
                                                                    $leader_bullet = explode(",", $leader_bullets);
                                                                    //dump($leader_bullets);
                                                                    if (in_array(date('m/d/Y', strtotime($dates)), $leader_bullet)) {
                                                                        echo dailyTrackingCheckAssessmentBulletIn($leader->id, $leader->assessment_id, $dates);
                                                                    } else {
                                                                        echo dailyTrackingCheckAssessmentBulletOut($leader->id, $leader->assessment_id, $dates);
                                                                    }
                                                                } else {
                                                                    echo dailyTrackingCheckAssessmentBulletOut($leader->id, $leader->assessment_id, $dates);
                                                                }
                                                                ?></td>
                                                        <?php }
                                                    }
                                                    ?> 
                                                </tr>
                                                    <?php } $leader = "";
                                                    $leader_bullets = ""; ?> 

                                                    <?php if (!empty($manager)) {
                                                        $manager_bullets = $manager->bullets_in_month_date;
                                                        ?>
                                                <tr style="color: #009900;"> <td class="search-table-td-first"><?php echo $manager->name . " - " . $users['name']; ?></td>
                                                    <?php
                                                    if (!empty($allDates)) {
                                                        foreach ($allDates as $dates) {
                                                            ?>
                                                            <td class="search-table-td"><?php
                                                        if (!empty($manager_bullets)) {
                                                            $manager_bullet = explode(",", $manager_bullets);
                                                            if (in_array(date('m/d/Y', strtotime($dates)), $manager_bullet)) {
                                                                echo dailyTrackingCheckAssessmentBulletIn($manager->id, $manager->assessment_id, $dates);
                                                            } else {
                                                                echo dailyTrackingCheckAssessmentBulletOut($manager->id, $manager->assessment_id, $dates);
                                                            }
                                                        } else {
                                                            echo dailyTrackingCheckAssessmentBulletOut($manager->id, $manager->assessment_id, $dates);
                                                        }
                                                        ?></td>
                                                        <?php }
                                                    }
                                                    ?> 
                                                                                    </tr>
                                                <?php }$manager = "";
                                                $manager_bullets = ""; ?> 

                                            <?php
                                            }
                                        }
                                    }
                                    ?>    


                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>