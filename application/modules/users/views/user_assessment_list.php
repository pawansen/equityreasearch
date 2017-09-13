<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($headline)) ? ucwords($headline) : ""?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin/dashboard');?>"><?php echo lang('home');?></a>
            </li>
            <li>
                <a href="<?php echo site_url('users/assessment');?>"><?php echo lang('user_assessment');?></a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="btn-group " href="#">
                        <a href="<?php echo site_url('users/add_assessment')?>"  class="<?php echo THEME_BUTTON;?>">
                            <?php echo lang('user_add_assessment');?>
                        <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                 <div class="row">
                      <?php $message = $this->session->flashdata('success');
                            if(!empty($message)):?><div class="alert alert-success">
                                <?php echo $message;?></div><?php endif; ?>
                       <?php $error = $this->session->flashdata('error');
                            if(!empty($error)):?><div class="alert alert-danger">
                                <?php echo $error;?></div><?php endif; ?>
                     <div id="message"></div>
                    <div class="col-lg-12" style="overflow-x: auto">
                    <table class="table table-bordered table-responsive" id="common_datatable_users_assessment">
                        <thead>
                            <tr>
                                <th style="width: 5%"><?php echo lang('serial_no');?></th>
                                <th style="width: 5%"><?php echo lang('user_name');?></th>
                                <th style="width: 5%"><?php echo lang('assessment');?></th>
                                <th style="width: 5%"><?php echo lang('start_date');?></th>
                                <th style="width: 5%"><?php echo lang('end_date');?></th>
                                <th style="width: 5%"><?php echo "Assessment Type";?></th>
                                <th style="width: 50%"><?php echo lang('submission_status');?></th>
                                <th style="width: 5%"><?php echo lang('user_createdate');?></th>
                                <th style="width: 10%"><?php echo lang('action');?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                            if (isset($list) && !empty($list)):
                                $rowCount = 0;
                                foreach ($list as $rows):
                                    $rowCount++;
                                    ?>
                            <tr>
                            <td><?php echo $rowCount; ?></td>            
                            <td><?php echo $rows->first_name.' '.$rows->last_name." (".getRole($rows->user_id).")";?></td>
                            <td><?php echo $rows->assessment_name?></td>
                            <td><?php echo date('d F Y',strtotime($rows->start_date));?></td>
                            <td><?php echo date('d F Y',strtotime($rows->end_date));?></td>
<!--                            <td><?php //if($rows->active == 1) echo '<p class="text-success">'.lang('active').'</p>'; else echo '<p  class="text-danger">'.lang('deactive').'</p>';?></td>-->
                            <td><?php if($rows->assessment_type == 180) echo '<p class="text-success">180 Assessment</p>'; else echo '<p  class="text-success">Daily Assessment</p>';?></td>
                            <td><?php 
                            
                                $options = array('table' => USER_ASSESSMENT.' as UA',
                                                 'select' => 'AU.id as upper_id,AU.assessment_status,user.id as user_id,user.first_name,user.last_name',
                                                 'join' => array(USER_ASSESSMENT.' as AU' => 'AU.child_upper_id=UA.id',
                                                                 USERS.' as user' => 'user.id=AU.user_id'),
                                                 'where' => array('UA.id' => $rows->user_assessment_id)
                                                );
                                $all_asssessment = commonGetHelper($options);
                                $sts = ($rows->assessment_status == 1) ? "<span class='text-success'>Complete</span>" :""."<span class='text-danger'>Pending</span>";
                                //$htm = "<p class='col-sm-9'>".$rows->first_name.' '.$rows->last_name." (".getRole($rows->user_id).")   <i class='fa fa-arrow-circle-o-right'></i></p><p class='col-sm-2'>".$sts."<p>";
                               $htm = "<p class='col-sm-12'>Self   <i class='fa fa-arrow-circle-o-down'></i></p><p class='col-sm-2'>(".$sts.")<p>";
                                if(!empty($all_asssessment)){
                                    foreach($all_asssessment as $val){
                                        $sts_htm = ($val->assessment_status == 1) ? "<span class='text-success'>Complete</span>" :""."<span class='text-danger'>Pending</span>";
                                        $htm .= "<p class='col-sm-12'>".$val->first_name.' '.$val->last_name." (".getRole($val->user_id).")   <i class='fa fa-arrow-circle-o-down'></i></p><p class='col-sm-12'>(".$sts_htm.")<p>";
                                    }
                                }
                                echo $htm;
                            
                            ?></td>

                            <td><?php echo date('d F Y',strtotime($rows->create_date));?></td>
                            <td class="actions">
                            <a href="<?php echo site_url('users/edit_assessment/'.encoding($rows->user_assessment_id));?>" class="on-default edit-row"><img width="20" src="<?php echo base_url().EDIT_ICON;?>" /></a>
                            <a href="javascript:void(0)" onclick="viewFn('users','view_assessment','<?php echo encoding($rows->user_assessment_id); ?>')" class="on-default edit-row"><img width="20" src="<?php echo base_url().VIEW_ICON;?>" /></a>
                          
                          <?php if(1){if($rows->active == 1) {?>
                            <a href="javascript:void(0)" class="on-default edit-row" onclick="statusFn('<?php echo USER_ASSESSMENT;?>','id','<?php echo encoding($rows->user_assessment_id);?>','<?php echo $rows->active;?>')" title="Inactive Now"><img width="20" src="<?php echo base_url().ACTIVE_ICON;?>" /></a>
                            <?php } else { ?>
                            <a href="javascript:void(0)" class="on-default edit-row text-danger" onclick="statusFn('<?php echo USER_ASSESSMENT;?>','id','<?php echo encoding($rows->user_assessment_id); ?>','<?php echo $rows->active;?>')" title="Active Now"><img width="20" src="<?php echo base_url().INACTIVE_ICON;?>" /></a>
                            <?php } ?>
                            
                            <a href="javascript:void(0)" onclick="deleteFn('<?php echo USER_ASSESSMENT;?>','id','<?php echo encoding($rows->user_assessment_id); ?>','users/assessment','users/assessment_del')" class="on-default edit-row text-danger"><img width="20" src="<?php echo base_url().DELETE_ICON;?>" /></a>
                            <hr>
                             <a href="<?php echo site_url('users/viewAssessmentCategory/'.encoding($rows->user_assessment_id).'?u='.$rows->first_name.' '.$rows->last_name." (".getRole($rows->user_id).")&a=".$rows->assessment_name);?>" class="btn btn-info">Assessment Category</a>
                            </td>
                            </tr>
                            <?php }endforeach; endif;?>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
                <div id="form-modal-box"></div>
        </div>
    </div>
</div>