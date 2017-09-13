<style>
    .search-table-outter {overflow-x:scroll;}
    .search-table{table-layout: fixed; margin:40px auto 0px auto;   }
    .search-table, td, th{border-collapse:collapse; border:1px solid #777;}
    .search-table-th{padding:20px 7px; font-size:15px; color:#444; background:#66C2E0;}
    .search-table-td{padding:5px 10px; height:35px; font-weight: 900}
    .search-table-td-first{min-width: 249px;padding:5px 10px; height:35px; font-weight: 900}
</style>
<?php if(!empty($allUsers)){?>
<div class="row">
    <div class="col-md-4">
        <a href="<?php echo site_url('charts/dailyTrackingExportInExcel/' . encoding($allUsers) . '/'. encoding($allDates)  .'/' . $organization_id) ?>" class="btn btn-<?php echo THEME_COLOR; ?>"> <i class="fa fa-file-excel-o"></i> Excel Export</a>
        <a href="<?php echo site_url('charts/dailyTrackingExportInPdf/' . encoding($allUsers) . '/'. encoding($allDates)  .'/'. $organization_id) ?>" class="btn btn-<?php echo THEME_COLOR; ?>"> <i class="fa fa-file-pdf-o"></i> PDF Export</a>
    </div>
    <div class="col-md-4">Period : <span class="text-danger text-justify text-heading"><?php echo date('d F Y', strtotime($fromDate)); ?>  /  <?php echo date('d F Y', strtotime($toDate)); ?></span></div>
</div>
<div class="search-table-outter wrapper">
    <table class="table-bordered search-table inner" id="dataTables-dashboard-daily-trackings">
        <thead>
            <tr>
                <th>Users</th>
                <?php if (!empty($allDates)) {
                    foreach ($allDates as $dates) {
                        ?>
                <th class="search-table-th"><?php echo date('d M', strtotime($dates)); ?></th>   
    <?php }
} ?>
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
                            <td class="search-table-td"><?php if(in_array(date('m/d/Y',strtotime($dates)), $bullets_in_month_date)){
                                echo dailyTrackingCheckAssessmentBulletIn($users['id'],$users['assessment_id'],$dates);
                            }else{
                                echo dailyTrackingCheckAssessmentBulletOut($users['id'],$users['assessment_id'],$dates);
                            }?></td>
                                <?php }
                            } ?> 
                        </tr>

                            <?php if (!empty($leader)) { 
                                $leader_bullets = $leader->bullets_in_month_date;?>
                            <tr style="color: #f4418b;"> <td class="search-table-td-first"><?php echo $leader->name . " - " . $users['name']; ?></td>
                            <?php
                            if (!empty($allDates)) {
                                foreach ($allDates as $dates) {
                                    ?>
                                        <td class="search-table-td"><?php if(!empty($leader_bullets)){
                                            $leader_bullet = explode(",", $leader_bullets);
                                            //dump($leader_bullets);
                                            if(in_array(date('m/d/Y',strtotime($dates)), $leader_bullet)){
                                                echo dailyTrackingCheckAssessmentBulletIn($leader->id,$leader->assessment_id,$dates);
                                            }else{
                                                echo dailyTrackingCheckAssessmentBulletOut($leader->id,$leader->assessment_id,$dates);
                                            }
                                        }else{echo dailyTrackingCheckAssessmentBulletOut($leader->id,$leader->assessment_id,$dates);}?></td>
                                    <?php }
                                } ?> 
                            </tr>
                            <?php } $leader = ""; $leader_bullets=""; ?> 

                        <?php if (!empty($manager)) {
                            $manager_bullets = $manager->bullets_in_month_date;?>
                            <tr style="color: #009900;"> <td class="search-table-td-first"><?php echo $manager->name . " - " . $users['name']; ?></td>
                            <?php
                            if (!empty($allDates)) {
                                foreach ($allDates as $dates) {
                                    ?>
                                        <td class="search-table-td"><?php if(!empty($manager_bullets)){
                                            $manager_bullet = explode(",", $manager_bullets);
                                            if(in_array(date('m/d/Y',strtotime($dates)), $manager_bullet)){
                                                echo dailyTrackingCheckAssessmentBulletIn($manager->id,$manager->assessment_id,$dates);
                                            }else{
                                                 echo dailyTrackingCheckAssessmentBulletOut($manager->id,$manager->assessment_id,$dates);
                                            }
                                        }else{echo dailyTrackingCheckAssessmentBulletOut($manager->id,$manager->assessment_id,$dates);}?></td>
                    <?php }
                } ?> 
                            </tr>
            <?php }$manager = "";$manager_bullets=""; ?> 

        <?php }
    }
} ?>    


        </tbody>

    </table>
</div>
<?php }else{echo"<div class='alert alert-danger'>Records not available for this selection</div>";}?>