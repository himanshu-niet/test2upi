<title>Please do not refresh this page...</title>
<?php
require_once("components/main.components.php");


// Current URL start//
// Construct the base URL of the website
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$baseURL = $protocol . $host . "/order/status";
// current url end//


if(isset($_POST['order_id'])){
$order_id = $_POST['order_id'];
// API endpoint URL
$url = "$baseURL";
// JSON payload
$data = json_encode([
    "token" => "bc69c3-10b264-11bc6a-a200b4-e469fd",
    "order_id" => $order_id
]);

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data)
]);

// Execute cURL session
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);
$txn_date = $data['results']['txn_date'];
$order = $data['results']['order_id'];
$ord = explode("B",$order);
$plan_id = $ord[2];
$user_id = $ord[1];
$userData = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$user_id."' "));
if($userData['user_id']>0){
$planData = rechpay_fetch(rechpay_query("SELECT * FROM `plans` WHERE plan_id='".$plan_id."' "));
if($planData['plan_id']>0){

if($planData['type']=="1 Year"){
$expire_date = date("Y-m-d",strtotime("+12 month",strtotime($txn_date)));
}else if($planData['type']=="1 Month"){
$expire_date = date("Y-m-d",strtotime("+1 month",strtotime($txn_date)));	
}

$sql = "UPDATE `useraccount` SET plan_id='".$planData['plan_id']."', plan_type='".$planData['type']."', plan_limit='".$planData['limit']."', expire_date='".$expire_date."', is_expire='No' WHERE user_id='".$userData['user_id']."' ";
if(rechpay_query($sql)){
awal_alert_msg("Plan Activated Successfully","success");
}else{
awal_alert_msg("Server is Down","error");
}

}else{
awal_alert_msg("Plan Not Found","error");
}

}else{
awal_alert_msg("User Not Found","error");
}

}else{
awal_alert_msg("Payment Gateway Error","error");
}
echo '<br><br><center><h4 class="text-danger">Please do not refresh this page...</h4><br>
<img src="assets/img/loading.gif"></center>';
redirect("dashboard",2000);










if($_SERVER['REQUEST_METHOD'] === 'POST') {

// Paytm	
if(isset($_POST['ORDERID'])){
$CHECKSUMHASH = strip_tags($_POST['CHECKSUMHASH']);
$STATUS = safe_str($_POST['STATUS']);
$RESPMSG = safe_str($_POST['RESPMSG']);
$ORDERID = safe_str($_POST['ORDERID']);
$TXNAMOUNT = safe_str($_POST['TXNAMOUNT']);
$BANKTXNID = safe_str($_POST['BANKTXNID']);
$TXNID = safe_str($_POST['TXNID']);
require_once("components/encdec_paytm.php");
$paytm = gateway("paytm");
$isValidChecksum = verifychecksum_e($_POST, $paytm['key'], $CHECKSUMHASH);
if($isValidChecksum=="TRUE"){
if($STATUS=="TXN_SUCCESS"){
$TXNDATE = strip_tags($_POST['TXNDATE']);
$ord = explode("B",$ORDERID);
$user_id = $ord[1];
$plan_id = $ord[2];
$userData = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$user_id."' "));
if($userData['user_id']>0){
$planData = rechpay_fetch(rechpay_query("SELECT * FROM `plans` WHERE plan_id='".$plan_id."' "));
if($planData['plan_id']>0){

if($planData['type']=="1 Year"){
$expire_date = date("Y-m-d",strtotime("+12 month",strtotime($TXNDATE)));
}else if($planData['type']=="1 Month"){
$expire_date = date("Y-m-d",strtotime("+1 month",strtotime($TXNDATE)));	
}

$sql = "UPDATE `useraccount` SET plan_id='".$planData['plan_id']."', plan_type='".$planData['type']."', plan_limit='".$planData['limit']."', expire_date='".$expire_date."', is_expire='No' WHERE user_id='".$userData['user_id']."' ";
if(rechpay_query($sql)){
awal_alert_msg("Plan Activated Successfully","success");
}else{
awal_alert_msg("Server is Down","error");
}

}else{
awal_alert_msg("Plan Not Found","error");
}

}else{
awal_alert_msg("User Not Found","error");
}

}else{
awal_alert_msg($RESPMSG,"error");
}

}else{
awal_alert_msg("Payment Gateway Error","error");
}
echo '<br><br><center><h4 class="text-danger">Please do not refresh this page...</h4><br>
<img src="assets/img/loading.gif"></center>';
redirect("dashboard",2000);

}





// UpiApi
//if(isset($_POST['status']) && !empty($_POST['message']) && !empty($_POST['hash'])){
//if (isset($_POST['status']) && isset($_POST['message'])) {
//    $status = $_POST['status'];
//    $message = $_POST['message'];

//    echo "Status: $status<br>";
//    echo "Message: $message<br>";
    
//$status = safe_str($_POST['status']);
//$message = safe_str($_POST['message']);
//$hash = strip_tags($_POST['hash']);
//if($status==true){
//$upiapi = gateway("upiapi");
//$results = openssl_decrypt($hash,"AES-128-ECB",$upiapi['secret']);
//$results = json_decode($results,true);
//$txnStatus = strip_tags($results['txnStatus']);
//$orderId = strip_tags($results['orderId']);
//$txnAmount = safe_str($results['txnAmount']);
//$bankTxnId = safe_str($results['bankTxnId']);
//$txnId = safe_str($results['txnId']);	
//if($txnStatus=="COMPLETED"){
//$txnDate = strip_tags($results['txnDate']);
//$ord = explode("B",$orderId);
//$user_id = $ord[1];
//$plan_id = $ord[2];
//$userData = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$user_id."' "));
//if($userData['user_id']>0){
//$planData = rechpay_fetch(rechpay_query("SELECT * FROM `plans` WHERE plan_id='".$plan_id."' "));
//if($planData['plan_id']>0){

//if($planData['type']=="1 Year"){
//$expire_date = date("Y-m-d",strtotime("+12 month",strtotime($txnDate)));
//}else if($planData['type']=="1 Month"){
//$expire_date = date("Y-m-d",strtotime("+1 month",strtotime($txnDate)));	
//}

//$sql = "UPDATE `useraccount` SET plan_id='".$planData['plan_id']."', plan_type='".$planData['type']."', plan_limit='".$planData['limit']."', expire_date='".$expire_date."', is_expire='No' WHERE user_id='".$userData['user_id']."' ";
//if(rechpay_query($sql)){
//awal_alert_msg("Plan Activated Successfully","success");
//}else{
//awal_alert_msg("Server is Down","error");
//}

//}else{
//awal_alert_msg("Plan Not Found","error");
//}

//}else{
//awal_alert_msg("User Not Found","error");
//}

//}else{
//awal_alert_msg($message,"error");
//}

//}else{
//awal_alert_msg("Payment Gateway Error","error");
//}
//echo '<br><br><center><h4 class="text-danger">Please do not refresh this page...</h4><br>
//<img src="assets/img/loading.gif"></center>';
//redirect("dashboard",2000);

//}


}else{
awal_alert_msg("Unauthorized Access","error");
redirect("index",2000);
}