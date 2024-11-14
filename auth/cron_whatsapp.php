
<?php

require_once("components/main.components.php");

//$merchants = rechpay_fetch_all(rechpay_query("SELECT * FROM `useraccount` WHERE `status`='Active' "));

$merchants = rechpay_fetch_all(rechpay_query("SELECT * FROM `useraccount` WHERE `status`='Active' "));
 
foreach ($merchants as $merchant) {
   $mobileJSON = $merchant['mobile'];
   $nameJSON  = $merchant['company'];
   $passwordJSON = $merchant['password'];
   $login ="https://pg.shopkiing.com/";
 

   
   
   
       

$accessToken = 'EAAVNkJEQwPUBO2gODZCyH7cQnGL4FAm1wRcu0yhiVB2P1ZBJ7VIxf8cC1ohOY7g7Fz1hlqXw22xO7ZBTDBRg2ypsts9N1QDrmZA2ADJYXtr9HBeCmFK5dAeAuu3njlm71DaysqrkgY7Lk5y30W02AZADz9WKjX5yodzNyZBNZByQOKNin18pI0zvMWILpm4F4ykhSXEWBeam3g1JPPUyaIZD';

$url = 'https://graph.facebook.com/v17.0/159548383917860/messages';
$mobile = '91'.$mobileJSON; // Replace with your actual mobile number

$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
);

$body = '*Dear Merchant ' . $nameJSON . '* Your Merchant '. "\n" .'Login Expired ON Monday'. "\n" .'```Please Again Verify Your Merchants```';
//$body = '*Dear Merchant ' . $nameJSON . '* Your Login Credentials' . "\n" .
       // '👤 Username is: *' . $mobileJSON . '*' . "\n" .
     //   '🔒 Password is: *' . $passwordJSON . '*' . "\n" .
     //   '🔗 Login URL: ' . $login . "\n" .
     //   '⚠️ Please do not share this with anyone.';
        
        //$body = "*Welcome to PG SHOPKING!* 🎉💳.\nSelect your merchants like: ```Phone pe , Paytm, SBI```, create an account, obtain API credentials, integrate SDK/API, set up webhooks, test transactions in a secure sandbox, and go live confidently. Monitor, optimize, and //celebrate //success!\n*🔗 Login Now!*:- https://pg.shopkiing.com\n\n🌟 Happy Today! 🛒";

$data = array(
    'messaging_product' => 'whatsapp',
    'recipient_type' => 'individual',
    'to' => '919302724103',
    'type' => 'text',
    'text' => array(
        'preview_url' => true,
        'body' => $body
    )
);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}

curl_close($ch);

echo 'Response: ' . $response;

}
   

   ?> 
