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
                            <div class="col-md-12">
                                <label class="col-md-2 control-label"><?php echo lang('organization'); ?> :</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="organization_id" id="organization_id" style="width:100%" onchange="generateReportDashboard(this.value)">
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
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div id="dashboardReport"></div>

                            <div id="dashboardReportChart">
                                <div class="wrapper wrapper-content animated fadeInRight">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox float-e-margins onTop">
                                                <div class="ibox-title">

                                                    <div class='col-md-12 col-md-offset-3 chartdiv' style="display: none;">
                                                        <h5>Self vs Leader by Category</h5>
                                                        <div class="col-md-1"><span style="color: #FF8C00;"><i class='fa fa-check-square fa-lg'></i></span> Self</div>
                                                        <div class="col-md-2"><span style="color: #4169E1;"><i class='fa fa-check-square fa-lg'></i></span> Leader</div>
                                                        <div class="clearfix"></div>
                                                        <br>
                                                    </div>
                                                    <div ibox-tools></div>
                                                </div>
                                                <div class="ibox-content">
                                                    <div id='graph-container'>
                                                        <canvas id="radarChart"></canvas>
                                                    </div>
                                                    <div id="dashboardReportTableAvg"></div>
                                                     <div class="col-md-12"><p class="text-danger" id='cateName'></p></div>
                                                     <div id='graph-container-line'>
                                                     <canvas id="lineChart"></canvas>
                                                     </div>
                                                     <div id="dashboardReportStatementAverage"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>