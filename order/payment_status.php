<?php
require_once("../auth/components/session.components.php");
require_once("../auth/components/main.components.php");
$output = array("status"=>"FAILED","message"=>"Unauthorized Access");
if($_SERVER['REQUEST_METHOD'] === 'POST') {
$payment_token = $_SESSION['payment_token'];
$transaction = rechpay_fetch(rechpay_query("SELECT * FROM `transaction` WHERE payment_token='".$payment_token."' "));
if(count($transaction)>0 && $transaction['payment_token']==$payment_token){

if($transaction['status']=="Pending"){
    
$merchant = rechpay_fetch(rechpay_query("SELECT * FROM `merchant` WHERE merchant_id='".$transaction['merchant_id']."' ")); 
if($merchant['merchant_id']>0 && $merchant['status']=="Active"){

if($transaction['merchant_name']=="PhonePe Business"){
$merchant_data = json_decode($merchant['merchant_data'],true);    
$txn_response = get_phonepe_transaction($merchant['merchant_session'],$merchant_data['fingerprint'],$merchant_data['device_fingerprint'],$merchant_data['ip'],$transaction['bank_orderid']);
if($txn_response['success']==true && $txn_response['data']['paymentState']=="COMPLETED"){
$payment_mode = $txn_response['data']['paymentApp']['displayText']=="Wallet"? "WALLET" : "UPI";     
$utr_number = empty($txn_response['data']['utr'])? $txn_response['data']['transactionId'] : $txn_response['data']['utr']; 
$customer_vpa = empty($txn_response['data']['vpa'])? $txn_response['data']['customerDetails']['userName'] : $txn_response['data']['vpa'];
$txn_amount = $txn_response['data']['amount'] / 100;
if(transaction_success($transaction,$payment_mode,$customer_vpa,$utr_number,$txn_amount)){
$output = array("status"=>'SUCCESS', "message"=>"Transaction Successfully");   
}else{
$output = array("status"=>'FAILED', "message"=>'Server Error');     
}

}else if($txn_response['success']==true && in_array($txn_response['data']['paymentState'],array("ERRORED","CANCELLED","FAILED"))){
$payment_mode = $txn_response['data']['paymentApp']['displayText']=="Wallet"? "WALLET" : "UPI";     
$utr_number = empty($txn_response['data']['utr'])? $txn_response['data']['transactionId'] : $txn_response['data']['utr']; 
$customer_vpa = empty($txn_response['data']['vpa'])? $txn_response['data']['customerDetails']['userName'] : $txn_response['data']['vpa'];
if(transaction_failed($transaction,$payment_mode,$customer_vpa,$utr_number)){
$output = array("status"=>'FAILED', "message"=>"Transaction Failed");   
}else{
$output = array("status"=>'FAILED', "message"=>'Server Error');     
}    
}else if(strtotime("-30 minutes")>strtotime($transaction['txn_date'])) {
if(transaction_failed($transaction,"UPI","Transaction Timeout",$transaction['txn_id'])){
$output = array("status"=>'FAILED', "message"=>"Transaction Failed");   
}else{
$output = array("status"=>'FAILED', "message"=>'Server Error');     
}    
}else{
$output = array("status"=>'PENDING', "message"=>'Transaction Pending');     
}


}else if($transaction['merchant_name']=="Paytm Business"){	
$transaction_response = get_paytm_transaction($merchant['merchant_session'],$merchant['merchant_csrftoken'],$transaction['bank_orderid']);
$txn_response = $transaction_response['orderList'][0]; 
if($txn_response['orderStatus']=="SUCCESS" && $txn_response['merchantTransId']==$transaction['bank_orderid']){
$data = json_decode($txn_response['extendInfo'],true,JSON_UNESCAPED_SLASHES);	
$orderInfo = json_decode($data['ORDER_CREATE_EXTEND_INFO'],true);
$payment_mode = $txn_response['payMethod']=="UPI" ? "UPI" : "WALLET";
$utr_number = json_decode($data['FLUXNET_EXTEND_INFO'],true)['referenceNo'];
$utr_number = empty($utr_number) ? $txn_response['bizOrderId'] : $utr_number;
$customer_vpa = empty($orderInfo['virtualPaymentAddr']) ? $orderInfo['payerName'] : $orderInfo['virtualPaymentAddr'];
$txn_amount = $txn_response['payMoneyAmount']['value'] / 100;
if(transaction_success($transaction,$payment_mode,$customer_vpa,$utr_number,$txn_amount)){
$output = array("status"=>'SUCCESS', "message"=>"Transaction Successfully");   
}else{
$output = array("status"=>'FAILED', "message"=>'Server Error');     
}

}else if(in_array($txn_response['orderStatus'],array("ERRORED","CANCELLED","FAILED","FAILURE"))){
$data = json_decode($txn_response['extendInfo'],true,JSON_UNESCAPED_SLASHES);	
$orderInfo = json_decode($data['ORDER_CREATE_EXTEND_INFO'],true);
$payment_mode = $txn_response['payMethod']=="UPI" ? "UPI" : "WALLET";
$utr_number = json_decode($data['FLUXNET_EXTEND_INFO'],true)['referenceNo'];
$utr_number = empty($utr_number) ? $txn_response['bizOrderId'] : $utr_number;
$customer_vpa = empty($orderInfo['virtualPaymentAddr']) ? $orderInfo['payerName'] : $orderInfo['virtualPaymentAddr'];
$txn_amount = $txn_response['payMoneyAmount']['value'] / 100;
if(transaction_failed($transaction,$payment_mode,$customer_vpa,$utr_number)){
$output = array("status"=>'FAILED', "message"=>"Transaction Failed");   
}else{
$output = array("status"=>'FAILED', "message"=>'Server Error');     
}    
}else if(strtotime("-30 minutes")>strtotime($transaction['txn_date'])){
if(transaction_failed($transaction,"UPI","Transaction Timeout",$transaction['txn_id'])){
$output = array("status"=>'FAILED', "message"=>"Transaction Failed");   
}else{
$output = array("status"=>'FAILED', "message"=>'Server Error');     
}    
}else{
$output = array("status"=>'PENDING', "message"=>'Transaction Pending');     
}


}else if($transaction['merchant_name']=="SBI Merchant"){
$txn_response = get_sbimerchant_transaction($merchant['merchant_username'],$merchant['merchant_csrftoken'],$merchant['merchant_session'],$transaction['bank_orderid']);
if($txn_response['Transaction_Status']=="Paid" && $txn_response['Invoice_Number']==$transaction['bank_orderid']){
$payment_mode = "UPI";     
$utr_number = $txn_response['RRN'];
$customer_vpa = $txn_response['Auth_Code'];
$txn_amount = $txn_response['Transaction_Amount'];
if(transaction_success($transaction,$payment_mode,$customer_vpa,$utr_number,$txn_amount)){
$output = array("status"=>'SUCCESS', "message"=>"Transaction Successfully");   
}else{
$output = array("status"=>'FAILED', "message"=>'Server Error');     
}

}else if(strtotime("-30 minutes")>strtotime($transaction['txn_date'])) {
if(transaction_failed($transaction,"UPI","Transaction Timeout",$transaction['txn_id'])){
$output = array("status"=>'FAILED', "message"=>"Transaction Failed");   
}else{
$output = array("status"=>'FAILED', "message"=>'Server Error');     
}    
}else{
$output = array("status"=>'PENDING', "message"=>'Transaction Pending');   
}


}else{
$output = array("status"=>'FAILED', "message"=>'Merchant Not Found');   
}

}else{
$output = array("status"=>'FAILED', "message"=>'Merchant Not Active');
}

}else if($transaction['status']=="Success"){
$output = array("status"=>'SUCCESS', "message"=>"Transaction Successfully"); 
}else{
$output = array("status"=>'FAILED', "message"=>'Duplicate Request');
}

}else{
$output = array("status"=>"FAILED","message"=>"Transaction Not Found");    
}

}

header('Content-Type: application/json');
echo json_encode($output,JSON_NUMERIC_CHECK);
?>