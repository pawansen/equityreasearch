<style>
    .content-wrapper, .content-wrapper {
        padding: 41px;
    }
    * {
        border: medium none;
        list-style: outside none none;
        margin: 0;
        padding: 0;
        text-decoration: none;
    }
    .service {
        background: #fff none repeat scroll 0 0;
        border-color: #f88c00;
        border-radius: 5px 5px 0 0;
        border-style: solid;
        border-width: 5px 1px 1px;
        float: left;
        margin: 25px 0 25px 50px;
        padding: 20px 20px 10px;
        width: 326px;
    }.service h3 {
        float: left;
        padding: 0 0 10px;
        text-align: center;
        width: 100%;
    }
    h3 {
        font-size: 18px;
    }.ser_table {
        color: #444;
        float: left;
        font-size: 15px;
        width: 100%;
    }
    table {
        border-collapse: collapse;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
        margin: 0 0 1.5em;
        width: 100%;
    }
</style> 
<!--Main container sec start-->
<div class="main_container">
    <section class="innerpage_banner">
        <img src="<?php echo base_url(); ?>frontend_asset/images/about_banner.jpg" class="img-responsive">
        <div class="innr_bnr_cap">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="inr_banner_head">Pricing</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="bredcrumb_main">
                            <ol class="breadcrumb">
                                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="active">Pricing</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about_sec sec_padd">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-8">
                    <!--              <div class="since_text">Since 2007</div>-->
                    <div class="head_commen">
                        <div class="text-success"><?php echo $this->session->flashdata('success');?></div>
                        <div class="text-danger"><?php echo $this->session->flashdata('error');?></div>
                    </div>

                    <div class="entry-content">
                        <div class="inner">
                            <li class="service">
                                <h3>Stock Cash</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>2-3 per day</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 10,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 20,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 35,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 60,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a target="_blank" href="<?php echo base_url().'buy-now';?>" class="btn btn-warning">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Stock Future</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>2-3 per day</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 15,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 25,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 40,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 70,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Nifty Futures</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>2-3 Weekly</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 10,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 20,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 35,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 60,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Options &ndash; Call &amp; Put</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>02-03 per day</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 15,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 25,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 40,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 70,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Delivery</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>15-20 per quarter</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Positional</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 15,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 25,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 40,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 70,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>BTST / STBT Futures Pack</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>18-20 per month</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>BTST / STBT</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 20,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 35,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 60,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 90,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Base Metals Pack</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>1-2 per day</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 15,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 25,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 40,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 70,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Bullion Pack</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>1-2 per day</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 20,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 50,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 75,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 99,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Agri Pack</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>1-2 per day</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 15,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 25,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 40,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 70,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Bullion Metals Pack</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>2-4 per day</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 25,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 60,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 90,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 120,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Blue Chip</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>2-3 per day</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 25,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 45,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 85,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 150,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            <li class="service">
                                <h3>Customized Pack</h3>
                                <table class="ser_table">
                                    <tbody><tr>
                                            <td>Number of Calls</td>
                                            <td>2-3 per day</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>Intraday</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Via</td>
                                            <td>SMS</td>
                                        </tr>
                                        <tr>
                                            <td>Real Time Update</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Executive Support</td>
                                            <td><i aria-hidden="true" class="fa fa-check-square-o"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 75,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 150,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Half Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 220,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td>Yearly Pricing</td>
                                            <td><i aria-hidden="true" class="fa fa-inr"></i> 399,000 /-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-warning" target="_blank" href="<?php echo base_url().'buy-now';?>">Pay Now</a></td>
                                        </tr>
                                    </tbody></table>
                            </li>
                            </div>
                    </div>


                </div>

            </div>
        </div>
    </section>

</div>
<!--Main container sec end-->