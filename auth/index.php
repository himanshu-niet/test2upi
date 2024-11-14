<?php
require_once("components/session.components.php");
require_once("components/main.components.php");
$site_data = site_data();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?=$site_data['title']?></title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?=$site_data['logo']?>" type="image/*" />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="assets/css/ready.css">
	<link rel="stylesheet" href="assets/css/demo.css">
	<link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <script type="text/javascript">if(window.history.replaceState){window.history.replaceState(null,null,window.location.href);}</script>
</head>
<style>
body{
  font-family: 'Inter', sans-serif;
  background: #555e66 !important;
}

a{
 text-decoration: none !important;
}	
.card {
    border-radius: 5px !important;
}
</style>
<body>
<!-- Modal -->
<div class="modal fade" id="disclaimer" tabindex="-1" aria-labelledby="Disclaimer" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Disclaimer">❗ Disclaimer</h5>
      </div>
      <div class="modal-body">
		  <p>The <?=$site_data['brand']?> does not provide any payment gateway services, UPI accounts, or UPI merchant accounts.</p>
		  <p>We only provide an API to generate a QR code for your UPI ID.</p>
		  <p>We are not involved in any kind of transaction. Please read our terms and conditions before using our service.</p>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" onclick="$('body').html('');">Leave</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
      </div>
    </div>
  </div>
</div> 

<div class="container">

<section class="h-100 ">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-6">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-12">
              <div class="card-body p-md-5 mx-md-4">

               <div class="text-center">
                   <h1><?=$site_data['brand']?>  <style>
        h1 {
            font-weight: bold;
            color: pink;
            text-shadow: 2px 2px 2px black;
        }

       
        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 24px; /* Adjust the font size for smaller screens */
            }
        }
    </style></h1>
   <!-- <img src="<?=$site_data['logo']?>" style="width: 185px;" alt="logo"> -->
  <h6 class="mt-4 mb-4 pb-1">Welcome back, please login to your account.</h6> 
</div>


<?php
if(isset($_POST['submit'])){
$username = safe_str($_POST['username']);
$password = safe_str($_POST['password']);
if(!empty($username) && !empty($password)){
$sql = "SELECT * FROM `useraccount` WHERE (username='".$username."' || mobile='".$username."') and password='".$password."' ";	
$result = rechpay_fetch(rechpay_query($sql));
if($result['user_id']>0 && $result['password']==$password){
if($result['status']=="Active"){
$uid_token = base64_encode($result['user_id'].":".$result['username']);	
if(rechpay_query("UPDATE `useraccount` SET uid_token='".$uid_token."' WHERE user_id='".$result['user_id']."' ")){
$_SESSION['UID_TOKEN'] = $uid_token;
/* $url = 'https://wa.shop-king.in/api/user/v2/send_message_url';
//$clientId = 'eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsImNsaWVudF9pZCI6Im1ZTE9WRSJ9';
$mobile = '91'.$username;

// Get the current time
$currentTime = date('Y-m-d H:i:s');

$text = '*Logged Successful On this Time:* ' . $currentTime . "\n" .
         '⚠️ Please do not share this with anyone.';
$clientId = 'eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsImNsaWVudF9pZCI6ImhlbGxvdyJ9';
$token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzA0OTYwNzQ1fQ.8_tViPmjFcj3WIOU9FyTPzO2wsZ9BAFLVxPN736-aYQ';
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
}

$currentTime = date('Y-m-d H:i:s');
$accessToken = 'EAAVNkJEQwPUBO4hEQSz0vsNFRR8gbOmOYCJSMeEkdVZBARYLhICIOeYpvImu1GsiXzdMr1jThDKDgJ1wwGgzWR9P11QwFyxJZBO8JaZANQwKb3rxputZC3EJVAf9Q2UEVwMkBq70bZBa4AZCR0WcGVDrrFUL7NLj97ZBQyTb0ZCtIchxzqlppLN2uinZCkkCXezUiUi5YhB7PEgyHDDi2oGUZD';

$url = 'https://graph.facebook.com/v17.0/159548383917860/messages';
$mobile = '91'.$username;

$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
);

$data = array(
    'messaging_product' => 'whatsapp',
    'recipient_type' => 'individual',
    'to' => $mobile,
    'type' => 'text',
    'text' => array(
        'preview_url' => false,
        'body' => '*Logged Successful On this Time:* ' . $currentTime . "\n" .
         '⚠️ Please do not share this with anyone.'
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
*/


 
redirect("dashboard",0);
exit();
}else{
alert_msg("Server is down",'info');
}


}else{
alert_msg("Your Account is inactive",'info');
}


}else{
alert_msg("Username OR Password is incorrect",'danger');
}

}else{
alert_msg("Username OR Password is empty",'danger');
}

}
?>


             <form method="POST" action="">
                  <div class="form-outline mb-4">
                    <label class="form-label" for="username">Mobile Number</label>
                    <input type="number" name="username" class="form-control" placeholder="Mobile Number" onkeypress="if(this.value.length==10) return false;" required/>
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required/>
                  </div>

                  <div class="text-center pt-1 mb-2 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" name="submit">Login</button>
                    <a class="text-muted" href="forgotpassword">Forgot password?</a>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 mr-2">Don't have an account?</p>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="location='register'">Register</button>
                  </div>
                  
             <div>      <!-- WhatsApp button -->
        <a href="https://wa.me/911234567890" target="_blank" class="btn btn-success btn-block fa-lg gradient-custom-2 mb-3">
            <i class="fab fa-whatsapp"></i> Contact us on WhatsApp
        </a>
    </div>

                </form>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</div>
</body>
<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>
<script>
$( document ).ready(function() {
$('#disclaimer').modal({backdrop: 'static', keyboard: false})  
$("#disclaimer").modal("show");
});
</script>
</html>			
