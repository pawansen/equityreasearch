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
                    <div class="panel-heading"><?php echo lang('user_add_assessment'); ?></div>
                    <div class="panel-body">
                        <div class="ibox float-e-margins">
                            <div class="col-lg-8">
                                <?php
                                $message = $this->session->flashdata('error');
                                if (!empty($message)):
                                    ?><div class="alert alert-danger">
    <?php echo $message; ?></div><?php endif; ?>
                                <div class="loaders">
                                    <img src="<?php echo base_url() . 'backend_asset/images/Preloader_3.gif'; ?>" class="loaders-img" class="img-responsive">
                                </div>
                                <div class="alert alert-danger" id="error-box" style="display: none"></div>
                                <form class="form-horizontal" role="form" id="addFormAjax" method="post" action="<?php echo base_url('users/add_assessment') ?>" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('organization'); ?></label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="organization_id" id="organization_id" style="width:100%">
                                                <option value="">Select Organization</option>
                                                <?php
                                                if (!empty($organization)) {
                                                    foreach ($organization as $rows) {
                                                        ?>
                                                        <option value="<?php echo $rows->id; ?>"><?php echo ucwords($rows->name); ?></option>
                                                    <?php }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    
                                    <div class="form-group upperDiv" style="display:none">
                                        <label class="col-md-3 control-label">Upper User <div id="positionName"></div></label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="upperPositionUser" id="upperPositionUser" style="width:100%">
                                            </select>

                                        </div>
                                    </div>
                                    
                                    <div class="form-group upperMediumDiv" style="display:none">
                                        <label class="col-md-3 control-label">Upper User <div id="positionNameDownUpper"></div></label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="positionNameDownUpperUser" id="positionNameDownUpperUser" style="width:100%">
                                            </select>

                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('user'); ?></label>
                                        <div class="col-md-9">
    <!--                                        <select class="" name="user_id" id="user_id" style="width:100%">
    
                                            </select>-->
                                            <input  type="hidden" class="from-control" style="width:100%" name="user_id" id="user_id" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('assessment_name'); ?></label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="assessment_id" id="assessment_id" style="width:100%">
                                                <option value="">Select Assessment</option>
                                                <?php
                                                if (!empty($assessment)) {
                                                    foreach ($assessment as $rows) {
                                                        ?>
                                                        <option value="<?php echo $rows->id; ?>"><?php echo ucwords($rows->assessment_name); ?></option>
                                                    <?php }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label"></label>
                                        <div class="col-md-12 col-md-offset-2">
                                            <label class="checkbox-inline">
                                                <input id="select_all" value="180" type="radio" name="select_question" class="questionSelect" checked="">
                                                Select All Questions (180 Assessment)
                                            </label>
                                            <label class="checkbox-inline">
                                                <input id="select_specific" value="360" type="radio" name="select_question" class="questionSelect">
                                                Select Specific Questions (Daily Assessment)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('question'); ?></label>
                                        <div class="col-md-9">
                                            <select class="" name="question_id[]" id="question_id" style="width:100%;" multiple="">
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('start_date'); ?></label>
                                        <div class="col-md-9">
                                            <input  type="text" class="form-control sedate" name="start_date" id="start_date" readonly=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('end_date'); ?></label>
                                        <div class="col-md-9">
                                            <input  type="text" class="form-control sedate" name="end_date" id="end_date" readonly=""/>
                                            <p class="text-danger" id="date_message"></p>
                                        </div>
                                    </div>
                                    <div id="focused-bulet" style="display:none;">

                                       
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('bullets_in_month'); ?></label>
                                            <div class="col-md-9">
                                                <input  type="text" class="form-control" name="bullets_in_month" id="bullets_in_month" readonly=""/>
                                                <p class="text-danger" id="date_message"></p>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('bullets'); ?></label>
                                            <div class="col-md-9">
                                                <input  type="text" class="form-control" name="bullets" id="bullets" value="0" readonly=""/>
                                            </div>
                                        </div>  
                                        
                                    </div>
                                    <hr>
                                    <div id="upper-lavel-box"></div>
                                    <div class="space-22 col-md-offset-12"><a class="btn btn-success btn-sm" id='upper-lavel'>+ Add Upper Level</a></div>
                                    <input type="hidden" name="assessment_type" value="180" id="assessment_type_hidden" />
                                    <div class="space-22"></div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-lg-offset-9 col-lg-10">
                                           <a href="<?php echo base_url().'users/assessment'?>" class="btn btn-danger"><?php echo lang('cancle_btn');?></a>
                                            <button type="submit" id="submit" class="<?php echo THEME_BUTTON; ?>" ><?php echo lang('submit_btn'); ?></button>
                                        </div>
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

