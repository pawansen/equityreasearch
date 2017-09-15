<!--Footer sec start-->
<footer id="footer" class="footer_sec">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="ftr_block">
                    <h4>Corporate Headquarters</h4>
                    <ul class="ftr_address">
                        <li> <i class="fa fa-map-marker"></i> 380 Shrinagar Extension Indore</li>
                        <li> <i class="fa fa-phone"></i> 0731-00023656</li>
                        <li> <i class="fa fa-envelope"></i> eqresearchpanel@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ftr_block">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="<?php echo base_url() . 'pricing'; ?>">Pricing</a></li>
                        <li><a href="<?php echo base_url() . 'payment'; ?>">Payment</a></li>
                        <li><a href="<?php echo base_url() . 'report'; ?>">Report & Tracksheet</a></li>
                        <li><a href="#free-trial" data-toggle="modal" data-target="#free-trial">Free trail</a></li>
                        <li><a href="<?php echo base_url() . 'about-us'; ?>">About Us</a></li>
                        <li><a href="<?php echo base_url() . 'contact-us'; ?>">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ftr_block">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="index-future-option">Index Future Option</a></li>
                        <li><a href="btst-stbt">BTST/STBT</a></li>
                        <li><a href="cash">Cash</a></li>
                        <li><a href="future">Future</a></li>
                        <li><a href="option">Option</a></li>
                        <li><a href="mcx">MCX</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="ftr_bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="copyright_main">
                        <!--                        <div class="ftr_logo">
                                                    <img src="<?php echo base_url(); ?>frontend_asset/images/eq.png" class="img-responsive">
                                                </div>-->
                        <div class="copy_ftr_link">
                            <p>© Copyright 2017 Equity Research</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Modal -->
<div id="free-trial" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">FREE TRIAL</h4>
            </div>
            <div class="modal-body">
                <p>To create best customer support while all market up & downs, so that customer can make maximum profit out of his investment.</p>
                <div id='errorMsg' class="text-danger"></div>
                <div id='successMsgs' class="text-success"></div>
                <form class="form-free-trial" id='freetrial' action="#" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="sr-only" for="First Name">Full Name</label>
                                <input type="text" class="form-control" placeholder="Full Name" name="names" value="<?php echo set_value('names'); ?>">
                                <?php echo form_error('names'); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="sr-only" for="Email Address">Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" name="emails" value="<?php echo set_value('emails'); ?>">
                                <?php echo form_error('emails'); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="sr-only" for="Mobile">Mobile</label>
                                <input type="text" class="form-control" placeholder="Mobile" name="mobiles" value="<?php echo set_value('mobiles'); ?>">
                                <?php echo form_error('mobiles'); ?>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Message" name="messages"><?php echo set_value('messages'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 col-md-offset-8">
                                <button type="button" class="btn_commen green_bg" id='submit' onclick="freeTrialSubmit()">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!--Footer sec end-->
</main>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo base_url(); ?>frontend_asset/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>frontend_asset/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>frontend_asset/js/plugin.js"></script>

<script src="<?php echo base_url(); ?>frontend_asset/js/slick.js"></script>

<script src="<?php echo base_url(); ?>frontend_asset/js/custom.js"></script>
<script>
var urls = "<?php echo base_url() ?>";
var freeTrialSubmit = function(){
     $.ajax({
            url: urls+'home/freetrials',
            type: 'POST',
            data: $("#freetrial").serialize(),
            dataType:'json',
            success: function (data, textStatus, jqXHR) {
                if(data.status == 1){
                    $("#errorMsg").html("");  
                    $("#successMsgs").html(data.message);
                    setTimeout(function(){ $("#free-trial").modal('hide'); }, 3000);
                }else{
                    $("#errorMsg").html(data.message);  
                }
            }
        });
}
</script>
</body>
</html>