<?php
require_once("templates/header.php");
if($userAccount['role']=="Admin"){
$today_transactions = today_transactions($userAccount);
?>

			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Subscriptions</h4>
						<div class="row row-card-no-pd">
							<div class="col-md-12">
<?php
if(isset($_POST['delete']) && !empty($_POST['plan_id'])){
$plan_id = safe_str($_POST['plan_id']);
if($plan_id>0 && is_numeric($plan_id)){
$old_plan = rechpay_fetch(rechpay_query("SELECT * FROM `plans` WHERE plan_id='".$plan_id."' "));
if($old_plan['plan_id']==$plan_id){
$sql = "DELETE FROM `plans` WHERE plan_id='".$old_plan['plan_id']."' ";	
if(rechpay_query($sql)){
alert_msg("Plan Delete Successfully !",'success');
}else{
alert_msg("Server is Down!",'danger');
}
	
}else{
alert_msg("Plan Not Found!",'danger');
}

}else{
alert_msg("Plan ID Is Not Valid!",'danger');
}

}
?>	

<?php
if(isset($_POST['update']) 
&& !empty($_POST['plan_id'])
&& !empty($_POST['name'])
&& !empty($_POST['type'])
&& !empty($_POST['limit'])
&& !empty($_POST['account_limit'])
&& !empty($_POST['amount'])
&& !empty($_POST['status'])
){

$plan_id = safe_str($_POST['plan_id']);
$name = safe_str($_POST['name']);
$type = safe_str($_POST['type']);
$limit = safe_str($_POST['limit']);
$account_limit = safe_str($_POST['account_limit']);
$amount = safe_str($_POST['amount']);
$status = safe_str($_POST['status']);

if($plan_id>0 && is_numeric($plan_id)){
$old_plan = rechpay_fetch(rechpay_query("SELECT * FROM `plans` WHERE plan_id='".$plan_id."' "));
if($old_plan['plan_id']>0){

if(in_array($type,["1 Month","1 Year"])){
if(in_array($status,["Active","InActive"])){
$sql = "UPDATE `plans` SET `type`='".$type."',`name`='".$name."',`limit`='".$limit."',`account_limit`='".$account_limit."',`amount`='".$amount."',`status`='".$status."' WHERE plan_id='".$old_plan['plan_id']."'";	
if(rechpay_query($sql)){
alert_msg("Plan Updated Successfully!",'success');
}else{
alert_msg("Server is down!",'danger');
}

}else{
alert_msg("Status Not Valid!",'danger');
}

}else{
alert_msg("Type Not Valid!",'danger');
}

}else{
alert_msg("Plan Not Found!",'danger');
}

}else{
alert_msg("Plan ID Not Valid!",'danger');
}


}
?>	



<?php
if(isset($_POST['create']) 
&& !empty($_POST['name'])
&& !empty($_POST['type'])
&& !empty($_POST['limit'])
&& !empty($_POST['account_limit'])
&& !empty($_POST['amount'])
&& !empty($_POST['status'])
){

$type = safe_str($_POST['type']);
$name = safe_str($_POST['name']);
$limit = safe_str($_POST['limit']);
$account_limit = safe_str($_POST['account_limit']);
$amount = safe_str($_POST['amount']);
$status = safe_str($_POST['status']);

if(in_array($type,["1 Month","1 Year"])){
if(in_array($status,["Active","InActive"])){
$sql = "INSERT INTO `plans`(`type`, `name`, `limit`, `account_limit`, `amount`, `status`) VALUES ('".$type."','".$name."','".$limit."','".$account_limit."','".$amount."','".$status."')";	
if(rechpay_query($sql)){
alert_msg("Plan Created Successfully!",'success');
}else{
alert_msg("Server is down!",'danger');
}

}else{
alert_msg("Status Not Valid!",'danger');
}

}else{
alert_msg("Type Not Valid!",'danger');
}

}
?>


							</div>

							<div class="col-md-12">
                              <button type="button" class="btn btn-primary mb-4" onclick="get_create()">Create Plan</button>
							<div class="table-responsive">
								<table class="table table-sm table-hover table-bordered table-head-bg-primary" id="dataTable" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Plan ID</th>
												<th>Name</th>
												<th>Type</th>
												<th>Limit</th>
												<th>Account Limit</th>
												<th>Amount</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
							<?php 
							 $sl = 1;
							 foreach (all_plans() as $key => $value) {
							    $status = "<span class='badge badge-danger'>".$value['status']."</span>";
							    if($value['status']=="Active"){
							    $status = "<span class='badge badge-success'>".$value['status']."</span>";
							    }

							?>				
										<tr>
											<th scope="row"><?=$sl?></th>
											<td><?=$value['plan_id']?></td>
											<td><?=$value['name']?></td>
											<td><?=$value['type']?></td>
											<td><?=$value['limit']?></td>
											<td><?=$value['account_limit']?></td>
											<td>₹<?=$value['amount']?></td>
											<td><?=$status?></td>
											<td>
												<button class="btn btn-danger btn-xs mb-2 mt-1" title="Delete" onclick="get_delete('<?=$value['plan_id']?>')"><i class="la la-trash la-lg"></i></button>
												<button class="btn btn-dark btn-xs mb-2 mt-1" title="Update" onclick="get_update('<?=base64_encode(json_encode($value))?>')"><i class="la la-edit la-lg"></i></button>
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
<script src="assets/js/subscriptions.js?<?=time()?>"></script>		
<script type="text/javascript">
$(document).ready(function () {
//$("#search").click();
});	
</script>