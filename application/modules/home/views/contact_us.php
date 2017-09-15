<style>
     .error {color:red;}
</style>   
<!--Main container sec start-->
    <div class="main_container">
      <section class="innerpage_banner">
        <img src="<?php echo base_url(); ?>frontend_asset/images/about_banner.jpg" class="img-responsive">
        <div class="innr_bnr_cap">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <h1 class="inr_banner_head">Contact us</h1>
              </div>
              <div class="col-sm-6">
                <div class="bredcrumb_main">
                  <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="active">Contact us</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="contact_page sec_padd font_18">
        <div class="container">
            <div class="row">
              <div class="col-md-8 col-sm-8">
                <div class="head_commen">
                  <h2> Get In Touch </h2>
                </div>
                <div class="contact_form">
                  <p>FILL BELOW FORM FOR CALL BACK</p>
                  <div class="text-success"><?php echo $this->session->flashdata('success');?></div>
                  <br>
                  <form class="" action="<?php echo base_url().'contact-us';?>" method="post">
                    <div class="row">
                      <div class="col-sm-6">
                      <div class="form-group">
                        <label class="sr-only" for="First Name">Full Name</label>
                        <input type="text" class="form-control" placeholder="Full Name" name="name" value="<?php echo set_value('name');?>">
                        <?php echo form_error('name');?>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="sr-only" for="Email Address">Email Address</label>
                        <input type="email" class="form-control" placeholder="Email Address" name="email" value="<?php echo set_value('email');?>">
                        <?php echo form_error('email');?>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="sr-only" for="Mobile">Mobile</label>
                        <input type="text" class="form-control" placeholder="Mobile" name="mobile" value="<?php echo set_value('mobile');?>">
                        <?php echo form_error('mobile');?>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="sr-only" for="Subject">Subject</label>
                        <input type="text" class="form-control" placeholder="Subject" name="subject" value="<?php echo set_value('subject');?>">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                          <textarea class="form-control" rows="3" placeholder="Message" name="message"><?php echo set_value('message');?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12">
                        <button type="submit" class="btn_commen green_bg">Submit</button>
                      </div>
                    </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-md-3">
                <div class="head_commen">
                  <h2> Office Address </h2>
                </div>
                <div class="off_address">
                  <p class="pera_bottom_20">380 Shrinagar Extension Indore</p>
                  <p class="pera_bottom_20">Phone:  0731-00023656</p>
                </div>
                <hr>
              </div>
            </div>
        </div>
      </section>
    </div>
    <!--Main container sec end-->