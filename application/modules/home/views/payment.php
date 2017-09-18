<style>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    border-top: 0px solid #ddd !important;
    }
    .text-bold{font-weight: 900; font-color:#000000;}
</style>
<?php
// Merchant key here as provided by Payu
$MERCHANT_KEY = "kqbDlKMh";

// Merchant Salt as provided by Payu
$SALT = "3bEsI15gjM";

// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://test.payu.in";

$action = '';

$posted = array();
if (!empty($_POST)) {
    //print_r($_POST);
    foreach ($_POST as $key => $value) {
        $posted[$key] = $value;
    }
}

$formError = 0;

if (empty($posted['txnid'])) {
    // Generate random transaction id
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
    $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if (empty($posted['hash']) && sizeof($posted) > 0) {
    if (
            empty($posted['key']) || empty($posted['txnid']) || empty($posted['amount']) || empty($posted['firstname']) || empty($posted['email']) || empty($posted['phone']) || empty($posted['productinfo']) || empty($posted['surl']) || empty($posted['furl']) || empty($posted['service_provider'])
    ) {
        $formError = 1;
    } else {
        //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach ($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }

        $hash_string .= $SALT;


        $hash = strtolower(hash('sha512', $hash_string));
        $action = $PAYU_BASE_URL . '/_payment';
    }
} elseif (!empty($posted['hash'])) {
    $hash = $posted['hash'];
    $action = $PAYU_BASE_URL . '/_payment';
}
?>
<script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
        if (hash == '') {
            return;
        }
        var payuForm = document.forms.payuForm;
        payuForm.submit();
    }
</script>
<body onload="submitPayuForm()">
    <!--Main container sec start-->
    <div class="main_container">
        <section class="innerpage_banner">
            <img src="<?php echo base_url(); ?>frontend_asset/images/about_banner.jpg" class="img-responsive">
            <div class="innr_bnr_cap">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="inr_banner_head"><?php echo SITE_NAME; ?> With Secure Checkout</h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="bredcrumb_main">
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="active">Pay Now</li>
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
                            <h2>Payment Customer Details</h2>
                        </div>
                        <div class="row">
                            <div class="box col-md-8 col-md-offset-2 ">
                                <div class="panel panel-info bounceInDown colorpicker-color zoomIn">
                                     <div class="panel-heading">Equity Reasearch With Secure Checkout</div>
                                     <div class="panel-body">
                        <form action="<?php echo $action; ?>" method="post" name="payuForm">
                            <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                            <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                            <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                            
                            <table class="table table-responsive table-condensed table-hover">
                                <tr>
                                    <td colspan="6"><?php if ($formError) { ?>

        <span class="text-danger">Please fill all mandatory fields.</span>
            <br/>
            <br/>
<?php } ?></td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Amount *: </td>
                                    <td><input class="form-control" required="" placeholder="Amount" name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" /></td>
                                    
                                </tr>
                                <tr><td class="text-bold">Full Name *: </td>
                                    <td><input class="form-control" required="" placeholder="Name" name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" /></td></tr>
                                <tr>
                                        <tr><td class="text-bold">Service: </td>
                                    <td> <input type="text" class="form-control"  placeholder="Service" name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" /></td></tr>
                                    <td class="text-bold">Email *: </td>
                                    <td><input class="form-control" type="email" required="" placeholder="Email" name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" /></td>
                                  
                                </tr>
                                <tr>
                                      <td class="text-bold">Phone *: </td>
                                    <td><input class="form-control" required="" placeholder="Phone" name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" /></td>
                                </tr>
                                <tr> <td class="text-bold">City: </td>
                                    <td><input type="text" placeholder="City" class="form-control" name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" /></td></tr>
                                <tr><td class="text-bold">Pincode: </td>
                                    <td><input type="text" class="form-control"  placeholder="Pincode" name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" /></td></tr>
                                <tr><td class="text-bold"> <input type="checkbox" checked="" size="64"  required=""/> </td>
                                    <td>I accept all your terms and conditions...</td></tr>
                                <tr>
                                    <td colspan="6"><input type="hidden" name="service_provider" value="payu_paisa" size="64" />
                                        <input type="hidden" name="productinfo" value="1" size="64" />
                                        <input type="hidden" name="furl" value="<?php echo site_url('home/payFailed'); ?>" size="64" />
                                        <input type="hidden" name="surl" value="<?php echo site_url('home/paySuccess'); ?>" size="64" />
                                        <input type="hidden" name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" />
                                        <input type="hidden" name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" />
                                        <input type="hidden" name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" />
                                        
                                        <input type="hidden" name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" />
                                        <input type="hidden" name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" />
                                        
                                        <input type="hidden" name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" />
                                        <input type="hidden" name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" />
                                        <input type="hidden" name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" />
                                        <input type="hidden" name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" />
                                        <input type="hidden" name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" />
                                        <input type="hidden" name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" />
                                        <input type="hidden" name="curl" value="<?php echo site_url('home/payFailed'); ?>" />
                                    </td>
                                </tr>
                            </table>
                                  <div class='form-row'>
              <div class='form-group card required'>
                  <div class="col-md-offset-9">
                      <?php if (!$hash) { ?>
                                            <img src="<?php echo base_url(); ?>frontend_asset/images/payumoney_logo.png" class="img-responsive">    <br>   <input class="btn btn-warning btn-lg" type="submit" value="Pay Now" />
                  <?php } ?></div>
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
        </section>

    </div>
    <!--Main container sec end-->
</body>