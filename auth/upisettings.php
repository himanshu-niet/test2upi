<?php
require_once("templates/header.php");


?>

			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">UPI Settings</h4>
						<div class="row row-card-no-pd">
							<div class="col-md-12">
							<form method="POST" action="" class="mb-4">
<?php
if(isset($_POST['addmerchant']) && !empty($_POST['merchant_name']) && !empty($_POST['merchant_username'])){
$merchant_name = safe_str($_POST['merchant_name']);    
$merchant_username = safe_str($_POST['merchant_username']);
$merchant_password = strip_tags($_POST['merchant_password']);
if(in_array($merchant_name,['PhonePe Business','Paytm Business','SBI Merchant'])){
$old_merchant = rechpay_fetch_all(rechpay_query("SELECT * FROM `merchant` WHERE user_id='".$userAccount['user_id']."' and merchant_username='".$merchant_username."' "));
if(count($old_merchant)== 0){
if(in_array($userAccount['is_expire'],['No','Alert'])){
if(count(merchant_accounts($userAccount))<$user_plan_data['account_limit'] || $userAccount['role']=="Admin"){
$sql = "INSERT INTO `merchant`(`merchant_name`, `merchant_username`, `merchant_password`, `merchant_timestamp`, `merchant_session`, `merchant_csrftoken`, `merchant_token`, `user_id`, `status`) VALUES ('".$merchant_name."','".$merchant_username."','".$merchant_password."','".current_timestamp()."','','','','".$userAccount['user_id']."','InActive')";	
if(rechpay_query($sql)){
alert_msg("Merchant Added Successfully !",'success');
}else{
alert_msg("Server is Down!",'danger');
}
	
}else{
alert_msg("Added Account Limit Not Available!",'danger');
}

}else{
alert_msg("No Active Plan Available!",'danger');
}

}else{
alert_msg("Merchant Already Exists!",'danger');
}

}else{
alert_msg("Merchant Is Not Valid!",'danger');
}

}
?>

<?php
if(isset($_POST['delete']) && !empty($_POST['merchant_id'])){
$merchant_id = safe_str($_POST['merchant_id']);
if($merchant_id>0 && is_numeric($merchant_id)){
$old_merchant = rechpay_fetch(rechpay_query("SELECT * FROM `merchant` WHERE user_id='".$userAccount['user_id']."' and merchant_id='".$merchant_id."' "));
if($old_merchant['merchant_id']==$merchant_id){
$sql = "DELETE FROM `merchant` WHERE user_id='".$userAccount['user_id']."' and merchant_id='".$old_merchant['merchant_id']."' ";	
if(rechpay_query($sql)){
alert_msg("Merchant Delete Successfully!",'success');
}else{
alert_msg("Server is Down!",'danger');
}
	
}else{
alert_msg("Merchant Is Not Available!",'danger');
}

}else{
alert_msg("Merchant Is Not Valid!",'danger');
}

}
?>
			
								<div class="row" id="merchant">
								    <div class="col-md-4 mb-2">
    									<label>Merchant Name</label>
    									<select type="number" name="merchant_name" class="form-control" onchange="get_merchant(this.value,'#merchant')" required>
    									    <option value="PhonePe Business">PhonePe Business</option>
    									    <option value="Paytm Business">Paytm Business</option>
    									    <option value="SBI Merchant">SBI Merchant</option>
    									</select>
    								</div>
    								<div class="col-md-4 mb-2"> 
        								<label>Mobile Number</label> 
        								<input type="number" name="merchant_username" placeholder="Enter Mobile Number" class="form-control" onkeypress="if(this.value.length==10) return false;" required=""> 
    								</div>
    								<div class="col-md-4 mb-2"> 
        								<label>&nbsp;</label> 
        								<button type="submit" name="addmerchant" class="btn btn-primary btn-block">Add Merchant</button> 
        							</div>
								</div>
								
							</form>	
							<div class="table-responsive">
								<table class="table table-sm table-hover table-bordered table-head-bg-primary" id="dataTable" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>User ID</th>
												<th>Merchant</th>
												<th>Username</th>
												<th>Last Sync</th>
												<th>Status</th>
												<th>Primary</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
							<?php 
							 $sl = 1;
							 foreach (merchant_accounts($userAccount) as $key => $value) {
							 	$user = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$value['user_id']."'"));

							 	$status = '<span class="badge badge-danger" title="OTP Not Verified">InActive</span>';
							 	if($value['status']=="Active"){
							 	$status = '<span class="badge badge-success" title="OTP Verified">Verified</span>';
							 	}
							 	
							 	$primary_status = '<span class="badge badge-danger" title="InActive">InActive</span>';
							 	if($value['merchant_primary']=="Active"){
							 	$primary_status = '<span class="badge badge-success" title="Active">Active</span>';
							 	}
							?>				
										<tr class="<?=$primary?>">
											<th scope="row"><?=$sl?></th>
											<td><?=$user['username']?></td>
											<td><?=$value['merchant_name']?></td>
											<td><?=$value['merchant_username']?></td>
											<td><?=ucwords(_ago(strtotime($value['merchant_timestamp'])))?> Ago | <?=date("d-M-Y h:i:s A",strtotime($value['merchant_timestamp']))?></td>
											<td><?=$status?></td>
											<td><?=$primary_status?></td>
											<td>
												<button class="btn btn-danger btn-xs mb-2 mt-1" title="Delete" onclick="delete_merchant('<?=$value['merchant_id']?>')">Delete</button>
												<button class="btn btn-info btn-xs mb-2 mt-1" title="Verify" onclick="get_merchant_otp('<?=$value['merchant_id']?>')">Verify</button>
												<button class="btn btn-success btn-xs mb-2 mt-1" title="View" onclick="get_merchant_view('<?=$value['merchant_id']?>')">View</button>
											</td>
										</tr>
							<?php
							$sl++;}
							?>				
											
										</tbody>
									</table>
							</div>
							</div>
						</div>
					</div>
				</div>
<?php
require_once("templates/footer.php");
?>
<?php data_table();?>
<script src="assets/js/merchant.js?<?=time()?>"></script>