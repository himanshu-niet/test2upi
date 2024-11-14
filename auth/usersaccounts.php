<?php
require_once("templates/header.php");
if($userAccount['role']=="Admin"){
$today_transactions = today_transactions($userAccount);
?>

			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Users Accounts</h4>
						<div class="row row-card-no-pd">
							<div class="col-md-12">
<?php
if(isset($_POST['delete']) && !empty($_POST['user_id'])){
$user_id = safe_str($_POST['user_id']);
if($user_id>0 && is_numeric($user_id)){
$old_useraccount = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$user_id."' "));
if($old_useraccount['user_id']==$user_id && $old_useraccount['user_id']!=1){
$sql = "DELETE FROM `useraccount` WHERE user_id='".$old_useraccount['user_id']."' ";	
if(rechpay_query($sql)){
$sql = "DELETE FROM `bharatpe` WHERE user_id='".$old_useraccount['user_id']."' ";	
if(rechpay_query($sql)){	
alert_msg("Account Delete Successfully !",'success');
}
}else{
alert_msg("Server is Down!",'danger');
}
	
}else{
alert_msg("User Account Not Found!",'danger');
}

}else{
alert_msg("User ID Is Not Valid!",'danger');
}

}
?>	

<?php
if(isset($_POST['update']) 
&& !empty($_POST['user_id'])
&& !empty($_POST['mobile'])
&& !empty($_POST['email'])
&& !empty($_POST['name'])
&& !empty($_POST['company'])
&& !empty($_POST['pan'])
&& !empty($_POST['aadhaar'])
&& !empty($_POST['location'])
&& !empty($_POST['plan_type'])
&& !empty($_POST['plan_limit'])
&& !empty($_POST['is_expire'])
&& !empty($_POST['expire_date'])
&& !empty($_POST['status'])
){

$user_id = safe_str($_POST['user_id']);
$mobile = safe_str($_POST['mobile']);
$email = safe_str($_POST['email']);
$name = safe_str($_POST['name']);
$company = safe_str($_POST['company']);
$pan = safe_str($_POST['pan']);
$aadhaar = safe_str($_POST['aadhaar']);
$location = safe_str($_POST['location']);
$plan_type = safe_str($_POST['plan_type']);
$plan_limit = safe_str($_POST['plan_limit']);
$is_expire = safe_str($_POST['is_expire']);
$expire_date = safe_str($_POST['expire_date']);
$expire_date = date("Y-m-d", strtotime($expire_date));
$status = safe_str($_POST['status']);

if($user_id>0 && is_numeric($user_id)){
$old_useraccount = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$user_id."' "));
if($old_useraccount['user_id']>0){

if(strlen($mobile)==10 && is_numeric($mobile)){
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
if(in_array($plan_type,['1 Month','1 Year'])){
if(in_array($is_expire,['Yes','No','Alert'])){    
if(strlen($aadhaar)==12 && is_numeric($aadhaar)){
if(strlen($pan)==10){
if(in_array($status,["Active","InActive"])){
$sql = "UPDATE `useraccount` SET `mobile`='".$mobile."', `email`='".$email."',`name`='".$name."',`company`='".$company."',`pan`='".$pan."',`aadhaar`='".$aadhaar."',`location`='".$location."',`plan_type`='".$plan_type."',`plan_limit`='".$plan_limit."',`is_expire`='".$is_expire."',`expire_date`='".$expire_date."',`status`='".$status."' WHERE user_id='".$old_useraccount['user_id']."'";	
if(rechpay_query($sql)){
alert_msg("Updated Successfully!",'success');
}else{
alert_msg("Server is down!",'danger');
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
alert_msg("Expired Not Valid!",'danger');
}

}else{
alert_msg("Plan Type Not Valid!",'danger');
}

}else{
alert_msg("Email Address Not Valid!",'danger');
}

}else{
alert_msg("Mobile Number Not Valid!",'danger');
}

}else{
alert_msg("User ID Not Found!",'danger');
}

}else{
alert_msg("User ID Is Not Valid!",'danger');
}

}
?>	



<?php
if(isset($_POST['create']) 
&& !empty($_POST['username'])
&& !empty($_POST['password'])
&& !empty($_POST['mobile'])
&& !empty($_POST['email'])
&& !empty($_POST['name'])
&& !empty($_POST['company'])
&& !empty($_POST['pan'])
&& !empty($_POST['aadhaar'])
&& !empty($_POST['location'])
&& !empty($_POST['role'])
&& !empty($_POST['status'])
){

$username = safe_str($_POST['username']);
$password = safe_str($_POST['password']);
$mobile = safe_str($_POST['mobile']);
$email = safe_str($_POST['email']);
$name = safe_str($_POST['name']);
$company = safe_str($_POST['company']);
$pan = safe_str($_POST['pan']);
$aadhaar = safe_str($_POST['aadhaar']);
$location = safe_str($_POST['location']);
$role = safe_str($_POST['role']);
$status = safe_str($_POST['status']);

$old_useraccount = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE username='".$username."' "));
if(count($old_useraccount)==0){

if(strlen($username)==10 && is_numeric($username)){
if(strlen($mobile)==10 && is_numeric($mobile)){
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
if(strlen($aadhaar)==12 && is_numeric($aadhaar)){
if(strlen($pan)==10){
if(in_array($status,["Active","InActive"])){
if(in_array($role,["Admin","User"])){	
$sql = "INSERT INTO `useraccount`(`role`, `username`, `password`, `uid_token`, `mobile`, `email`, `name`, `company`, `pan`, `aadhaar`, `location`, `plan_id`, `plan_type`, `plan_limit`, `expire_date`, `is_expire`, `token`, `create_date`, `status`) VALUES ('".$role."','".$username."','".$password."','".$password."','".$mobile."','".$email."','".$name."','".$company."','".$pan."','".$aadhaar."','".$location."','0','1 Month','1','".date("
	Y-m-d")."','Yes','".api_token_gen()."','".current_timestamp()."','Active')";	
if(rechpay_query($sql)){
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


							</div>
							<div class="col-md-12">
							<form class="row mb-4">
								<div class="col-md-8 mb-2">
									<label>Search</label>
									<input type="text" id="search_input" placeholder="Search By User ID / Mobile Number / Email Address" class="form-control">
								</div>
								<div class="col-md-2 mb-2">
									<label>&nbsp;</label>
									<button type="button" class="btn btn-primary btn-block" onclick="search_users($('#search_input').val())">Search</button>
								</div>
								<div class="col-md-2 mb-2">
									<label>&nbsp;</label>
									<button type="button" class="btn btn-primary btn-block" onclick="get_create()">Create Users</button>
								</div>
							</form>	
							<div class="table-responsive">
								<table class="table table-sm table-hover table-bordered table-head-bg-primary" id="dataTable" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>User ID</th>
												<th>Role</th>
												<th>Name</th>
												<th>Company</th>
												<th>Plan</th>
												<th>Expire</th>
												<th>Token</th>
												<th>Created</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
							<?php 
							 $sl = 1;
							 foreach (all_user_account() as $key => $value) {
							 	$plan = "No Active Plan";
							 	if($value['plan_id']>0){
							 	    $plan_data = plan_data($value['plan_id']);
								 	if($plan_data['plan_id']>0){
								 	$plan = $plan_data['name'];	
								 	}
							    }

							    $value['expire_date'] = date("d-M-Y",strtotime($value['expire_date']));
							    $value['create_date'] = date("d-M-Y",strtotime($value['create_date']));

							    $expire_date = "<span class='badge badge-info'>".$value['expire_date']."</span>";
							    if($value['is_expire']=="Yes"){
							    	$expire_date = "<span class='badge badge-danger'>".$value['expire_date']."</span>";
							    }else if($value['is_expire']=="No"){
							    	$expire_date = "<span class='badge badge-success'>".$value['expire_date']."</span>";
							    }


							    $value['expire_date'] = date("d-M-Y",strtotime($value['expire_date']));

							    $status = "<span class='badge badge-danger'>".$value['status']."</span>";
							    if($value['status']=="Active"){
							    $status = "<span class='badge badge-success'>".$value['status']."</span>";
							    }


							?>				
										<tr>
											<th scope="row"><?=$sl?></th>
											<td><?=$value['username']?></td>
											<td><?=$value['role']?></td>
											<td><?=$value['name']?></td>
											<td><?=$value['company']?></td>
											<td><?=$plan?></td>
											<td><?=$expire_date?></td>
											<td>
												<p id="<?php echo $sl;?>" style='display:none;'><?=$value['token']?></p>
												<button class='btn btn-xs bg-brown text-white' onclick="copyToClipboard('#<?php echo $sl;?>')"><i class="la la-copy la-lg"></i></button>
											</td>
											<td><?=$value['create_date']?></td>
											<td><?=$status?></td>
											<td>
												<button class="btn btn-danger btn-xs mb-2 mt-1" title="Delete" onclick="get_delete('<?=$value['user_id']?>')"><i class="la la-trash la-lg"></i></button>
												<button class="btn btn-info btn-xs mb-2 mt-1" title="Password" onclick="get_password('<?=$value['password']?>')"><i class="la la-key la-lg"></i></button>
												<button class="btn btn-dark btn-xs mb-2 mt-1" title="Update" onclick="get_update('<?=$value['user_id']?>')"><i class="la la-edit la-lg"></i></button>
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
}else{
redirect("dashboard",0);
exit();	
}
require_once("templates/footer.php");
?>
<?php data_table();?>	
<script src="assets/js/useraccounts.js?<?=time()?>"></script>		
<script type="text/javascript">
$(document).ready(function () {
//$("#search").click();
});	
</script>