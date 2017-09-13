<?php if(!empty($allUsers)){?>

<div class="row">
    <div class="col-md-6">
        <a href="<?php echo site_url('charts/exportInExcel/'.encoding($allUsers).'/'.$organization_id)?>" class="btn btn-<?php echo THEME_COLOR;?>"> <i class="fa fa-file-excel-o"></i> Excel Export</a>
       <a href="<?php echo site_url('charts/exportInPdf/'.encoding($allUsers).'/'.$organization_id)?>" class="btn btn-<?php echo THEME_COLOR;?>"> <i class="fa fa-file-pdf-o"></i> PDF Export</a>
  </div>
</div>
<table class="table  table-bordered dataTables-dashboard-180-tracking1">
    <thead>
        <tr>
            <th>Sales Rep</th>
            <th class='text-success'>Self</th>
            <?php
                $allCountsUser = array();
            if (!empty($allUsers)) {
                foreach ($allUsers as $user) {
                    if (!empty($user['leader'])) {
                        foreach ($user['leader'] as $leader) {
                            //if(!empty($leader['sales'])){
                            // foreach($leader['sales'] as $sales){ 
                            ?>

                            <?php //}} ?>
                            <th class='text-success'><?php $allCountsUser[] = $leader['id']; echo $leader['name']; ?></th>      
                        <?php }
                    }
                    ?>
                    <th class='text-success'><?php $allCountsUser[] = $user['id']; echo $user['name']; ?></th>
                <?php }
            }
            ?>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($allUsers)) {
        foreach ($allUsers as $user) {
            if (!empty($user['leader'])) {
                foreach ($user['leader'] as $leader) {
                    if (!empty($leader['sales'])) {
                        foreach ($leader['sales'] as $sales) {
                            ?>
                            <tr class="gradeX">
                                <td class='text-success'><a href="javascript:void(0);" onclick="chartRadarCaregory('<?php echo $sales['id']; ?>', '<?php echo $sales['role_id']; ?>')"><?php echo $sales['name']; ?></a></td>
                                <td><?php echo is_assessment_current($organization_id, $sales['id']); ?></td>
                                <?php foreach($allCountsUser as $countUser){
                                    ?>
                                <?php $flag = true;$txt="";if($leader['id'] == $countUser){ $txt = is_assessment_submission($organization_id, $sales['id'], $leader['id']);$flag=false;}?>
                                 <?php if($user['id'] == $countUser){ $txt =  is_assessment_submission($organization_id, $sales['id'], $user['id']);$flag = false;}?>
                                <td class="<?php if($flag){echo "empty-td";}?>">
                                 
                                 <?php echo $txt;?>
                                 </td>
                                <?php }?>
                            </tr>
                        <?php }
                    }
                    ?>   

                <?php }
            }
            ?>
        <?php }
    } 
    ?> 
    </tbody>

</table>
<?php }else{echo"<div class='alert alert-danger'>Records not available for this selection</div>";}?>