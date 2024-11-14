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

						<h4 class="page-title">My Profile</h4>	
<?php
if(isset($_POST['update'])){
$mobile = safe_str($_POST['mobile']);	
$email = safe_str($_POST['email']);	
if(strlen($mobile)==10 && is_numeric($mobile)){
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
if(rechpay_query("UPDATE `useraccount` SET mobile='".$mobile."', email='".$email."' WHERE user_id='".$userAccount['user_id']."' ")){
$userAccount['mobile'] = $mobile;	
$userAccount['email'] = $email;		
alert_msg("Updated Successfully!",'success');
}else{
alert_msg("Server is down!",'info');
}
}else{
alert_msg("Email Address Not Valid!",'danger');
}
}else{
alert_msg("Mobile Number Not Valid!",'danger');
}
}
?>										
						<div class="row row-card-no-pd">							
							<div class="col-md-12">
								<form class="row mb-4" method="POST" action="">
								<div class="col-md-4 mb-3">
									<label>Username</label>
									<input type="text" placeholder="Username" value="<?=$userAccount['username']?>" class="form-control" readonly>
								</div>
								<div class="col-md-4 mb-3">
									<label>Mobile Number</label>
									<input type="text" name="mobile" placeholder="Mobile Number" value="<?=$userAccount['mobile']?>" class="form-control input-solid" required>
								</div>
								<div class="col-md-4 mb-3">
									<label>Email Address</label>
									<input type="text" name="email" placeholder="Email Address" value="<?=$userAccount['email']?>" class="form-control input-solid" required>
								</div>
								<div class="col-md-4 mb-3">
									<label>Name</label>
									<input type="text" placeholder="Name" value="<?=$userAccount['name']?>" class="form-control" readonly>
								</div>
								<div class="col-md-4 mb-3">
									<label>Company Name</label>
									<input type="text" placeholder="Company Name" value="<?=$userAccount['company']?>" class="form-control" readonly>
								</div>
								<div class="col-md-4 mb-3">
									<label>PAN Number</label>
									<input type="text" placeholder="PAN Number" value="<?=$userAccount['pan']?>" class="form-control" readonly>
								</div>
								<div class="col-md-4 mb-3">
									<label>Aadhaar Number</label>
									<input type="text" placeholder="Aadhaar Number" value="<?=$userAccount['aadhaar']?>" class="form-control" readonly>
								</div>
								<div class="col-md-8 mb-3">
									<label>Location</label>
									<input type="text" placeholder="Location" value="<?=$userAccount['location']?>" class="form-control" readonly>
								</div>
								<div class="col-md-4 mb-3">
									<button type="submit" name="update" class="btn btn-primary btn-block">Save</button>
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