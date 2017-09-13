<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> <?php echo getConfig('site_name');?> | <?php 
        if(!empty($title) && isset($title)): echo ucwords($title);endif; ?></title>

        <link href="<?php echo base_url(); ?>backend_asset/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/css/animate.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/css/plugins/dropzone/basic.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/css/plugins/dropzone/dropzone.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/plugins/summernote/dist/summernote.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>backend_asset/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
         <link href="<?php echo base_url(); ?>backend_asset/css/plugins/toastr/toastr.min.css" rel="stylesheet">
 <style>.error{color: #DC2430;}</style>
<style>
    .loaders {
      position:absolute; 
      opacity:0.5;
      background-color:fff; 
      width:100%; height:100%;
      top:0; left:0; bottom:0; right:0; 
      text-align:center; vertical-align:middle; 
      display: none;
      z-index: 2000;
}
.loaders img{
left : 50%;
top : 50%;
position : absolute;
z-index : 101;


}
</style>
    
    </head>
    
<body class="pace-done <?php echo THEME;?>" cz-shortcut-listen="true">
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">

                            <div class="dropdown profile-element"> <span>
                                    <img width="48" alt="image" class="img-circle" src="<?php echo base_url().  getConfig('site_logo'); ?>" />
                                </span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">
                                        <?php $user = getUser($this->session->userdata('user_id'));
                                        if(!empty($user)){
                                             echo ucwords($user->first_name." ".$user->last_name);}?></strong>
                                        </span> <span class="text-muted text-xs block"><?php echo lang('Admin');?> <b class="caret"></b></span> </span> </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="<?php echo site_url('admin/profile'); ?>"><?php echo lang('profile');?></a></li>
                                    <li><a href="<?php echo site_url('admin/password'); ?>"><?php echo lang('change_password');?></a></li>
                                    <li class="divider"></li>
                                    <li><a href="javascript:void(0)" onclick="logout()"><?php echo lang('logout');?></a></li>
                                </ul>
                            </div>
                            <div class="logo-element">
                                <img width="80" src="<?php echo base_url().  getConfig('site_logo'); ?>" class="img-responsive img-circle" alt="" />
                            </div>
                        </li>
                 
<!--                        <li title="Dashboard" class="<?php echo (strtolower($this->router->fetch_class()) == "admin") ? "active" : "" ?>">
                            <a href="<?php echo site_url('admin'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo lang('dashboard');?></span></a>
                        </li>-->
                        
                                                
                         <li title="Dashboard" class="<?php echo (strpos($parent , "180_tracking") !== false || strpos($parent , "180_reports") !== false || strpos($parent , "daily_tracking") !== false || strpos($parent , "daily_reports") !== false) ? "active" : "" ?>">
                            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo lang('dashboard');?></span><span class="fa arrow"></span></a>
                          <!--   <ul class="nav nav-second-level">
                                <li class="<?php echo (strpos($parent , "180_tracking") !== false) ? "active" : "" ?>"><a  href="<?php echo site_url('charts/tracking_180'); ?>"><i class="fa fa-bar-chart"></i> 180-Assessment Tracking</a></li>
                                <li class="<?php echo (strpos($parent , "180_reports") !== false) ? "active" : "" ?>"><a  href="<?php echo site_url('charts/reports_180'); ?>"><i class="fa fa-file-pdf-o"></i> 180-Assessment Reports</a></li>
                                <li class="<?php echo (strpos($parent , "daily_tracking") !== false) ? "active" : "" ?>"><a  href="<?php echo site_url('charts/daily_tracking'); ?>"><i class="fa fa-bar-chart"></i> Daily-Assessment Tracking</a></li>
                                <li class="<?php echo (strpos($parent , "daily_reports") !== false) ? "active" : "" ?>"><a  href="<?php echo site_url('charts/daily_reports'); ?>"><i class="fa fa-file-pdf-o"></i> Daily-Assessment Reports</a></li>
                            </ul> -->
                        </li>
                        
                        
                        <li title="Roles" class="<?php echo (strtolower($this->router->fetch_class()) == "roles") ? "active" : "" ?>">
                            <a href="<?php echo site_url('roles'); ?>"><i class="fa fa-users"></i> <span class="nav-label"><?php echo lang('roles');?></span></a>
                        </li>

                        
                        <li title="Users" class="<?php echo (strtolower($this->router->fetch_class()) == "users" || strpos($parent , "UA") !== false || strpos($parent , "UH") !== false) ? "active" : "" ?>">
                            
                            <a href="#"><i class="fa fa-user"></i> <span class="nav-label"><?php echo lang('users');?></span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                               <li class="<?php echo (strpos($parent , "User") !== false) ? "active" : "" ?>"><a  href="<?php echo site_url('users'); ?>"><i class="fa fa-user"></i> <?php echo lang('users');?></a></li>
                            </ul>
                        </li>

                        <li title="Cms" class="<?php echo (strtolower($this->router->fetch_class()) == "cms") ? "active" : "" ?>">
                            <a href="<?php echo site_url('cms'); ?>"><i class="fa fa-pagelines"></i> <span class="nav-label"><?php echo lang('cms');?></span></a>
                        </li>

<!--                        <li title="Reports" class="<?php echo (strtolower($this->router->fetch_class()) == "reports") ? "active" : "" ?>">
                            <a href="<?php echo site_url('admin'); ?>"><i class="fa fa-bar-chart"></i> <span class="nav-label">Reports</span></a>
                        </li>-->
                        
                         <li title="Settings" class="<?php echo (strtolower($this->router->fetch_class()) == "setting") ? "active" : "" ?>">
                            <a href="<?php echo site_url('setting'); ?>"><i class="fa fa-cogs"></i> <span class="nav-label"><?php echo lang('setting');?></span></a>
                        </li>

                        <li title="Logout">
                            <a href="javascript:void(0)" onclick="logout()"><i class="fa fa-sign-out"></i> <span class="nav-label"><?php echo lang('logout');?></span></a>
                        </li>
                        
                    </ul>
                </div>
            </nav>
            <input type="hidden" value="" id="latestOrderId">
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <a href="javascript:void(0)" onclick="logout()">
                                    <span class="btn btn-sm btn-danger">
                                    <i class="fa fa-sign-out"></i> <?php echo lang('logout');?>
                                    </span>
                                </a>
                            </li>
                        </ul>

                    </nav>
                </div>