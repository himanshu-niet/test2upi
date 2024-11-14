<?php
require_once("templates/header.php");
if($userAccount['role']=="Admin"){
$paytm = gateway("paytm");
$upiapi = gateway("upiapi");
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
						<h4 class="page-title">Site Settings</h4>
						<div class="row row-card-no-pd">
							<div class="col-md-12">

<?php
if(isset($_POST['update']) 
&& !empty($_POST['title'])
&& !empty($_POST['brand'])
&& !empty($_POST['logo'])
&& !empty($_POST['favicon'])
&& !empty($_POST['support'])
&& !empty($_POST['protocol'])
&& !empty($_POST['baseurl'])
&& !empty($_POST['paytm_mid'])
&& !empty($_POST['paytm_key'])
&& !empty($_POST['smsapi_url'])
&& !empty($_POST['whatsapp_link'])
){

$title = real_escape_string(strip_tags($_POST['title']));
$brand = real_escape_string(strip_tags($_POST['brand']));
$logo = strip_tags($_POST['logo']);
$favicon = strip_tags($_POST['favicon']);
$support = real_escape_string(strip_tags($_POST['support']));
$whatsapp_link = real_escape_string(strip_tags($_POST['whatsapp_link']));
$paytm_mid = strip_tags($_POST['paytm_mid']);
$paytm_key = strip_tags($_POST['paytm_key']);
$upiapi_token = strip_tags($_POST['upiapi_token']);
$upiapi_secret = strip_tags($_POST['upiapi_secret']);
$smsapi_url = strip_tags($_POST['smsapi_url']);
$protocol = strip_tags($_POST['protocol']);
$baseurl = real_escape_string(strip_tags($_POST['baseurl']));

if(in_array($protocol,["http://","https://"])){
$gateway =  json_encode([
"paytm"=>array("mid"=>$paytm_mid,"key"=>$paytm_key),
"upiapi"=>array("token"=>$upiapi_token,"secret"=>$upiapi_secret)
]);

$sql = "UPDATE `siteconfig` SET `title`=".$title.", `brand`=".$brand.", `logo`='".$logo."', `favicon`='".$favicon."', `support`=".$support.", `whatsapp_link`=".$whatsapp_link.", `gateway`=".real_escape_string($gateway).", `smsapi_url`='".$smsapi_url."', `protocol`='".$protocol."', `baseurl`=".$baseurl." WHERE  site_id='".$site_data['site_id']."' ";	
if(rechpay_query($sql)){
$site_data = site_data();
$paytm = gateway("paytm");
$upiapi = gateway("upiapi");
alert_msg("Site Updated Successfully!",'success');
}else{
alert_msg("Server is down!",'danger');
}

}else{
alert_msg("Protocol Not Valid!",'danger');
}

}
?>	

							</div>
							<div class="col-md-12">
							<form class="row mb-4" method="POST" action="">
								<div class="col-md-8 mb-2">
									<label>Title</label>
									<input type="text" name="title" placeholder="Title" value="<?=$site_data['title']?>" class="form-control" required>
								</div>
								<div class="col-md-4 mb-2">
									<label>Brand</label>
									<input type="text" name="brand" placeholder="Brand" value="<?=$site_data['brand']?>" class="form-control" required>
								</div>
								<div class="col-md-8 mb-2">
									<label>Support</label>
									<input type="text" name="support" placeholder="Support" value="<?=$site_data['support']?>" class="form-control" required>
								</div>
								<div class="col-md-4 mb-2">
								  <label>Protocol</label>
								  <div class="input-group">
								    <div class="input-group-prepend">
									<select type="text" name="protocol" class="form-control" required>
										<option <?=($site_data['protocol']=="http://") ? "selected" : "";?> value="http://">http://</option>
										<option <?=($site_data['protocol']=="https://") ? "selected" : "";?> value="https://">https://</option>
									</select>
								    </div>
									<input type="text" name="baseurl" placeholder="Base URL" value="<?=$site_data['baseurl']?>" class="form-control" required>
								  </div>
								</div>
								<div class="col-md-3 mb-2">
									<label>Paytm Merchant ID</label>
									<input type="text" name="paytm_mid" value="<?=$paytm['mid']?>" placeholder="Paytm Merchant ID" class="form-control" required>
								</div>
								<div class="col-md-3 mb-2">
									<label>Paytm Merchant Key</label>
									<input type="text" name="paytm_key" value="<?=$paytm['key']?>" placeholder="Paytm Merchant Key" class="form-control" required>
								</div>
								<div class="col-md-3 mb-2">
									<label>UpiApi Token</label>
									<input type="text" name="upiapi_token" value="<?=$upiapi['token']?>" placeholder="UpiApi Token" class="form-control" required>
								</div>
								<div class="col-md-3 mb-2">
									<label>UpiApi Secret</label>
									<input type="text" name="upiapi_secret" value="<?=$upiapi['secret']?>" placeholder="UpiApi Secret" class="form-control" required>
								</div>
								<div class="col-md-4 mb-2">
									<label>Favicon</label>
									<input type="url" name="favicon" placeholder="Favicon URL" value="<?=$site_data['favicon']?>" class="form-control" required>
								</div>
								<div class="col-md-4 mb-2">
									<label>Logo</label>
									<input type="url" name="logo" placeholder="Logo URL" value="<?=$site_data['logo']?>" class="form-control" required>
								</div>
								<div class="col-md-4 mb-2">
									<label>WhatsApp Link</label>
									<input type="url" name="whatsapp_link" value="<?=$site_data['whatsapp_link']?>" placeholder="example : wa.me/919000000000" class="form-control" required>
								</div>
								<div class="col-md-10 mb-2">
									<label>Dynamic SMS API - {NUMBER} | {MSG}</label>
									<input type="url" name="smsapi_url" value="<?=$site_data['smsapi_url']?>" placeholder="Enter Api URL and Set Variable" class="form-control" required>
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