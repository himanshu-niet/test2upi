<?php
require_once("templates/header.php");
?>
<style type="text/css">
.form-control{
    color: #000 !important;
    font-weight: 600 !important;	
}	
label {
    font-weight: 600 !important;
}
</style>

			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">

						<h4 class="page-title">Api Documentation</h4>	
<?php
if(isset($_POST['get_api_token'])){
$token = api_token_gen();	
if(rechpay_query("UPDATE `useraccount` SET token='".$token."' WHERE user_id='".$userAccount['user_id']."' ")){
$userAccount['token'] = $token;	
alert_msg("Api Token Generate Successfully!",'success');
}else{
alert_msg("Server is down!",'info');
}
}
?>	

<?php
if(isset($_POST['update_webhook']) && !empty($_POST['webhook_url'])){
$webhook_url = strip_tags($_POST['webhook_url']);	
if(filter_var($webhook_url, FILTER_VALIDATE_URL)) {
if(rechpay_query("UPDATE `useraccount` SET webhook_url='".$webhook_url."' WHERE user_id='".$userAccount['user_id']."' ")){
$userAccount['webhook_url'] = $webhook_url;	
alert_msg("Webhook URL Update Successfully!",'success');
}else{
alert_msg("Server is down!",'info');
}
}else{
alert_msg("$webhook_url is not a valid URL",'danger');
}

}
?>
									
						<div class="row row-card-no-pd">							
							<div class="col-md-12">
								<form class="row mb-4" method="POST" action="">
								<div class="col-md-8 mb-2">
									<label>Api Token</label>
									<input type="text" placeholder="Click Generate Button for API Token" value="<?=$userAccount['token']?>" class="form-control" readonly>
								</div>
								<div class="col-md-4 mb-2">
									<label>&nbsp;</label>
									<button type="submit" name="get_api_token" class="btn btn-primary btn-block">Generate Api Token</button>
								</div>
							  </form>
							</div>		
							
							<div class="col-md-12">
								<form class="row mb-4" method="POST" action="">
								<div class="col-md-8 mb-2">
									<label>Webhook URL</label>
									<input type="url" name="webhook_url" placeholder="Enter Your Webhook URL" value="<?=$userAccount['webhook_url']?>" class="form-control" required>
									<b style="color:red">Note: URL must include protocol (http / https)</b>
								</div>
								<div class="col-md-4 mb-2">
									<label>&nbsp;</label>
									<button type="submit" name="update_webhook" class="btn btn-primary btn-block">Update URL</button>
								</div>
								<div class="col-md-12">
								    <h6 class="mb-3"><b>Post Request : (Form Data)</b></h6>
								    <div class="table-responsive">
								    <table class="table table-bordered table-sm">
								        <tr>
								            <th>txn_id</th>
								            <th>order_id</th>
								            <th>merchant_id</th>
								            <th>merchant_name</th>
								            <th>merchant_vpa</th>
								            <th>txn_date</th>
								            <th>txn_amount</th>
								            <th>txn_note</th>
								            <th>product_name</th>
								            <th>customer_name</th>
								            <th>customer_mobile</th>
								            <th>customer_email</th>
								            <th>customer_vpa</th>
								            <th>bank_orderid</th>
								            <th>utr_number</th>
								            <th>payment_mode</th>
								            <th>message</th>
								            <th>status</th>
								        </tr>
								        <tr>
								            <th>85548511</th>
								            <th>ORDS073319032036</th>
								            <th>10</th>
								            <th>SBI Merchant</th>
								            <th>OXXXXXX0000@sbi</th>
								            <th>2023-05-10 17:55:20</th>
								            <th>15</th>
								            <th>Pay For ShopKing</th>
								            <th>Redmi 7</th>
								            <th>Priyanshu Janghel</th>
								            <th>7389572257</th>
								            <th>customer@gmail.com</th>
								            <th>customer@sbi</th>
								            <th>IT23051017552064734296</th>
								            <th>349626059899</th>
								            <th>UPI</th>
								            <th>Transaction Details</th>
								            <th>Success|Failed|Pending</th>
								        </tr>
								    </table>
								    </div>
								</div>
							  </form>
							</div>

							<div class="col-md-12 mb-4"><hr></div>

							<div class="col-md-12">
								<h6 class="mb-3"><b>Create Order API</b></h6>
								<form class="row mb-4" method="POST" action="">
								<div class="col-md-12 mb-2">
									<label>URL</label>
									<input type="text" placeholder="URL" value="<?=$site_data['protocol']?><?=$site_data['baseurl']?>/order/create" class="form-control" readonly>
									<b style="color:red">Order Timeout 30 Minutes. Order Will Be Automatically Failed After 30 Minutes.</b>
								</div>
								<div class="col-md-12 mb-2">
									<label>Post Data (JSON)</label>
									<textarea type="text" placeholder="Post Data (Parameter)" class="form-control" style="height: 140px;" readonly>{
    "token": "46009f-743816-5e9d7c-4ac051-b85d13",
    "order_id": "ORDS073319032036",
    "txn_amount": 5,
    "txn_note": "Pay For ShopKing Infotech",
    "product_name": "Redmi Note 12 Pro",
    "customer_name": "Priyanshu ",
    "customer_mobile": "9000000000",
    "customer_email": "customer@gmail.com",
    "callback_url": "https://your-domain/callback.php"
}</textarea> 
								</div>
								<div class="col-md-6 mb-2">
									<label>Success Response</label>
									<textarea type="text" placeholder="Success Response" class="form-control" style="height: 140px;" readonly>{
    "status": true,
    "message": "Order Created Successfully",
    "results": {
        "txn_id": 85548511,
        "payment_url": "<?=$site_data['protocol']?><?=$site_data['baseurl']?>/order/payment/c9f0f895fb9",
        "upi_intent": {
            "bhim": "upi://pay?pa=XXXXXXXXXX@sbi",
            "phonepe": "phonepe://pay?pa=XXXXXXXXXX@sbi",
            "paytm": "paytmmp://pay?pa=XXXXXXXXXX@sbi",
            "gpay": "tez://pay?pa=XXXXXXXXXX@sbi",
        }
    }
}</textarea> 
								</div>
								<div class="col-md-6 mb-2">
									<label>Failed Response</label>
									<textarea type="text" placeholder="Failed Response" class="form-control" style="height: 140px;" readonly>{
    "status": false,
    "message": "Parameter Missing OR Invalid",
    "results": []
}</textarea> 
								</div>
							  </form>
							</div>

							<div class="col-md-12 mb-4"><hr></div>

							<div class="col-md-12">
								<h6 class="mb-3"><b>Check Order Status API</b></h6>
								<form class="row mb-4" method="POST" action="">
								<div class="col-md-12 mb-2">
									<label>URL</label>
									<input type="text" placeholder="URL" value="<?=$site_data['protocol']?><?=$site_data['baseurl']?>/order/status" class="form-control" readonly>
								</div>
								<div class="col-md-12 mb-2">
									<label>Post Data (JSON)</label>
									<textarea type="text" placeholder="Post Data (Parameter)" class="form-control" style="height: 120px;" readonly>{
    "token": "46009f-743816-5e9d7c-4ac051-b85d13",
    "order_id": "ORDS073319032053"
}</textarea> 
								</div>
								<div class="col-md-6 mb-2">
									<label>Success Response</label>
									<textarea type="text" placeholder="Success Response" class="form-control" style="height: 140px;" readonly>{
    "status": true,
    "message": "Transaction Details",
    "results": {
        "txn_id": 85548511,
        "order_id": "ORDS073319032036",
        "merchant_id": 9,
        "merchant_name": "SBI Merchant",
        "merchant_vpa": "HSBIMOPAD.YMXXXXX-0XXXXXX0000@sbi",
        "txn_date": "2023-05-10 17:55:20",
        "txn_amount": 15,
        "txn_note": "Pay For RechPay Infotech",
        "product_name": "Redmi Note 12 Pro",
        "customer_name": "EBRAN SEKH",
        "customer_mobile": 9000000000,
        "customer_email": "customer@gmail.com",
        "customer_vpa": "customer@sbi",
        "bank_orderid": "IT23051017552064734296",
        "utr_number": 349626059899,
        "payment_mode": "UPI",
        "status": "Success"
    }
}</textarea> 
								</div>
								<div class="col-md-6 mb-2">
									<label>Failed Response</label>
									<textarea type="text" placeholder="Failed Response" class="form-control" style="height: 140px;" readonly>{
    "status": false,
    "message": "OrderID Not Found",
    "results": []
}</textarea> 
								</div>
							  </form>
							  
								<h6 class="mb-3"><b>Sample Intrigation Codes</b></h6>
								
								<button type="submit" name="" class="btn btn-primary btn-block">
    <a href="https://shopkiing.com/intrigation/pg-shopking-intrigation-sample.zip" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: none;">
        Download PHP Sample Code
    </a>
</button>

							<button type="submit" name="" class="btn btn-primary btn-block">
    <a href="https://shopkiing.com/intrigation/PGShopKing-Android-SDK-1.0.zip" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: none;">
        Download Android SDK
    </a>
</button>

							<button type="submit" name="" class="btn btn-primary btn-block">
    <a href="https://shopkiing.com/intrigation/PGShopKing_WooCommerce_V1.0.0_Plugin.zip" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: none;">
        Download Wocommerce Plugin
    </a>
</button>

							</div>


						</div>
					</div>
				</div>
<?php
require_once("templates/footer.php");
?>