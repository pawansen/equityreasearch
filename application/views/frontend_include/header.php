<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title." | ".SITE_NAME;?></title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>frontend_asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>frontend_asset/css/plugin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>frontend_asset/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700,900" rel="stylesheet"> 
    <link href="<?php echo base_url(); ?>frontend_asset/css/slick.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>frontend_asset/css/slick-theme.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>frontend_asset/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>frontend_asset/css/responsive.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>frontend_asset/js/modernizr-custom.js"></script>
  </head>
  <body>
  <main class="animsition">
	<!--Header sec start-->
    <header class="header_main" data-spy="affix" data-offset-top="3"  id="header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
              <div class="header_contact">
                <marquee class="text-center">
				
				<span style=" color:#000; font-weight: 900;"> Kindly note Investment Visor do not provide any service which is not mention in our Website nor any Guarantee services. If So then Kindly Call on <?php echo PHONE;?>  . Investment in Share and Commodity market is subject to market risk.
 </span>
			</marquee>
              </div>
              <nav class="navbar navbar-default">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="<?php echo base_url();?>">
                    <img src="<?php echo base_url().LOGO; ?>" class="img-responsive">
                  </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                 
                  
                  <ul class="nav navbar-nav navbar-right">
                    <li class="<?php echo (isset($parent) && $parent=='home') ? "active" : "";?>"><a href="<?php echo base_url();?>">Home</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Service <i class="fa fa-angle-down"></i></a>
                      <ul class="dropdown-menu">
                          <li class="<?php echo (isset($parent) && $parent=='futureoption') ? "active" : "";?>"><a href="<?php echo base_url(); ?>index-future-option">Index Future Option</a></li>
                          <li class="<?php echo (isset($parent) && $parent=='btst') ? "active" : "";?>"><a href="<?php echo base_url(); ?>btst-stbt">BTST/STBT</a></li>
                          <li class="<?php echo (isset($parent) && $parent=='cash') ? "active" : "";?>"><a href="<?php echo base_url(); ?>cash">Cash</a></li>
                          <li class="<?php echo (isset($parent) && $parent=='future') ? "active" : "";?>"><a href="<?php echo base_url(); ?>future">Future</a></li>
                          <li class="<?php echo (isset($parent) && $parent=='option') ? "active" : "";?>"><a href="<?php echo base_url(); ?>option">Option</a></li>
                          <li class="<?php echo (isset($parent) && $parent=='mcx') ? "active" : "";?>"><a href="<?php echo base_url(); ?>mcx">MCX</a></li>
                          <li class="<?php echo (isset($parent) && $parent=='sure') ? "active" : "";?>"><a href="<?php echo base_url(); ?>sure-shot">Sure Shot</a></li>
                          <li class="<?php echo (isset($parent) && $parent=='circuit') ? "active" : "";?>"><a href="<?php echo base_url(); ?>circuit-call">Circuit Call</a></li>
                          <li class="<?php echo (isset($parent) && $parent=='premium') ? "active" : "";?>"><a href="<?php echo base_url(); ?>premium">Premium</a></li>
                      </ul>
                    </li>
                    <li class="<?php echo (isset($parent) && $parent=='pricing') ? "active" : "";?>"><a href="<?php echo base_url().'pricing';?>">Pricing</a></li>
                    <li class="<?php echo (isset($parent) && $parent=='payment') ? "active" : "";?>"><a href="<?php echo base_url().'payment';?>">Payment</a></li>
                    <li class="<?php echo (isset($parent) && $parent=='reports') ? "active" : "";?>"><a href="<?php echo base_url();?>">Report & Tracksheet</a></li>
                    <li><a href="#free-trial" data-toggle="modal" data-target="#free-trial">free trail</a></li>
                    <li class="<?php echo (isset($parent) && $parent=='about') ? "active" : "";?>"><a href="<?php echo base_url().'about-us';?>">About Us</a></li>
                    <li class="<?php echo (isset($parent) && $parent=='contact') ? "active" : "";?>"><a href="<?php echo base_url().'contact-us';?>">Contact Us</a></li>
                  </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
          </div>
        </div>
      </div>
    </header>
    <div id="for_back_height"></div>
    <!--Header sec end-->