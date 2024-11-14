<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
require_once("components/session.components.php");
require_once("components/main.components.php");
$site_data = site_data();
$uid_token = $_SESSION['UID_TOKEN'];
$sql = "SELECT * FROM `useraccount` WHERE uid_token='".$uid_token."' ";	
$userAccount = rechpay_fetch(rechpay_query($sql));
if(empty($userAccount['user_id']) || !isset($uid_token) || empty($uid_token)){
session_destroy();	
header("location: index");
exit("Login Session is expired");
}

if(isset($_POST['search']) && !empty($_POST['from_date']) && !empty($_POST['to_date']) ){
$from_date = date("Y-m-d", strtotime($_POST['from_date']));	
$to_date = date("Y-m-d", strtotime($_POST['to_date']));	
$search_input = safe_str($_POST['search_input']);
$utr_number = safe_str($_POST['utr_number']);
$sql = "SELECT * FROM `transaction` WHERE user_id='".$userAccount['user_id']."' and txn_date>='".$from_date." 00:00:00' and txn_date<='".$to_date." 23:59:59' ";   
if($userAccount['role']=="Admin"){
$sql = "SELECT * FROM `transaction` WHERE txn_date>='".$from_date." 00:00:00' and txn_date<='".$to_date." 23:59:59' ";
}

if(!empty($search_input)){
$sql .= "AND CONCAT(`txn_id`,`client_orderid`,`utr_number`) LIKE '%$search_input%' ";
}

if(!empty($utr_number)){
$sql .= "AND utr_number='".$utr_number."' ";
}


$sql .="ORDER BY `txn_id` DESC";

$result = rechpay_fetch_all(rechpay_query($sql));
$results = array();
foreach($result as $value){
$user = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$value['user_id']."'"));	
$transactionData = json_encode(array(
"txn_id" => $value['txn_id'],
"merchant_id" => $value['merchant_id'],
"merchant_name" => $value['merchant_name'],
"merchant_upi" => $value['merchant_upi'],
"client_orderid" => $value['client_orderid'],
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
"status" => $value['status']
));

$value['invoice_id'] = $value['txn_id'];
$value['username']	= $user['username'];
$value['txn_id']	= '<b><span class="badge badge-primary"><a class="text-white" href="javascript:void(0)" onclick="get_txn_details(\''.base64_encode($transactionData).'\')"><i class="la la-shekel"></i> '.$value['txn_id'].'</a></span></b>';
$value['txn_date']	= date("d-M-Y h:i:s A",strtotime($value['txn_date']));
$value['customer_name']	= strtoupper($value['customer_name']);

$results[] = $value;
}
header('Content-Type: application/json');
echo json_encode($results);
}


}


