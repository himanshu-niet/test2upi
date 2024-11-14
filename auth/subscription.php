<?php
require_once("templates/header.php");
?>

			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Subscription & Plans</h4>
<?php
if(isset($_POST['paytm']) && !empty($_POST['plan_id'])){
$plan_id = safe_str($_POST['plan_id']);
$result = rechpay_fetch(rechpay_query("SELECT * FROM `plans` WHERE status='Active' and plan_id='".$plan_id."' "));
if($result['plan_id']>0 && $result['plan_id']==$plan_id){
require_once("components/encdec_paytm.php");
$paytm = gateway("paytm");
$paramList = array();
$paramList["MID"] = $paytm['mid'];
$paramList["ORDER_ID"] = order_txn_id().'B'.$userAccount['user_id'].'B'.$result['plan_id'];
$paramList["CUST_ID"] = $userAccount['username'];
$paramList["INDUSTRY_TYPE_ID"] = 'Retail';
$paramList["CHANNEL_ID"] = 'WEB';
$paramList["TXN_AMOUNT"] = $result['amount'];
$paramList["WEBSITE"] = "DEFAULT";
//$paramList["PAYMENT_MODE_ONLY"] = "YES";
//$paramList["PAYMENT_TYPE_ID"] = "UPI";
$paramList["CALLBACK_URL"] = $site_data['protocol'].$_SERVER['SERVER_NAME']."/auth/thankyou";
$paramList["MSISDN"] = $userAccount['mobile'];;
$paramList["EMAIL"] = $userAccount['email'];
$paramList["VERIFIED_BY"] = "EMAIL"; 
$paramList["IS_USER_VERIFIED"] = "YES"; 
$checkSum = getChecksumFromArray($paramList,$paytm['key']);
?>
<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
	<center><h4 class="text-danger">Please do not refresh this page...</h4></center>
		<form method="post" action="https://securegw.paytm.in/order/process" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
		 document.f1.submit();
		</script>
	</form>
</body>
</html>
<?php
exit();
}else{
alert_msg("Plan Not Found",'danger');
}

}
?>						

<?php
if(isset($_POST['upiapi']) && !empty($_POST['plan_id'])){
$plan_id = safe_str($_POST['plan_id']);
$result = rechpay_fetch(rechpay_query("SELECT * FROM `plans` WHERE status='Active' and plan_id='".$plan_id."' "));
if($result['plan_id']>0 && $result['plan_id']==$plan_id){
$upiapi = gateway("upiapi");
$postData = json_encode([
"token"=>$upiapi['token'],
"order_id"=>order_txn_id().'B'.$userAccount['user_id'].'B'.$result['plan_id'],
"txn_amount"=>$result['amount'],
"txn_note"=>$result['name']." For ".$result['type'],
"product_name"=>"Subscription",
"customer_name"=>$userAccount['name'],
"customer_email"=>$userAccount['email'],
"customer_mobile"=>$userAccount['mobile'],
"callback_url"=>$site_data['protocol'].$_SERVER['SERVER_NAME']."/auth/thankyou"
]);

// Current URL start//
// Construct the base URL of the website
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$baseURL = $protocol . $host . "/order/create";
// current url end//


$response = curl_request("POST","$baseURL",$postData);
// $response = curl_request("POST","https://imb.org.in/order/create",$postData);
$response = json_decode($response,true);
if($response['status'] == "true"){
//redirect($response['result']['payment_url'],0);
redirect($response['results']['payment_url'],0);
exit("Please do not refresh this page...");	
}else{
alert_msg($response['message'],'danger');	
}

}else{
alert_msg("Plan Not Found",'danger');
}

}
?>


<?php
alert_msg("<b>Note:</b> Your old plan will be automatically deactivated after purchasing the new plan and is non-refundable.",'danger');
?>
						<div class="row">							
							<?php 
							 foreach (all_plan_data() as $key => $value) {
							?>				
							<div class="col-md-3">
								<div class="card text-center">
									<div class="card-header">
										<h4 class="card-title"><?=$value['name']?></h4>
										<h2 class="text-center">₹<?=$value['amount']?></h2>
										<p class="card-category"><?=$value['type']?></p>
									</div>
									<div class="card-body">
										<div class="mb-2 text-primary">
											<b style="font-weight:700;font-size:1rem;"><?=$value['limit']?> Transactions</b></div>
										<table class="mx-auto">
										<tbody>
										    <tr>
										        <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
										        <td><p>0 Transaction Fee</p></td>
										    </tr>
										    <tr>
										        <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
										        <td><p>Realtime Transaction</p></td>
										    </tr>
										    <tr>
										        <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
										        <td><p>No Amount Limit</p></td>
										    </tr>
										    <tr>
										        <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
										        <td><p><?=$value['account_limit']?> Merchant Account</p></td>
										    </tr>
										    <tr>
										        <td><i class="icon-md text-danger me-2" data-feather="x"></i></td>
										        <td><p>Dynamic QR Code</p></td>
										    </tr>
										    <tr>
										        <td><i class="icon-md text-danger me-2" data-feather="x"></i></td>
										        <td><p>Direct UPI Intent</p></td>
										    </tr>
										    <tr>
										        <td><i class="icon-md text-danger me-2" data-feather="x"></i></td>
										        <td><p>Pay via UPI Feature</p></td>
										    </tr>
										    <tr>
										        <td><i class="icon-md text-danger me-2" data-feather="x"></i></td>
										        <td><p>Accept All UPI Apps</p></td>
										    </tr>
										    <tr>
										        <td><i class="icon-md text-primary me-2" data-feather="check"></i></td>
										        <td><p>24*7 WhatsApp Support</p></td>
										    </tr>
										</tbody>
										</table>
									</div>
									<div class="card-footer">
										<form method="POST" action="">
											<input type="hidden" name="plan_id" value="<?=$value['plan_id']?>">
											<!--button name="paytm" class="btn btn-outline-success btn-block">Buy Now</button-->
											<button name="upiapi" class="btn btn-outline-primary btn-block">Buy Now</button>
										</form>
									</div>
								</div>
							</div>			
							<?php } ?>		
						</div>
					</div>
				</div>
<?php
require_once("templates/footer.php");
?>
<?php data_table();?>
<script src="assets/js/bharatpe.js?<?=time()?>"></script>