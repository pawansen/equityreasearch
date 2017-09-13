<div class="wrapper wrapper-content">
    <h3>Welcome <?php echo getConfig('site_name'); ?></h3>
    <div class="row">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="loaders">
                            <img src="<?php echo base_url() . 'backend_asset/images/Preloader_3.gif'; ?>" class="loaders-img" class="img-responsive">
                        </div>
                        <div class="ibox-content">
                            <form name="export-reports" action="<?php echo site_url('charts/exportsReport180Assessment');?>" method="post">
                            <div class="panel panel-<?php echo THEME_COLOR ?>">
                                <div class="panel-heading">180-Assessment Reports Exports</div>
                                <div class="panel-body">
                                    <div class="col-md-12 error"><?php echo $this->session->flashdata('error');?></div>
                                    <div class="clearfix"></div>
                                    <br>
                                    
                                    <div class="col-md-12">
                                        <label class="col-md-2 control-label">By Company :</label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="organization_id" id="organization_id" style="width:100%" onchange="generateReportGraphView('all')">
                                                <option value="">Select Company</option> 
                                                <?php
                                                if (!empty($organization)) {
                                                    foreach ($organization as $rows) {
                                                        ?>
                                                        <option value="<?php echo $rows->id; ?>"><?php echo ucwords($rows->name); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div><div class="clearfix"></div><br>
                                    <div id="filterByUser" style="display:none">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">By Manager :</label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="manager_user" id="manager_user" style="width:100%" onchange="generateReportGraphView('m')">
                                                </select>
                                            </div>
                                        </div><div class="clearfix"></div><br>
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">By Leader :</label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="leader_user" id="leader_user" style="width:100%" onchange="generateReportGraphView('l')">
                                                </select>
                                            </div>
                                        </div><div class="clearfix"></div><br>
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">By Sales Rep :</label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="sales_rep_user" id="sales_rep_user" style="width:100%" onchange="generateReportGraphView('s')">
                                                </select>
                                            </div>
                                        </div><div class="clearfix"></div><br>
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">Levels included :</label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="levels" id="levels" style="width:100%" onchange="generateReportGraphView('l')">
                                                    <option value="self">Self</option>
                                                    <option value="self_leader">Self and Leader</option>
                                                    <option value="self_leader_manager">Self and Leader and Manager</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div><br>
                                        <div class="col-md-12">
                                             <div class="col-md-6 col-md-offset-4">
<!--                                                 <button type="submit" name="export"  value="excel" class="btn btn-<?php //echo THEME_COLOR;?>" name=""> <i class="fa fa-file-excel-o"></i> Excel Export</button>-->
                                                 <button type="submit" name="export" class="btn btn-<?php echo THEME_COLOR;?>"> <i class="fa fa-file-pdf-o"></i> PDF Export</button>
                                             </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="assessment_type" id="assessment_type" value="180" />
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            </form>
                            
                             
                        </div>
                        <div class="panel panel-<?php echo THEME_COLOR ?>">
                            <div id="180-assessment-chart-view"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>