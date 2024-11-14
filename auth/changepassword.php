<?php
require_once("templates/header.php");
?>
<style type="text/css">
.form-control{
    color: #000 !important;
    font-weight: 600 !important;	
}	
label {
    font-weight: 600 !important;
}
</style>

			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">

						<h4 class="page-title">Change Password</h4>	
<?php
if(isset($_POST['update'])){
$current_password = strip_tags($_POST['current_password']);	
$new_password = strip_tags($_POST['new_password']);	
$confirm_password = strip_tags($_POST['confirm_password']);
if($current_password==$userAccount['password']){
if($new_password==$confirm_password){
if(rechpay_query("UPDATE `useraccount` SET password='".$new_password."' WHERE user_id='".$userAccount['user_id']."' ")){
$userAccount['token'] = $token;	
alert_msg("Password Change Successfully!",'success');
}else{
alert_msg("Server is down!",'info');
}
}else{
alert_msg("Confirm Password Not Match!",'danger');
}
}else{
alert_msg("Current Password Not Valid!",'danger');
}
}
?>										
						<div class="row row-card-no-pd">							
							<div class="col-md-12">
								<form class="row mb-4" method="POST" action="">
								<div class="col-md-4 mb-3">
									<label>Current Password</label>
									<input type="password" name="current_password" placeholder="Current Password" class="form-control" required>
								</div>
								<div class="col-md-4 mb-3">
									<label>New Password</label>
									<input type="password" name="new_password" placeholder="New Password" class="form-control" required>
								</div>
								<div class="col-md-4 mb-3">
									<label>Confirm Password</label>
									<input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" required>
								</div>
								<div class="col-md-4 mb-3">
									<button type="submit" name="update" class="btn btn-primary btn-block">Change Password</button>
								</div>

							  </form>
							</div>
						</div>
					</div>
				</div>
<?php
require_once("templates/footer.php");
?>
<?php data_table();?>
<script src="assets/js/bharatpe.js?<?=time()?>"></script>