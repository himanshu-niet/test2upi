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
/* Light mode styles  */
/*body {
    background: #f2f3f8 !important;
    color: #000;
} */

/* Dark mode styles
.dark-mode {
    background: #1a1a1a !important;
    color: #fff;
} */

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
      <div class="col-xl-10">
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
                  <h6 class="mt-1 mb-4 pb-1">Start with your free account today</h6>
                  
    
                </div>
<?php
if(isset($_POST['create']) 
//&& !empty($_POST['username'])
&& !empty($_POST['password'])
&& !empty($_POST['mobile'])
&& !empty($_POST['email'])
&& !empty($_POST['name'])
&& !empty($_POST['company'])
&& !empty($_POST['pan'])
&& !empty($_POST['aadhaar'])
&& !empty($_POST['location'])
){
    
 /* function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+';
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $password .= $characters[$index];
    }

    return $password;
} */ 

$username = safe_str($_POST['mobile']);
$password = safe_str($_POST['password']);
$mobile = safe_str($_POST['mobile']);
$email = safe_str($_POST['email']);
$name = safe_str($_POST['name']);
$company = safe_str($_POST['company']);
$pan = safe_str($_POST['pan']);
$aadhaar = safe_str($_POST['aadhaar']);
$location = safe_str($_POST['location']);
$role = safe_str("User");
$status = safe_str("Active");

$old_useraccount = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE username='".$username."' "));
if(count($old_useraccount)==0){

if(strlen($username)==10 && is_numeric($username)){
if(strlen($mobile)==10 && is_numeric($mobile)){
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
if(strlen($aadhaar)==12 && is_numeric($aadhaar)){
if(strlen($pan)==10){
if(in_array($status,["Active","InActive"])){
if(in_array($role,["Admin","User"])){ 

$planData = all_plan_data()[0];
$plan_id = $planData['plan_id'];
$plan_type = $planData['type'];
$plan_limit = $planData['limit'];
$expire_date = date("Y-m-d",strtotime("+0 day"));
$is_expire = "Yes";

$sql = "INSERT INTO `useraccount`(`role`, `username`, `password`, `uid_token`, `mobile`, `email`, `name`, `company`, `pan`, `aadhaar`, `location`, `plan_id`, `plan_type`, `plan_limit`, `expire_date`, `is_expire`, `token`, `create_date`, `status`) VALUES ('".$role."','".$username."','".$password."','".$password."','".$mobile."','".$email."','".$name."','".$company."','".$pan."','".$aadhaar."','".$location."','".$plan_id."','".$plan_type."','".$plan_limit."','".$expire_date."','".$is_expire."','".api_token_gen()."','".current_timestamp()."','Active')";  
if(rechpay_query($sql)){
$login = $site_data['protocol'].$site_data['baseurl']."/auth/index";  
//send_sms($mobile,"Dear {$name}\nYour Login Credentials\nUsername is: *{$username}*\nPassword is: *{$password}*\nLogin : $login\nPlease do not share this with anyone.\n");  


   /* $url = 'https://wa.shop-king.in/api/user/v2/send_message_url';
    $clientId = 'eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsImNsaWVudF9pZCI6ImhlbGxvdyJ9';
    $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzA0OTYwNzQ1fQ.8_tViPmjFcj3WIOU9FyTPzO2wsZ9BAFLVxPN736-aYQ';
    $mobile = '91'.$mobile;
    $text = '*Dear Merchant ' . $name . '* Your Login Credentials' . "\n" .
        '👤 Username is: *' . $username . '*' . "\n" .
        '🔒 Password is: *' . $password . '*' . "\n" .
        '🔗 Login URL: ' . $login . "\n" .
        '⚠️ Please do not share this with anyone.';
   // $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzA0ODkzNTQ2fQ.JRfDiLGh52EL4XYgy4pSsL63MbC5jZ4bdl2XgdOUrz0';

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


$accessToken = 'EAAVNkJEQwPUBO4hEQSz0vsNFRR8gbOmOYCJSMeEkdVZBARYLhICIOeYpvImu1GsiXzdMr1jThDKDgJ1wwGgzWR9P11QwFyxJZBO8JaZANQwKb3rxputZC3EJVAf9Q2UEVwMkBq70bZBa4AZCR0WcGVDrrFUL7NLj97ZBQyTb0ZCtIchxzqlppLN2uinZCkkCXezUiUi5YhB7PEgyHDDi2oGUZD';

$url = 'https://graph.facebook.com/v17.0/159548383917860/messages';
$mobile = '91'.$mobile; // Replace with your actual mobile number

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
        'preview_url' => true,
        'body' => '*Dear Merchant ' . $name . '* Your Login Credentials' . "\n" .
        '👤 Username is: *' . $username . '*' . "\n" .
        '🔒 Password is: *' . $password . '*' . "\n" .
        '🔗 Login URL: ' . $login . "\n" .
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

//echo 'Response: ' . $response;
*/





alert_msg("User Account Create Successfully!",'success');
}else{
alert_msg("Server is down!",'danger');
}

}else{
alert_msg("Role Not Valid!",'danger');
}

}else{
alert_msg("Status Not Valid!",'danger');
}

}else{
alert_msg("PAN Number Not Valid!",'danger');
}

}else{
alert_msg("Aadhaar Number Not Valid!",'danger');
}

}else{
alert_msg("Email Address Not Valid!",'danger');
}

}else{
alert_msg("Mobile Number Not Valid!",'danger');
}

}else{
alert_msg("Username Not Valid!",'danger');
}

}else{
alert_msg("Username Already Exists!",'danger');
}


}
?>  
                <form class="row mb-4" method="POST" action="">
    <!--<div class="col-md-6 mb-2"><label>Username</label> <input type="number" name="username" placeholder="Enter Username" class="form-control" onkeypress="if(this.value.length==10) return false;" required="" /></div>-->
    <div class="col-md-6 mb-2"><label>Password</label> <input type="text" name="password" placeholder="Enter Password" class="form-control" required="" /></div>
    <div class="col-md-6 mb-2"><label>Whatsapp Number</label> <input type="number" name="mobile" placeholder="Enter Whatsapp Number" class="form-control" onkeypress="if(this.value.length==10) return false;" required="" /></div>
    <div class="col-md-6 mb-2"><label>Email Address</label> <input type="text" name="email" placeholder="Enter Email Address" class="form-control" required="" /></div>
    <div class="col-md-6 mb-2"><label>Name</label> <input type="text" name="name" placeholder="Enter Name" class="form-control" required="" /></div>
    <div class="col-md-6 mb-2"><label>Company</label> <input type="text" name="company" placeholder="Enter Company" class="form-control" required="" /></div>
    <div class="col-md-6 mb-2"><label>PAN Number</label> <input type="text" name="pan" placeholder="Enter PAN Number" class="form-control" onkeypress="if(this.value.length==10) return false;" required="" /></div>
    <div class="col-md-6 mb-2">
        <label>Aadhaar Number</label> <input type="number" name="aadhaar" placeholder="Enter Aadhaar Number" class="form-control" onkeypress="if(this.value.length==12) return false;" required="" />
    </div>
    <div class="col-md-12 mb-2"><label>Location</label> <input type="text" name="location" placeholder="Enter Location" class="form-control" required="" /></div>
    <div class="col-md-12 mb-2 mt-2"><button type="submit" name="create" class="btn btn-primary btn-sm btn-block">Register</button>
    </div>
<div class="col-md-12 mb-2">
<div class="d-flex align-items-center justify-content-center mt-2">
  <p class="mb-0 mr-2">Already have an account?</p>
  <a href='index' class="btn btn-outline-danger btn-sm" >Login</a>
</div>

    <!-- WhatsApp button -->
        <a href="https://wa.me/911234567890" target="_blank" class="btn btn-success btn-block fa-lg gradient-custom-2 mb-3">
            <i class="fab fa-whatsapp"></i> Contact us on WhatsApp
        </a>
        <div>  
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