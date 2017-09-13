<style>
    .danger {
        color:red;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($headline)) ? ucwords($headline) : "" ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin/dashboard'); ?>"><?php echo lang('home'); ?></a>
            </li>
            <li>
                <a href="<?php echo site_url('users/assessment'); ?>"><?php echo lang("user_assessment"); ?></a>
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

                <div class="panel panel-<?php echo THEME_COLOR;?>">
                    <div class="panel-heading"><?php echo lang('user_edit_assessment'); ?></div>
                    <div class="panel-body">
                        <div class="ibox float-e-margins">
                            <div class="col-lg-8">
                                <?php $message = $this->session->flashdata('error');
                                if (!empty($message)):
                                    ?><div class="alert alert-danger">
                                <?php echo $message; ?></div><?php endif; ?>
                                <div class="loaders">
                                    <img src="<?php echo base_url() . 'backend_asset/images/Preloader_3.gif'; ?>" class="loaders-img" class="img-responsive">
                                </div>
                                <div class="alert alert-danger" id="error-box" style="display: none"></div>
                                <form class="form-horizontal" role="form" id="addFormAjax" method="post" action="<?php echo base_url('users/update_assessment') ?>" enctype="multipart/form-data">

                     <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('organization'); ?></label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="organization_id" id="organization_id" style="width:100%">
                                                <?php
                                                if (!empty($organization)) {
                                                    foreach ($organization as $rows) {
                                                        ?>
                                                        <option value="<?php echo $rows->id; ?>" <?php echo ($results->organization_id == $rows->id) ? "selected" : ""?>><?php echo ucwords($rows->name); ?></option>
    <?php }
}
?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('user'); ?></label>
                                        <div class="col-md-9">
                                            <select class="" name="user_id[]" id="user_ids" style="width:100%">
                                                <option value="<?php echo $results->user_id;?>"><?php echo $results->first_name." ".$results->last_name." (".getRole($results->user_id).")";?></option>
                                            </select>
<!--                                            <input  type="hidden" class="from-control" style="width:100%" name="user_id" id="user_id" />-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('assessment_name'); ?></label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="assessment_id" id="assessment_id" style="width:100%">
                                                <option value="">Select Assessment</option>
                                                    <?php if (!empty($assessment)) {
                                                    foreach ($assessment as $rows) {
                                                        ?>
                                                        <option value="<?php echo $rows->id; ?>" <?php echo ($results->assessment_id == $rows->id) ? "selected" : ""?>><?php echo ucwords($rows->assessment_name); ?></option>
                                                        <?php }
                                                    } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label"></label>
                                        <div class="col-md-12 col-md-offset-2">
                                            <?php if($results->assessment_type == 180){?>
                                            <label class="checkbox-inline">
                                                <input id="select_all" value="180" type="radio" name="select_question" class="questionSelect" <?php echo ($results->assessment_type == 180) ? "checked" : ""?>>
                                                Select All Questions (180 Assessment)
                                            </label>
                                            <?php }else{?>
                                            <label class="checkbox-inline">
                                                <input id="select_specific" value="360" type="radio" name="select_question" class="questionSelect" <?php echo ($results->assessment_type == 360) ? "checked" : ""?>>
                                                Select Specific Questions (Daily Assessment)
                                            </label>
                                            <?php }?>   
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('question'); ?></label>
                                        <div class="col-md-9">
                                            <select class="" name="question_id[]" id="question_id" style="width:100%;" multiple="">
                                                <?php foreach($questionList as $que){?>
                                                <option value="<?php echo $que->question_id;?>" selected=""><?php echo $que->question;?></option>
                                                <?php }?>
                                            </select>

                                        </div>
                                    </div>
                                      <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('start_date'); ?></label>
                                        <div class="col-md-9">
                                            <input  type="text" class="form-control sedate editEndDate" name="start_date" id="start_date" readonly="" value="<?php echo date('m/d/Y',strtotime($results->start_date));?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('end_date'); ?></label>
                                        <div class="col-md-9">
                                            <input  type="text" class="form-control sedate" name="end_date" id="end_date" readonly="" value="<?php echo date('m/d/Y',strtotime($results->end_date));?>"/>
                                            <p class="text-danger" id="date_message"></p>
                                        </div>
                                    </div>
                                    
                                    <div id="focused-bulet" style="<?php echo ($results->assessment_type == 360) ? "display:block;" : "display:none;"?>">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('bullets'); ?></label>
                                            <div class="col-md-9">
                                                <input  type="text" class="form-control" name="bullets" id="bullets" value="<?php echo $results->bullets;?>"/>
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('bullets_in_month'); ?></label>
                                            <div class="col-md-9">
                                                <input  type="text" class="form-control bullets_datepicker" name="bullets_in_month" id="bullets_in_month" readonly="" value="<?php echo $results->bullets_in_month_date;?>"/>
                                                <p class="text-danger" id="date_message"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $results->user_ass_id;?>" />
                                    <hr>
                                    <div id="upper-lavel-box">
                                      <?php if($results->assessment_type == 180){
                                          foreach($upper_lavel as $ul){
                                                  $isSubmit = true;
                                                  if($ul->assessment_status == 1){
                                                   $isSubmit = false;
                                                   }?>  
                                        <div class="form-group">
                                            <div class="col-md-offset-5 text-danger"><i class="fa fa-arrow-circle-o-down"></i> Parent</div>
                                            <label class="col-md-3 control-label">Upper Level</label>
                                            <div class="col-md-8" id="upper-lavel-input">
                                                <select class="form-control" name="upper_level_user[]" id="upper_level_user" style="width:100%">
                                                    <option value="<?php echo $ul->user_id;?>"><?php echo $ul->first_name." ".$ul->last_name." (".getRole($ul->user_id).")";?></option>
                                                </select>
                                            </div>
                          
                                            <?php if($isSubmit){?>
                                            <div class="col-md-1"><a class="btn btn-danger" onclick="removeUpperAssessment('<?php echo $ul->user_ass_id;?>','<?php echo $ul->first_name." ".$ul->last_name." (".getRole($ul->user_id).")";?>')"><i class="fa fa-minus-circle"></i></a></div>
                                            <?php }else{?>
                                            <br>
                                            <div class="col-md-10 col-md-offset-3"><span class='text-danger'>This upper level can not removable because this submission process started by him.</span></div>
                                            <?php }?>
                                        </div>
                                         
                                          <?php }}else{
                                              foreach($upper_lavel as $ul){
                                                  $isSubmit = true;
                                                  if($ul->bullets_submission != 0){
                                                   $isSubmit = false;
                                                   }?>   
                                        
                                        <div class="form-group">
                                                <div class="col-md-offset-5 text-danger"><i class="fa fa-arrow-circle-o-down"></i> Parent</div>
                                            <label class="col-md-3 control-label">Upper Level</label>
                                            <div class="col-md-8" id="upper-lavel-input">
                                                <select class="form-control" name="upper_level_user[]" id="upper_level_user" style="width:100%">
                                                   <option value="<?php echo $ul->user_id;?>"><?php echo $ul->first_name." ".$ul->last_name." (".getRole($ul->user_id).")";?></option>
                                                </select>
                                                 
                                            </div>
                                            <?php if($isSubmit){?>
                                            <div class="col-md-1"><a class="btn btn-danger" onclick="removeUpperAssessment('<?php echo $ul->user_ass_id;?>','<?php echo $ul->first_name." ".$ul->last_name." (".getRole($ul->user_id).")";?>')"><i class="fa fa-minus-circle"></i></a></div>
                                            <?php }else{?>
                                            <br><br>
                                            <div class="col-md-10 col-md-offset-3"><span class='text-danger'>This upper level can not removable because this submission process started by him.</span></div>
                                            <?php }?>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('bullets'); ?></label>
                                            <div class="col-md-9">
                                                <input  type="text" class="form-control" name="bullets_upper[]" id="bullets_upper" value="<?php echo $ul->bullets;?>"/>
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('bullets_in_month'); ?></label>
                                            <div class="col-md-9">
                                                <input  type="text" class="form-control bullets_datepicker" name="bullets_in_month_upper[]" id="bullets_in_month_upper" readonly="" value="<?php echo $ul->bullets_in_month_date;?>"/>
                                                <p class="text-danger" id="date_message"></p>
                                            </div>
                                            
                                        </div>
                                        
                                              <?php }} ?>
                                    </div>
                                    
<!--                                    <div class="space-22 col-md-offset-12"><a class="btn btn-success btn-sm" id='upper-lavel'>+ Add Upper Level</a></div>-->
                                    <input type="hidden" name="assessment_type" value="<?php echo $results->assessment_type;?>" id="assessment_type_hidden" />
                                    <div class="space-22"></div>
                                    <hr>
                                    <div class="form-group">
                                        <?php
                                           if($results->assessment_type == 180){
                                           $flag = true;
                                           $flag = ($results->assessment_status != 1) ? true : false;
                                           foreach($upper_lavel as $ul){
                                               if($ul->assessment_status == 1){
                                                   $flag = false;
                                               }
                                           }?>
                                        <?php if(count($upper_lavel) < 2){?>
                                         <div id="upper-lavel-box"></div>
                                         <div class="space-22 col-md-offset-11"><a class="btn btn-success btn-sm" id='upper-lavel-edit-180'>+ Add Upper Level</a></div>
                                         <br>
                                           <?php }?> 
                                         <div class="<?php echo ($flag) ? "col-lg-offset-10" : "col-lg-offset-2";?> col-lg-10">
                                            <a href="<?php echo base_url().'users/assessment'?>" class="btn btn-danger"><?php echo lang('cancle_btn');?></a>
                                           <?php
                                           
                                           if($flag){?>
                                            <button type="submit" id="submit" class="<?php echo THEME_BUTTON; ?>" ><?php echo lang('submit_btn'); ?></button>
                                           <?php }else{
                                               echo "<div class='alert alert-danger'>This Assessment can not editable because this already submission completed by user</div>";
                                           }
                                           ?>
                                        </div>
                                        <?php }else{?>
                                        <?php  
                                           $flag = true;
                                           $flag = ($results->bullets_submission != 0) ? false : true;
                                           foreach($upper_lavel as $ul){
                                               if($ul->bullets_submission != 0){
                                                   $flag = false;
                                               }
                                           }?>
                                        <?php if(count($upper_lavel) < 2){?>
                                         <div id="upper-lavel-box"></div>
                                         <div class="space-22 col-md-offset-11"><a class="btn btn-success btn-sm" id='upper-lavel-edit-360'>+ Add Upper Level</a></div>
                                         <br>
                                           <?php }?> 
                                        <div class="<?php echo ($flag) ? "col-lg-offset-10" : "col-lg-offset-2";?> col-lg-10">
                                        <a href="<?php echo base_url().'users/assessment'?>" class="btn btn-danger"><?php echo lang('cancle_btn');?></a>
                                           <?php
                                          
                                           if($flag){?>
                                            <button type="submit" id="submit" class="<?php echo THEME_BUTTON; ?>" ><?php echo lang('submit_btn'); ?></button>
                                           <?php }else{
                                               echo "<div class='alert alert-danger'>This Assessment can not editable because this submission process started by user</div>";
                                           }
                                           ?>
                                        </div>
                                        
                                        <?php }?>
                                    </div>

                                </form>
                            </div>    
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

