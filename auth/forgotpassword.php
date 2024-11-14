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
  background: #f2f3f8 !important;
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
                  <img src="<?=$site_data['logo']?>" style="width: 185px;" alt="logo">
                  <h6 class="mt-4 mb-4 pb-1">Forgot Password</h6>
                </div>

<?php
if(isset($_POST['submit'])){
$username = safe_str($_POST['username']);
$pan = safe_str($_POST['pan']);
if(!empty($username) && !empty($pan)){
$sql = "SELECT * FROM `useraccount` WHERE (username='".$username."' || mobile='".$username."') and pan='".$pan."' ";  
$result = rechpay_fetch(rechpay_query($sql));
if($result['user_id']>0 && $result['pan']==$pan && $result['role']!="Admin"){
if($result['status']=="Active"){
$password = generateNumericOTP(8);
if(rechpay_query("UPDATE `useraccount` SET password='".$password."' WHERE user_id='".$result['user_id']."' ")){
$login = $site_data['protocol'].$site_data['baseurl']."/auth/index";
send_sms($result['mobile'],"Dear *{$result['name']}*\nYour New Password is : *{$password}*\nLogin : $login\nPlease Don't share this with any one.\n");
alert_msg("Password Has Been Successfully Sent to Your <b>WhatsApp Number</b>",'success');
}else{
alert_msg("Server is down",'info');
}


}else{
alert_msg("Your Account is inactive",'info');
}


}else{
alert_msg("Username OR PAN Number is incorrect",'danger');
}

}else{
alert_msg("Username OR PAN Number is empty",'danger');
}

}


?>


                <form method="POST" action="">
                  <div class="form-outline mb-4">
                    <label class="form-label" for="username">Mobile Number</label>
                    <input type="number" name="username" class="form-control" placeholder="Enter Mobile Number" onkeypress="if(this.value.length==10) return false;" required/>
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">PAN Number</label>
                    <input type="text" name="pan" class="form-control" placeholder="Enter PAN Number" onkeypress="if(this.value.length==10) return false;" required/>
                  </div>

                  <div class="text-center pt-1 mb-2 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" name="submit">Submit</button>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 mr-2">Already have an account?</p>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="location='index'">Login</button>
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