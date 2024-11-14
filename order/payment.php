<?php
require_once("../auth/components/session.components.php");
require_once("../auth/components/main.components.php");
$site_data = site_data(); 
$baseurl = $site_data['protocol'].$site_data['baseurl'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?=$site_data['brand']?> Payments</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?=$site_data['logo']?>" type="image/*" />
	<link rel="stylesheet" href="<?=$baseurl?>/auth/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=$baseurl?>/auth/assets/css/ready.css">
	<link rel="stylesheet" href="<?=$baseurl?>/auth/assets/css/demo.css">
	<link rel="stylesheet" href="<?=$baseurl?>/auth/assets/css/payment.css?<?=time()?>">
	<script src="<?=$baseurl?>/auth/assets/js/payment.js?<?=time()?>"></script>
	<script src="<?=$baseurl?>/auth/assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="theme-color" content="#1976d2">
<meta name="msapplication-navbutton-color" content="#1976d2">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="#1976d2">
<link rel="stylesheet" href="https://file.objectsdata.com/common/upiwapv2/css/app.css">
<link rel="stylesheet" href="https://file.objectsdata.com/common/upiwapv2/css/style.css?v=1">
<link rel="stylesheet" href="https://file.objectsdata.com/common/upiwapv2/css/chunk-vendors.d6751c8d.css">
<style>
   
      
    .checkout-upi-box .chk-upi-option-group .chk-upi-option .noborder{
        border: none;
        border-left: 1px solid #e3eef6;
        border-right: 1px solid #e3eef6;
    }

    .checkout-upi-box .chk-upi-option-group .chk-upi-option .topborder{
        border-top: 1px solid #e3eef6;
    }

    .checkout-upi-box .chk-upi-option-group .chk-upi-option .bottompborder{
        border-bottom: 1px solid #e3eef6;
    }

    .checkbox-part{
        float: right;
        margin-right: 1rem;
    }
     
    .label-pay{
        font-size: 20px;
        width: 20px;
        height: 20px;
    }

    .click2pay{
        width: 100%;
        max-width: 375px;
        transform: translate(-50%, -50%);
        margin-left: 50%;
        left: 50%;
        position: fixed;
        bottom: -25px;
        height: 50px;
    }
    .checkout-bg{
        height: 160px;
    }

    .checkout-upi-box .chk-upi-option-group .chk-upi-option label {
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 10px;
        width: 100%;
        height: 45px;
        border: 1px solid #e3eef6;
        cursor: pointer;
    }
    .download-button {
            display: block;
            margin-top: 10px;
            text-align: center;
            background-color: #ff0; /* Yellow background color */
            border: none;
            border-radius: 20px; /* Rounded corners */
            padding: 10px 0px; /* Padding for button */
            color: #000; /* Black text color */
            text-decoration: none; /* Remove underline */
            cursor: pointer;
        }
        .download-button:hover {
            background-color: #e0e000; /* Darker yellow on hover */
        }
    .mt-3, .my-3 {
        margin-top: 0.1rem !important;
    }

    </style>
    </head>
<body class="noselect">
<noscript>
        <strong>Your browser does not support JavaScript, please enable JavaScript before paying</strong>
</noscript>

<?php
$payment_token = _get("payment_token");
$transaction = rechpay_fetch(rechpay_query("SELECT * FROM `transaction` WHERE payment_token='".$payment_token."' "));
if(count($transaction)>0 && $transaction['payment_token']==$payment_token){

$userAccount = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$transaction['user_id']."' ")); 
if($userAccount['user_id']>0){

if($transaction['status']=="Pending"){
rechpay_query("UPDATE `transaction` SET txn_mode='URL', domain='".getDomain($_SERVER['HTTP_REFERER'])."' WHERE txn_id='".$transaction['txn_id']."' ");     
$_SESSION['payment_token'] = $payment_token;
$merchant = rechpay_fetch(rechpay_query("SELECT * FROM `merchant` WHERE merchant_id='".$transaction['merchant_id']."' ")); 
if($merchant['merchant_id']>0 && $merchant['status']=="Active"){

if($transaction['merchant_name']=="PhonePe Business"){
$merchant_auth = get_phonepe_qrcode($merchant['merchant_session']);
}else if($merchant['merchant_name']=="Paytm Business"){   
$merchant_auth = get_paytm_qrcode($merchant['merchant_session'],$merchant['merchant_csrftoken']);	
}else if($transaction['merchant_name']=="SBI Merchant"){
$merchant_auth = get_sbimerchant_profile($merchant['merchant_username'],$merchant['merchant_session']);
}else{
$merchant_auth = array();    
}

if($merchant_auth['enabled']==true || (count($merchant_auth)>0 && !empty($merchant_auth['Mobile1'])) || ($merchant_auth['statusCode']=="200" && count($merchant_auth['response'])>0)){
    
$upiArr = array();
$upiArr['pa'] = $transaction['merchant_upi'];
$upiArr['pn'] = $userAccount['company'];
$upiArr['cu'] = "INR";
$upiArr['am'] = $transaction['txn_amount'];

if($transaction['merchant_name']=="PhonePe Business"){
$upiArr['mam'] = $transaction['txn_amount'] - 1;
}else if($transaction['merchant_name']=="Paytm Business"){
$upiArr['mam'] = $transaction['txn_amount'];
}else if($transaction['merchant_name']=="SBI Merchant"){
$upiArr['mam'] = $transaction['txn_amount'];
}

$upiArr['tr'] = $transaction['bank_orderid'];
$upiArr['tn'] = $transaction['txn_note'];
$upi = upi_qr_code("upi",$upiArr);   
$bhim = upi_qr_code("upi",$upiArr)['qrIntent'];
$phonepe = upi_qr_code("phonepe",$upiArr)['qrIntent'];
$paytm = upi_qr_code("paytmmp",$upiArr)['qrIntent'];
$gpay = upi_qr_code("tez",$upiArr)['qrIntent'];
?>

<script>
check_payment_status("<?=$baseurl?>","<?=$transaction['payment_token']?>");
</script>

<div id="app" class="d-flex justify-content-center bd-highlight mb-3">
<section class="w-100">
<div class="card card-custom card-stretch gutter-b nb-xs" style="box-shadow: rgb(214, 223, 230) 0px 3px 14px;">
<div id="loading" class="card-header border-0 p-0">
<div class="checkout-bg custom-background p-header-top-sub-container">

<div sytle="margin: 20px;" style="padding: 20px 15px 0 15px;height: 80px;display: flex;color: #fff;justify-content: space-between;">
<div style="display: flex;font-size: 12px;flex-direction: column;justify-content: center;text-align: left;">
<h6 style="font-weight: bold;">Amount Payable</h6>
<div>
<span style="font-size: 28px;margin-right: 2px;font-weight: bold;">INR</span>
<span style="font-size: 24px; margin-right: 2px;" id="amount"><?= $transaction['txn_amount'] ?>.00 </span>

</div>
</div> 
<div style="display: flex;flex-direction: column;justify-content: center;align-items: center;">
<div>
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAABYlAAAWJQFJUiTwAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAQ0SURBVHgB7Z0vcxsxEMWfOwWBgYGGhYGGgoGFgfkI/Qj5GIWBhYGFgYGBhYKBhmGpdiK3npv7I+3unRzf+814PGPfne709HTSntYGCCGEEEIIIYSQNbGBM+/v71fp7Qrnx5u8NptNhCNuAqSK36W3kF4XOG/26fWUhHiBAy4CpMoP+Kj8NSEiPMHIFxhJlX+J9VW+EHJ3a8IsANZZ+QduYMQkQG7911gv21QHWxj4ChsBemLqQx9KN04XKkJ/L9z8seYmmY4tx9U2pJBeD1CidoBD668dRVzOtK0QocfkAksXFGAjoo45BfgDGwFKVAI4tP7X1EXsK/eZTYB0LjLJitCjdoHWAQE2IuqZ0wFCExdUC+A08tFc7KkLoHKBxgEBNva18ZQsehW1++Qu8RU2AiqpEsCp9UfUo2nRmpjU4i6odUCAHU0QS1OZmjBBhJ1Qs3GxAE6tXxvO1VRmtWj53N5go8oFNQ4IsBOhQ+MATbcleISZQ+mGRQI4xny0fazGAVoBrPcBodgFpQ4I8EF7cUvdAwQZCVm7ISGUbDQpgGPrj3nGqWGpUdBhVmwdjgpFLihxQIAPqr41XYRUpKYyL/K+Gjy6ISFMbTAqgHO8P0KHti8XtAK4PO9FgQumHBDggyb4dsDykF91H3AIzh0Txr4cFOBEWr9gee5qcU+ED6MuGHNAgB8WS1sccAoCCGHoi14BnFu/BN8sowqLA9Ti5VmxttvsMuiCIQd4Vb4QYWPxe8ARXqMhYdv34ZAAFut2sY4oWoyCDngK0HsdHuuCRnFYS2kRwNqQPCZko8wuwGfGMHMvhgI0hgI0ZnYBNM9zPfY9lfKnWMIBt9Bj2fffMQxBuTvMzBICXKUKqF5FnHMOPDJt5BgBleTyz8IBwq7mOWleiBvgxy4fs7T8b87lD7LkTfg2X9goeRvzuvsebgrL36J8FbaZoeXpc0xApB8WEWRm/NQNT+cLv8Z8+QZT5UtXtZux/Nj3YW+OWL5p/cC8CXd7/A92XWKB/rZh+TKh+9n3TGQwSa8yIYKM8ztV/nPfF6NZkjn1dI7+eE2MZutMpqnmycgd6i0qdnvEh/1uV7r/r6lnIcV5wkdDw6kTkQIljPt8HMxa2f4vQ11Ol+pE7Txa2OYTuegUHKcUX/v+hBBCyAHzr6UMBLmiYSXcISzRHW1U55Z5kofj2+7n1p+tsf5UgdA3W5bxs+XE+mJCcryIdmzRf60mAfhIsjEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEUoDEeqyLusWI2m809DHg4IGK9RBjxEMC0LOOTY752swB5YdIaRXjx+C8xzz9yC/hIcpszr+wUkJyBZ4//EBNc/8owJ/fJ+vk5E95aIsstX5f4FRVCCCGEEEIIIeQ8+Qv+KYyvXyOfaAAAAABJRU5ErkJggg==" alt class="storeImg" style="width: 48px; height: 48px;">
</div>
<div style="display: flex;">
<div style="display: flex;align-items: center;font-size: 17px;font-weight: normal;top: 0px;color: rgb(255, 255, 255);margin-right: 2px;flex-direction: row;align-items: center;">
<span class="title-count-down mt-3" style="width: 100%; font-size: 15px; color: #fff;  text-align: center;">
        <span id="timeout"></span>
        
    </span>
</div>

</div>
</div>
</div>

</div>

<div class="template-header">
    <div class="card-body p-0 mb-50px nb-xs">
        <div class="text-left">
            <div class="text-left payment-methods-view-container">
                <div class="checkout-upi-box">
                    <div class="chk-upi-option d-flex justify-content-center" style="margin: 1.5rem 0;">
                        <label for="phonepe-upi" class="custom-border-bottom" style="height: auto; padding-right: 10px;">
                            <div id="upi_qr_container">
                                <h6 style="font-weight: bold; text-align: center;">QR Save, Scan & Pay With Any App</h6>
                                <img src="<?=$upi['qrCode']?>" width="300" style="max-width:100%;border-radius: 5px;">
<h6 style="font-weight: bold; text-align: center; color: red; font-size: 10px;">Do not use same QR code to pay multiple times..</h6>
<a href="<?=$upi['qrCode']?>" class="download-button btn btn-primary" style="padding: 5px 10px; font-size: 14px; font-weight: bold; color: white;" download="qr_code.png">SAVE QR</a>
                            </div>
                        </label>
                    </div>
                    
                      <div class="mb-2 text-center">
     <h6 style="font-weight: bold; text-align:start; font-size: 14px; color: orange;">1. Screenshot or Save QR</h6>
    <h6 style="font-weight: bold; text-align: start; font-size: 14px; color: orange;">2. Open Payment App</h6>
    <h6 style="font-weight: bold; text-align: start; font-size: 14px; color: orange;">3. Select Screenshot, Scan QR to Pay!</h6>
</div>

                    <div class="mb-2 text-center">
                        <!-- Cancel Button -->
                        <button class="btn btn-outline-danger btn-sm" onclick="history.back()">Cancel</button>

                        <!-- Powered by Bhim UPI -->
                        <div class="mb-4 mt-4">
                            <h6>Powered by</h6>
                            <img src="<?php $baseurl ?>/auth/assets/img/Bhim-Upi-Logo-PNG.png" alt="Bhim" height="20px" style="max-width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  
<?php if(isMobile() && $merchant['merchant_payupi']=="Show"){ ?>
<?php if(user_os()=="ios"){ ?>

<button class="btn btn-secondary-outline btn-app-logo" onclick="window.location.href = '<?=$phonepe?>' "><img src="<?=$baseurl?>/auth/assets/img/phonepe.png" alt="Pay with PhonePe"></button>
<button class="btn btn-secondary-outline btn-app-logo" onclick="window.location.href = '<?=$paytm?>' "><img src="<?=$baseurl?>/auth/assets/img/paytmbank.png" alt="Pay with Paytm"></button> 
<button class="btn btn-secondary-outline btn-app-logo" onclick="window.location.href = '<?=$gpay?>' "><img src="<?=$baseurl?>/auth/assets/img/gpay.png" alt="Pay with Google Pay"></button> 
<button class="btn btn-secondary-outline btn-app-logo" onclick="window.location.href = '<?=$bhim?>' "><img src="<?=$baseurl?>/auth/assets/img/bhim.png" alt="Pay with Bhim UPI"></button> 
<?php }else{ ?> 
<?php }?> 
<?php }?>
</div>
</div>
</div>
</div>
<script>
countdown("timeout",005,00,window.location.href);
</script>
<?php
}else{
transaction_failed($transaction,"UPI","Merchant Login Expired",$transaction['txn_id']);
redirect("",2000);    
?> 
<div class="col-md-4 card p-4">	
<div class="row">
<div class="col-md-12 text-center align-items-center pt-2">  
<div><h6><?=$userAccount['company']?><hr></h6><b>Merchant Login Expired</b></div>
<div class="text-center mt-4">
<img src="<?=$baseurl?>/auth/assets/img/loading-money.gif" alt="chck" width="60" style="max-width:100%">  
</div>
<div class="mb-4 mt-4">
<span class="text-center font-weight-normal">Transaction ID: <?=$transaction['txn_id']?></span></p> 
</div>
<div class="mb-2"><hr>
<small class="mb-4">Powered by</small><br>
<img src="<?=$baseurl?>/auth/assets/img/Bhim-Upi-Logo-PNG.png" alt="Bhim" height="20px" style="max-width:100%"> 
</div>
</div>
</div>
</div> 
<?php    
}

}else{
transaction_failed($transaction,"UPI","Merchant Not Active",$transaction['txn_id']);
redirect("",2000);
?> 
<div class="col-md-4 card p-4">	
<div class="row">
<div class="col-md-12 text-center align-items-center pt-2">  
<div><h6><?=$userAccount['company']?><hr></h6><b>Merchant Not Active</b></div>
<div class="text-center mt-4">
<img src="<?=$baseurl?>/auth/assets/img/loading-money.gif" alt="chck" width="60" style="max-width:100%">  
</div>
<div class="mb-4 mt-4">
<span class="text-center font-weight-normal">Transaction ID: <?=$transaction['txn_id']?></span></p> 
</div>
<div class="mb-2"><hr>
<small class="mb-4">Powered by</small><br>
<img src="<?=$baseurl?>/auth/assets/img/Bhim-Upi-Logo-PNG.png" alt="Bhim" height="20px" style="max-width:100%"> 
</div>
</div>
</div>
</div>    
<?php    
}

}else if($transaction['status']=="Success"){
?> 
<?php
if(empty($transaction['callback_url'])){
sdk_response($transaction['status'], $transaction['client_orderid'], $transaction['txn_id']);   
?>
<div class="col-md-4 card p-4">	
<div class="row">
<div class="col-md-12 text-center align-items-center pt-2">  
<div><h6><?=$userAccount['company']?><hr></h6>Payment Completed</b></div>
<div class="text-center mt-4">
<img src="<?=$baseurl?>/auth/assets/img/success-icon.svg" alt="chck" width="80" style="max-width:100%"> 
</div>
<div class="mb-4 mt-4">
<span class="text-center font-weight-normal">You have successfully paid ₹<?=$transaction['txn_amount']?><br>Paid Using: <?=$transaction['payment_mode']?><br>Transaction ID: <?=$transaction['txn_id']?></span></p> 
</div>
<div class="mb-2"><hr>
<small class="mb-4">Powered by</small><br>
<img src="<?=$baseurl?>/auth/assets/img/Bhim-Upi-Logo-PNG.png" alt="Bhim" height="20px" style="max-width:100%"> 
</div>
</div>
</div>
</div>
<?php
}else{
$InputArray = array();
$InputArray['status'] = true;
$InputArray['message'] = "Transaction Successfully"; 
$InputArray['order_id'] = $transaction['client_orderid']; 
form_create("POST",$transaction['callback_url'],$InputArray,2000,true);


?>
<div class="col-md-4 card p-4">	
<div class="row">
<div class="col-md-12 text-center align-items-center pt-2">  
<div><h6><?=$userAccount['company']?><hr></h6><b>Processing your payment...</b></div>
<div class="text-center mt-4">
<img src="<?=$baseurl?>/auth/assets/img/loading-money.gif" alt="chck" width="60" style="max-width:100%"> 
</div>
<div class="mb-4 mt-4">
<span class="text-center font-weight-normal">Please do not refresh the page because we are processing your payment.</span></p>  
</div>
<div class="mb-2"><hr>
<small class="mb-4">Powered by</small><br>
<img src="<?=$baseurl?>/auth/assets/img/Bhim-Upi-Logo-PNG.png" alt="Bhim" height="20px" style="max-width:100%"> 
</div>
</div>
</div>
</div>
<?php    
}
?>

<?php    
}else{
?> 


<?php
if(empty($transaction['callback_url'])){
sdk_response($transaction['status'], $transaction['client_orderid'], $transaction['txn_id']);    
?>
<div class="col-md-4 card p-4">	
<div class="row">
<div class="col-md-12 text-center align-items-center pt-2">  
<div><h6><?=$userAccount['company']?><hr></h6><b>Payment Failed</b></div>
<div class="text-center mt-4">
<img src="<?=$baseurl?>/auth/assets/img/failed-icon.svg" alt="chck" width="60" style="max-width:100%"> 
</div>
<div class="mb-4 mt-4">
<span class="text-center font-weight-normal">Transaction ID: <?=$transaction['txn_id']?></span></p> 
</div>
<div class="mb-2"><hr>
<small class="mb-4">Powered by</small><br>
<img src="<?=$baseurl?>/auth/assets/img/Bhim-Upi-Logo-PNG.png" alt="Bhim" height="20px" style="max-width:100%"> 
</div>
</div>
</div>
</div>
<?php
}else{
$InputArray = array();
$InputArray['status'] = false;
$InputArray['message'] = "Transaction Failed"; 
$InputArray['order_id'] = $transaction['client_orderid']; 
form_create("POST",$transaction['callback_url'],$InputArray,2000,true);
?>
<div class="col-md-4 card p-4">	
<div class="row">
<div class="col-md-12 text-center align-items-center pt-2">  
<div><h6><?=$userAccount['company']?><hr></h6><b>Processing your payment...</b></div>
<div class="text-center mt-4">
<img src="<?=$baseurl?>/auth/assets/img/loading-money.gif" alt="chck" width="60" style="max-width:100%"> 
</div>
<div class="mb-4 mt-4">
<span class="text-center font-weight-normal">Please do not refresh the page because we are processing your payment.</span></p>  
</div>
<div class="mb-2"><hr>
<small class="mb-4">Powered by</small><br>
<img src="<?=$baseurl?>/auth/assets/img/Bhim-Upi-Logo-PNG.png" alt="Bhim" height="20px" style="max-width:100%"> 
</div>
</div>
</div>
</div>
<?php    
}
?>

<?php   
}

}else{
transaction_failed($transaction,"UPI","Merchant Not Active",$transaction['txn_id']);
?>
<div class="col-md-4 card p-4">	
<div class="row">
<div class="col-md-12 text-center align-items-center">  
<img src="<?=$baseurl?>/auth/assets/img/unauthorized-blue.svg" width="200" style="max-width:100%">
<div class="mb-4">
<h5 class="f-20">Unauthorized Access</h5>
</div>
<div class="">
<button class="btn btn-outline-danger btn-sm" onclick="history.back()">Go Back</button>    
</div>
</div>
</div>
</div>
<?php    
}

}else{
sdk_error("Payment Link Not Found");     
?>
<div class="col-md-4 card p-4">	
<div class="row">
<div class="col-md-12 text-center align-items-center">  
<img src="<?=$baseurl?>/auth/assets/img/page-not-found-5-530376.webp" width="200" style="max-width:100%">
<div class="mb-4">
<h5 class="f-20">Payment Link Not Found.</h5>
</div>
<div class="">
<button class="btn btn-outline-danger btn-sm" onclick="history.back()">Go Back</button>    
</div>
</div>
</div>
</div>
<?php
}
?>

</div> 
</div>
</div>

<script>
    function openUpiIntent(url) {
        // You can perform additional actions if needed before opening the URL
        window.location.href = url; // This will navigate to the specified URL
    }
    
   

</script>
</body>
</html>