
<?php
// Merchant key here as provided by Payu
$MERCHANT_KEY = "JBZaLc";

// Merchant Salt as provided by Payu
$SALT = "GQs7yium";

// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://test.payu.in";

$action = '';

$posted = array ();
if (! empty ( $_POST )) {
	// print_r($_POST);
	foreach ( $_POST as $key => $value ) {
		$posted [$key] = $value;
	}
}

$formError = 0;

if (empty ( $posted ['txnid'] )) {
	// Generate random transaction id
	$txnid = substr ( hash ( 'sha256', mt_rand () . microtime () ), 0, 20 );
} else {
	$txnid = $posted ['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if (empty ( $posted ['hash'] ) && sizeof ( $posted ) > 0) {
	if (empty ( $posted ['key'] ) || empty ( $posted ['txnid'] ) || empty ( $posted ['amount'] ) || empty ( $posted ['firstname'] ) || empty ( $posted ['email'] ) || empty ( $posted ['phone'] ) || empty ( $posted ['productinfo'] ) || empty ( $posted ['surl'] ) || empty ( $posted ['furl'] ) || empty ( $posted ['service_provider'] )) {
		$formError = 1;
	} else {
		// $posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
		$hashVarsSeq = explode ( '|', $hashSequence );
		$hash_string = '';
		foreach ( $hashVarsSeq as $hash_var ) {
			$hash_string .= isset ( $posted [$hash_var] ) ? $posted [$hash_var] : '';
			$hash_string .= '|';
		}
		
		$hash_string .= $SALT;
		
		$hash = strtolower ( hash ( 'sha512', $hash_string ) );
		$action = $PAYU_BASE_URL . '/_payment';
	}
} elseif (! empty ( $posted ['hash'] )) {
	$hash = $posted ['hash'];
	$action = $PAYU_BASE_URL . '/_payment';
}
?>
<html>
<head>
<title><?php echo SITE_NAME;?> | Secure Checkout</title>
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
    <script src="<?php echo base_url(); ?>frontend_asset/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>frontend_asset/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>frontend_asset/js/plugin.js"></script>

<script src="<?php echo base_url(); ?>frontend_asset/js/slick.js"></script>

<script src="<?php echo base_url(); ?>frontend_asset/js/custom.js"></script>
<script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
</head>
<body onload="submitPayuForm()">
    <?php if($formError) { ?>
      <span style="color: red">Please fill all mandatory fields.</span>
	<br />
	<br />
    <?php } ?>
	<form action="<?php echo $action; ?>" method="post" name="payuForm">
		<input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
		<input type="hidden" name="hash" value="<?php echo $hash ?>" /> <input
			type="hidden" name="txnid" value="<?php echo $txnid ?>" />

		<div class="row">
			<div class="box col-md-12">
				<h2 class="purple">
					<i class="glyphicon glyphicon-check"></i> <?php echo SITE_NAME;?> With Secure Checkout
				</h2>
				<div class="tab-content">
					<div class="tab-pane fade in active" id="home">
						<br>
						<div class="row">
							<div class="col-md-10">
								<div class="panel well">
									<div class="panel panel-body">
										<div class="form-group col-md-3 ">
											<label>Package Name : </label> <span>
																<?php if(isset($package)){if($package){echo strtoupper($package[0]->plan_name);}}?>
																	 </span>
										</div>
										<div class="form-group col-md-3">
											<label>Package Duration : </label> <span>
																<?php if(isset($package)){if($package){echo $package[0]->plan_periods_month.' Months';}}?>
																	 </span>
										</div>
										<div class="form-group col-md-3">
											<label>Click Per Day : </label> <span>
																<?php if(isset($package)){if($package){echo $package[0]->click_day;}}?>
																	 </span>
										</div>
										<div class="clearfix"></div>
										<div class="row">
											<div class="form-group col-md-4">
												<label class="control-label" for="name">Name</label> <input
													class="form-control" name="firstname" id="firstname"
													value="<?php if(isset($userInfo) && $userInfo){echo (empty($userInfo['0']->first_name)) ? '' : $userInfo['0']->first_name.' '.$userInfo['0']->last_name ;}?>" />
											</div>


											<div class="form-group col-md-4">
												<label class="control-label" for="email">Email</label> <input
													class="form-control" name="email" id="email"
													value="<?php if(isset($user) && $user){echo (empty($user['0']->email)) ? '' : $user['0']->email ;}?>" />
											</div>

											<div class="clearfix"></div>
											<div class="form-group col-md-4">
												<label class="control-label" for="conatctno">Contact No</label>
												<input class="form-control" name="phone"
													value="<?php if(isset($userInfo) && $userInfo){echo (empty($userInfo['0']->mobile_no)) ? '' : $userInfo['0']->mobile_no ;}?>" />
											</div>


											<div class="form-group col-md-4">
												<label class="control-label" for="amount">Total Amount</label>
												<input class="form-control" name="amount" required
													value="<?php if(isset($package) && $package){echo (empty($package['0']->price)) ? '' : $package['0']->price ;}?>" />
											</div>
											<input type="hidden" name="productinfo"
												value="<?php if(isset($package) && $package){echo (empty($package['0']->aid)) ? '' : $package['0']->aid ;}?>">
											<input type="hidden" name="surl"
												value="<?php echo site_url('home/paySuccess');?>" size="64" />
											<input type="hidden" name="furl"
												value="<?php echo site_url('home/payFailed'); ?>" size="64" />
											<input type="hidden" name="curl"
												value="<?php echo site_url('home/buyPackages');?>" /> <input
												type="hidden" name="service_provider" value="payu_paisa"
												size="64" /> <input type="hidden" name="address1"
												value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" />

											<input type="hidden" name="address2"
												value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" />


											<input type="hidden" name="city"
												value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" />
											<input type="hidden" name="state"
												value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" />


											<input type="hidden" name="country"
												value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" />

											<input type="hidden" name="zipcode"
												value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" />


											<input type="hidden" name="udf1"
												value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" />

											<input type="hidden" name="udf2"
												value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" />


											<input type="hidden" name="udf3"
												value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" />

											<input type="hidden" name="udf4"
												value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" />


											<input type="hidden" name="udf5"
												value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" />

											<input type="hidden" name="pg"
												value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" />
											<input type="hidden" name="lastname" id="lastname"
												value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" />
										
					 <?php if(!$hash) { ?>

					 	<div class="form-group col-md-5 col-md-offset-4">
												<a class="btn btn-danger btn-lg"
													href="<?php echo site_url('home/buyPackages');?>">Back to
													Package</a> <button class="btn btn-warning btn-lg"
													type="submit" value="Secure CheckOut" /><i class="glyphicon glyphicon-check"></i> Secure CheckOut</button>
											</div>
           
        			  <?php } ?>
				</div>


									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</form>
</body>
</html>