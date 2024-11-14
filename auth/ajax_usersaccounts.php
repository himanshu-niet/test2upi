<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
require_once("components/session.components.php");
require_once("components/main.components.php");
$site_data = site_data();
$uid_token = $_SESSION['UID_TOKEN'];
$sql = "SELECT * FROM `useraccount` WHERE uid_token='".$uid_token."' ";	
$userAccount = rechpay_fetch(rechpay_query($sql));
if(empty($userAccount['user_id']) || !isset($uid_token) || empty($uid_token)){
session_destroy();	
header("location: index");
exit("Login Session is expired");
}

if($userAccount['role']=="Admin"){


if(isset($_POST['get_update']) && !empty($_POST['user_id'])){
$user_id = safe_str($_POST['user_id']);	
$sql = "SELECT * FROM `useraccount` WHERE user_id='".$user_id."' ";
$useraccount = rechpay_fetch(rechpay_query($sql));
if($useraccount['user_id']>0 && $useraccount['user_id']==$user_id){

$active = ($useraccount['status']=="Active") ? "selected" : "";
$inactive = ($useraccount['status']=="InActive") ? "selected" : "";

$Month = ($useraccount['plan_type']=="1 Month") ? "selected" : "";
$Year = ($useraccount['plan_type']=="1 Year") ? "selected" : "";

$Yes = ($useraccount['is_expire']=="Yes") ? "selected" : "";
$Alert = ($useraccount['is_expire']=="Alert") ? "selected" : "";
$No = ($useraccount['is_expire']=="No") ? "selected" : "";

$results = '<div style="overflow: hidden;" class="text-left mt-2"><h6 class="mb4">Update User Account</h6><hr>';
$results .= '<form class="row mb-4" method="POST" action="">
    <input type="hidden" name="user_id" value="'.$useraccount['user_id'].'">
    <div class="col-md-6 mb-3"><label>Mobile Number</label> <input type="number" name="mobile" placeholder="Mobile" value="'.$useraccount['mobile'].'" class="form-control form-control-sm" onkeypress="if(this.value.length==10) return false;"/></div>
    <div class="col-md-6 mb-3"><label>Email Address</label> <input type="text" name="email" placeholder="Email" value="'.$useraccount['email'].'" class="form-control form-control-sm" /></div>
    <div class="col-md-6 mb-3"><label>Name</label> <input type="text" name="name" placeholder="Name" value="'.$useraccount['name'].'" class="form-control form-control-sm" /></div>
    <div class="col-md-6 mb-3"><label>Company</label> <input type="text" name="company" placeholder="Company" value="'.$useraccount['company'].'" class="form-control form-control-sm" /></div>
    <div class="col-md-6 mb-3"><label>PAN Number</label> <input type="text" name="pan" placeholder="Pan" value="'.$useraccount['pan'].'" class="form-control form-control-sm" onkeypress="if(this.value.length==10) return false;"/></div>
    <div class="col-md-6 mb-3"><label>Aadhaar Number</label> <input type="number" name="aadhaar" placeholder="Aadhaar" value="'.$useraccount['aadhaar'].'" class="form-control form-control-sm" onkeypress="if(this.value.length==12) return false;"/></div>
    <div class="col-md-12 mb-3"><label>Location</label> <input type="text" name="location" placeholder="Location" value="'.$useraccount['location'].'" class="form-control form-control-sm" /></div>
    <div class="col-md-6 mb-3"><label>Plan Type</label> <select name="plan_type" class="form-control form-control-sm" required>
    <option value="1 Month" '.$Month.'>1 Month</option>
    <option value="1 Year" '.$Year.'>1 Year</option>
    </select></div>
    <div class="col-md-6 mb-3"><label>Plan Limit</label> <input type="number" name="plan_limit" placeholder="Hits Limit" value="'.$useraccount['plan_limit'].'" class="form-control form-control-sm" required/></div>
    <div class="col-md-4 mb-3"><label>Expired</label> <select name="is_expire" class="form-control form-control-sm" required>
    <option value="Yes" '.$Yes.'>Yes</option>
    <option value="Alert" '.$Alert.'>Alert</option>
    <option value="No" '.$No.'>No</option>
    </select></div>
    <div class="col-md-4 mb-3"><label>Expire Date</label> <input type="date" name="expire_date" value="'.$useraccount['expire_date'].'" class="form-control form-control-sm" required/></div>
    <div class="col-md-4 mb-3"><label>Status</label> <select name="status" class="form-control form-control-sm">
    <option value="Active" '.$active.'>Active</option>
    <option value="InActive" '.$inactive.'>InActive</option>
    </select></div>
    <div class="col-md-12 mb-3"><button type="submit" name="update" class="btn btn-primary btn-sm btn-block">Save</button></div>
</form>
';
$results .= '</div>';

$output = array("status"=>true,"message"=>"Data Fetched successfully","results"=>$results);
}else{
$output = array("status"=>false,"message"=>"User ID is Not Found","results"=>array());
}


header('Content-Type: application/json');
echo json_encode($output);
}



if(isset($_POST['get_search'])){
$search_input = safe_str($_POST['search_input']);	
$sql = "SELECT * FROM `useraccount` ";
if(!empty($search_input)){
$sql .= "WHERE CONCAT(`username`,`mobile`,`email`) LIKE '%$search_input%' ORDER BY `user_id` DESC";
}
$result = rechpay_fetch_all(rechpay_query($sql));
$results = array();
$sl = 1;
foreach($result as $value){
$plan = "No Active Plan";
if($value['plan_id']>0){
$plan_data = plan_data($value['plan_id']);
if($plan_data['plan_id']>0){
$plan = $plan_data['name'];	
}
}

$value['expire_date'] = date("d-M-Y",strtotime($value['expire_date']));

$expire_date = "<span class='badge badge-info'>".$value['expire_date']."</span>";
if($value['is_expire']=="Yes"){
$expire_date = "<span class='badge badge-danger'>".$value['expire_date']."</span>";
}else if($value['is_expire']=="No"){
$expire_date = "<span class='badge badge-success'>".$value['expire_date']."</span>";
}


$value['expire_date'] = date("d-M-Y",strtotime($value['expire_date']));
$value['create_date'] = date("d-M-Y",strtotime($value['create_date']));

$status = "<span class='badge badge-danger'>".$value['status']."</span>";
if($value['status']=="Active"){
$status = "<span class='badge badge-success'>".$value['status']."</span>";
}


$token = '<p id="'.$sl.'" style="display: none;">'.$value['token'].'</p>
<button class="btn btn-xs bg-brown text-white" onclick="copyToClipboard(\'#'.$sl.'\')"><i class="la la-copy la-lg"></i></button>
';

$action = '<button class="btn btn-danger btn-xs mb-2 mt-1" title="Delete" onclick="get_delete('.$value['user_id'].')"><i class="la la-trash la-lg"></i></button>
<button class="btn btn-info btn-xs mb-2 mt-1" title="Password" onclick="get_password(\''.$value['password'].'\')"><i class="la la-key la-lg"></i></button>
<button class="btn btn-dark btn-xs mb-2 mt-1" title="Update" onclick="get_update('.$value['user_id'].')"><i class="la la-edit la-lg"></i></button>
';

$value['plan'] = $plan;	
$value['expire_date'] = $expire_date;
$value['token'] = $token;
$value['status'] = $status;
$value['action'] = $action;
$results[] = $value;
$sl++;}

header('Content-Type: application/json');
echo json_encode($results);
}


}

}


