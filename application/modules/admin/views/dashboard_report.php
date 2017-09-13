<table class="table table-striped table-bordered table-hover dataTables-dashboard-180">
    <thead>
        <tr>
            <th>180 Assessment Dashboard</th>
             <?php if(!empty($allUsers)){ 
              foreach($allUsers as $user){ ?>
            <th class='text-danger'><?php echo $user->name;?></th>
            <?php }}?>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($allUsers)){
              foreach($allUsers as $user){
              if($user->role_id == 5){?>
                <tr class="gradeX">
                    <td class='text-success'><a href="javascript:void(0);" onclick="chartRadarCaregory('<?php echo $user->id;?>','<?php echo $user->role_id;?>')"><?php echo $user->name;?></a></td>
                    <?php foreach($allUsers as $u){?>
                    
                            <td><?php  if($u->id ==$user->id){
                                echo is_assessment_current($organization_id,$user->id);
                                
                            }else{
                               echo is_assessment_submission($organization_id, $user->id, $u->id);
                            }?></td>

                        <?php }?>
                </tr>
        <?php }}}?>
    </tbody>
</table>