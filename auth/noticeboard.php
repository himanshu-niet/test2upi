<?php
require_once("templates/header.php");
if($userAccount['role']=="Admin"){
$paytm = gateway("paytm");
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
						<h4 class="page-title">Notice Board</h4>
						<div class="row row-card-no-pd">
							<div class="col-md-12">

<?php
if(isset($_POST['update']) 
&& !empty($_POST['notice'])
){
$notice = real_escape_string(strip_tags($_POST['notice']));
$sql = "UPDATE `siteconfig` SET `notice`=".$notice." WHERE site_id='".$site_data['site_id']."' ";	
if(rechpay_query($sql)){
$site_data = site_data();
alert_msg("Notice Updated Successfully!",'success');
}else{
alert_msg("Server is down!",'danger');
}

}
?>	

							</div>
							<div class="col-md-12">
							<form class="row mb-4" method="POST" action="">
								<div class="col-md-12 mb-2">
									<label>Notice</label>
									<textarea type="text" name="notice" placeholder="Enter Text" class="form-control" style="height: 280px;" required><?=$site_data['notice']?></textarea>
								</div>
								<div class="col-md-2 mb-2">
									<label>&nbsp;</label>
									<button type="submit" name="update" class="btn btn-primary btn-block">Save</button>
								</div>
							</form>	
							
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