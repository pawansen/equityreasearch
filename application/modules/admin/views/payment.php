<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($headline)) ? ucwords($headline) : "" ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin/dashboard'); ?>"><?php echo lang('home'); ?></a>
            </li>
            <li>
                <a href="<?php echo site_url('admin/payment'); ?>"><?php echo "Payment"; ?></a>
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
                <!--                <div class="ibox-title">
                                    <div class="btn-group " href="#">
                                        <a href="javascript:void(0)"  onclick="open_modal('cms')" class="btn btn-<?php //echo THEME_COLOR; ?>">
                <?php //echo lang('add_cms');?>
                                        <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>-->
                <div class="ibox-content">
                    <div class="row">
                        <?php $message = $this->session->flashdata('success');
                        if (!empty($message)):
                            ?><div class="alert alert-success">
                            <?php echo $message; ?></div><?php endif; ?>
                            <?php $error = $this->session->flashdata('error');
                            if (!empty($error)):
                                ?><div class="alert alert-danger">
    <?php echo $error; ?></div><?php endif; ?>
                        <div id="message"></div>
                        <div class="col-lg-12" style="overflow-x: auto">
                            <table class="table table-bordered table-responsive" id="common_datatable_cms">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Price</th>
                                        <th>City</th>
                                        <th>Zip Code</th>
                                        <th>Service</th>
                                        <th>Created Date</th>
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
                                                <td><?php echo $rows->name; ?></td>
                                                <td><?php echo $rows->email; ?></td>
                                                <td><?php echo $rows->phone; ?></td>
                                                <td><?php echo $rows->price; ?></td>
                                                <td><?php echo $rows->city; ?></td>
                                                <td><?php echo $rows->zipcode; ?></td>
                                                <td><?php echo $rows->service; ?></td>
                                                <td><?php echo $rows->create_date; ?></td>
                                            </tr>
    <?php endforeach;
endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="form-modal-box"></div>
            </div>
        </div>
    </div>