<?php
require_once("../auth/components/session.components.php");
require_once("../auth/components/main.components.php");
$site_data = site_data(); 
$baseurl = $site_data['protocol'].$site_data['baseurl'];
$uid_token = $_SESSION['UID_TOKEN'];
$sql = "SELECT * FROM `useraccount` WHERE uid_token='".$uid_token."' ";	
$userAccount = rechpay_fetch(rechpay_query($sql));
if(empty($userAccount['user_id']) || !isset($uid_token) || empty($uid_token)){
session_destroy();	
header("location: index");
exit("Login Session is expired");
}

$txn_id = _get("txn_id");
if(isset($txn_id) && !empty($txn_id)){
$transaction = rechpay_fetch(rechpay_query("SELECT * FROM `transaction` WHERE txn_id='".$txn_id."' "));
if((count($transaction)>0 && $transaction['txn_id']==$txn_id && $transaction['user_id']==$userAccount['user_id']) || $userAccount['role']=="Admin"){	

$txn_date = date("d-M-Y",strtotime($transaction['txn_date']));
$user = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$transaction['user_id']."'"));	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Invoice No.<?=$transaction['txn_id']?></title>
	<link rel="stylesheet" type="text/css" href="<?=$baseurl?>/auth/assets/css/invoice.css?=<?=time()?>">
</head>
<body onload="window.print()">

<div class="wrapper">
	<div class="invoice_wrapper">
		<div class="header">
			<div class="logo_invoice_wrap">
				<div class="logo_sec">
					<div class="title_wrap">
						<p class="title bold"><?=$user['company']?></p>
						<p class="sub_title"><?=$user['location']?></p>
					</div>
				</div>
				<div class="invoice_sec">
					<p class="invoice bold">ORIGINAL INVOICE</p>
					<p class="invoice_no">
						<span class="bold">Invoice No:</span>
						<span>#<?=$transaction['txn_id']?></span>
					</p>
					<p class="date">
						<span class="bold">Invoice Date:</span>
						<span><?=$txn_date?></span>
					</p>
				</div>
			</div>
			<div class="bill_total_wrap">
				<div class="bill_sec">
					<p>Billed By</p> 
	          		<p class="bold name"><?=$user['company']?> (<?=$user['name']?>)</p>
			        <span><?=$user['location']?>
					<br>PAN : <?=$user['pan']?>
					<br>Mobile : <?=$user['mobile']?>
					<br>Email : <?=$user['email']?>
			        </span>
				</div>
				<div class="bill_sec">
					<p>Billed To</p>  
	          		<p class="bold name"><?=$transaction['customer_name']?></p>
					 Mobile : <?=$transaction['customer_mobile']?>
					<br>Email : <?=$transaction['customer_email']?>
					<br>Order ID : <?=$transaction['client_orderid']?>
					<br>VPA : <?=$transaction['customer_vpa']?>
			        </span>
				</div>
			</div>
		</div>
		<div class="body">
			<div class="main_table">
				<div class="table_header">
					<div class="row">
						<div class="col col_des">Products / Services Description</div>
						<div class="col col_total">Price</div>
					</div>
				</div>
				<div class="table_body">
					<div class="row">
						<div class="col col_des">
							<p class="bold"><?=$transaction['product_name']?></p>
							<p><?=$transaction['txn_note']?></p>
						</div>
						<div class="col col_total">
							<p>₹<?=$transaction['txn_amount']?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="paymethod_grandtotal_wrap">
				<div class="paymethod_sec">
					<p class="bold">Authorized Signature</p>
					<p><small>Merchant Reference No: <?=$transaction['bank_orderid']?></small></p>
				</div>
				<div class="grandtotal_sec">
			        <p class="bold mt-2">
			            <span>TOTAL AMOUNT</span>
			            <span>₹<?=$transaction['txn_amount']?></span>
			        </p>
			        <p class="bold mt-2">
			            <span>Payment Mode</span>
			            <span><?=$transaction['payment_mode']?></span>
			        </p>
			        <p class="bold mt-2">
			            <span>UTR Number</span>
			            <span><?=$transaction['utr_number']?></span>
			        </p>
			       	<p class="bold mt-2">
			            <span>Paid Status</span>
						<?php if($transaction['status']=="Success"){ ?>
			            <span>Paid</span>
						<?php } ?>
						<?php if($transaction['status']=="Failed"){ ?>
			            <span>Canceled</span>
						<?php } ?>
						<?php if($transaction['status']=="Pending"){ ?>
			            <span>Unpaid</span>
						<?php } ?>
			        </p>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="terms">
		        <p class="tc bold">Terms & Coditions</p>
		        <p>1. Please pay within 15 days from the date of invoice, overdue charges @ 14% will be charged on delayed payments.</p>
				<p>2. Please quote invoice number when remitting funds.</p>
				<p>3. Goods or Services once sold cannot be taken back or exchanged.</p>
				<p>4. Payments Amount Not Refundable.</p>
		    </div>
			
			<div class="enquiry text-center">
			 <p>For any enquiries, email us on <b><?=$user['email']?></b> or call us on <b><?=$user['mobile']?></b></p>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php
}else{
header("HTTP/1.0 404 Not Found");
exit();	
}

}else{
header("HTTP/1.0 404 Not Found");
exit();	
}
?>