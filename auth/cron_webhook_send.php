<?php
ini_set('display_errors', '0');         
ini_set("max_execution_time",600);
require_once("components/main.components.php");
$site_data = site_data();
$cron_token = "8e3dddea55e82e0970a0f428f74c2e8d";
//$cron_token = strip_tags($_GET['cron_token']);
//if($site_data['cron_token']==$cron_token){
if("8e3dddea55e82e0970a0f428f74c2e8d" === $cron_token){
$transactions = rechpay_fetch_all(rechpay_query("SELECT *, transaction.status as txn_status FROM `transaction` LEFT JOIN useraccount ON useraccount.user_id=transaction.user_id WHERE transaction.status!='Pending' and transaction.webhook_status='Pending' and useraccount.webhook_url!='' ORDER BY transaction.txn_id ASC LIMIT 25"));
$output = array("status"=>false,"message"=>"Data Not Found");
if(count($transactions)>0){
$results =  array();
foreach($transactions as $key => $value){

$webhookData = array(
    "txn_id" => $value['txn_id'],
    "order_id" => $value['client_orderid'],
    "merchant_id" => $value['merchant_id'],
    "merchant_name" => $value['merchant_name'],
    "merchant_vpa" => $value['merchant_upi'],
    "txn_date" => $value['txn_date'],
    "txn_amount" => $value['txn_amount'],
    "txn_note" => $value['txn_note'],
    "product_name" => $value['product_name'],
    "customer_name" => $value['customer_name'],
    "customer_mobile" => $value['customer_mobile'],
    "customer_email" => $value['customer_email'],
    "customer_vpa" => $value['customer_vpa'],
    "bank_orderid" => $value['bank_orderid'],
    "utr_number" => $value['utr_number'],
    "payment_mode" => $value['payment_mode'],
    "message" => $value['customer_vpa'],
    "status" => $value['txn_status'],
);
$http_code = 0;
if(!empty($value['webhook_url']) && filter_var($value['webhook_url'], FILTER_VALIDATE_URL)){
$http_code = send_post_webhook($value['webhook_url'],$webhookData,15);	
}
rechpay_query("UPDATE `transaction` SET webhook_status='Success' WHERE txn_id='".$value['txn_id']."' ");
$results[] = array("txn_id"=>$value['txn_id'],"http_code"=>$http_code);
}

$output = array("status"=>true,"message"=>"Webhook Send Successfully","results"=>$results);
}

header('Content-Type: application/json');
echo json_encode($output);
}else{
error_page("401 Unauthorized","The page you requested was Unauthorized");
}