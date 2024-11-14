<?php
require_once("components/main.components.php");
$site_data = site_data();
 $cron_token = "8e3dddea55e82e0970a0f428f74c2e8d";
//$cron_token = strip_tags($_GET['cron_token']);
//if($site_data['cron_token']==$cron_token){
if("8e3dddea55e82e0970a0f428f74c2e8d" === $cron_token){
    // $sql="SELECT * FROM `merchant` WHERE 1;";
 $merchant = rechpay_fetch_all(rechpay_query("SELECT * FROM `merchant` WHERE `merchant_name`='PhonePe Business' AND `status`='Active' "));
 

// print_r($merchant);
$results = array();
$output = array("status"=>true,"message"=>"Data Not Found","results"=>$results);
foreach ($merchant as $key => $value){
$merchant = json_decode($value['merchant_data'],true);
$response = get_phonepe_refresh($value['merchant_session'],$value['merchant_csrftoken'],$merchant['fingerprint'],$merchant['device_fingerprint'],$merchant['ip']);
if($response['expiresAt']>0){
$merchant_data =  array();  
$merchant_data['number'] = $merchant['number'];  
$merchant_data['userid'] = $merchant['userid'];    
$merchant_data['name'] = $merchant['name'];
$merchant_data['token'] = $response['token'];     
$merchant_data['refresh'] = $response['refreshToken'];     
$merchant_data['fingerprint'] = $merchant['fingerprint'];  
$merchant_data['device_fingerprint'] = $merchant['device_fingerprint'];  
$merchant_data['ip'] = $merchant['ip'];     
$merchant_data['groupData'] = $merchant['groupData']; ;  
$merchantData = json_encode($merchant_data); 
$sql = "UPDATE `merchant` SET `merchant_timestamp`='".current_timestamp()."', `merchant_session`='".$merchant_data['token']."', `merchant_csrftoken`='".$merchant_data['refresh']."', `merchant_data`='".$merchantData."', `status`='Active' WHERE merchant_id='".$value['merchant_id']."' ";	
if(rechpay_query($sql)){
$results[] = array("merchant_id"=>$value['merchant_id'],"user_id"=>$merchant_data['userid']);
}
}else{
if(rechpay_query("UPDATE `merchant` SET `status`='InActive' WHERE `merchant_id`='".$value['merchant_id']."' ")){
$results[] = array("merchant_id"=>$value['merchant_id'],"user_id"=>$merchant_data['userid']);
}	
}
}

if(count($results)>0){
$output = array("status"=>true,"message"=>"Updated Successfully","results"=>$results);
}

//header('Content-Type: application/json');
$data = json_encode($output);
echo $data; 
/*$url = 'https://wa.shop-king.in/api/user/v2/send_message_url';
    $clientId = 'eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsImNsaWVudF9pZCI6Im1ZTE9WRSJ9';
    $mobile = '916268267807';
    $text = '*Phone Pay Login Expired*';
    $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzA0ODkzNTQ2fQ.JRfDiLGh52EL4XYgy4pSsL63MbC5jZ4bdl2XgdOUrz0';

    $queryParams = http_build_query([
        'client_id' => $clientId,
        'mobile' => $mobile,
        'text' => $text,
        'token' => $token
    ]);

    $apiUrl = $url . '?' . $queryParams;

    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if ($data) {
        echo 'Response: ';
        print_r($data);
    } else {
        echo 'Error: Unable to retrieve data.';
    }*/
 
}else{
error_page("401 Unauthorized","The page you requested was Unauthorized");
}