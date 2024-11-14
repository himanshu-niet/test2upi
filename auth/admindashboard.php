<?php
require_once("templates/header.php");
if($userAccount['role']=="Admin"){
$today_transactions = today_transactions($userAccount);
$monthly_transactions = monthly_transactions($userAccount);
?>
<style type="text/css">
.card .card-category {
    font-size: 13px;
}	

.card .card-title {
    font-size: 16px;
}
</style>

			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Dashboard</h4>
						<div class="row">
							<div class="col-md-3 hand" onclick="location='transactions'">
								<div class="card card-stats card-success">
									<div class="card-body ">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
													<i class="la la-check-circle"></i>
												</div>
											</div>
											<div class="col-9 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Today Order Success</p>
													<h4 class="card-title">₹<?=$today_transactions['success']['amount']?> | <small><?=$today_transactions['success']['total']?></small></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 hand" onclick="location='transactions'">
								<div class="card card-stats card-danger">
									<div class="card-body ">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
													<i class="la la-exclamation-circle"></i>
												</div>
											</div>
											<div class="col-9 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Today Order Failed</p>
													<h4 class="card-title">₹<?=$today_transactions['failed']['amount']?> | <small><?=$today_transactions['failed']['total']?></small></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 hand" onclick="location='transactions'">
								<div class="card card-stats card-warning">
									<div class="card-body ">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
													<i class="la la-clock-o"></i>
												</div>
											</div>
											<div class="col-9 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Today Order Pending</p>
													<h4 class="card-title">₹<?=$today_transactions['pending']['amount']?> | <small><?=$today_transactions['pending']['total']?></small></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 hand" onclick="location='transactions'">
								<div class="card card-stats card-info">
									<div class="card-body ">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
													<i class="la la-shekel"></i>
												</div>
											</div>
											<div class="col-9 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Monthly Transactions</p>
													<h4 class="card-title">₹<?=$monthly_transactions['amount']?> (<?=count($monthly_transactions['result'])?>)</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 hand" onclick="location='usersaccounts'">
								<div class="card card-stats card-primary">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-users"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Total Users</p>
													<h4 class="card-title"><?=count(all_user_account())?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 hand" onclick="location='subscriptions'">
								<div class="card card-stats card-primary">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-shopping-cart"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Subscriptions</p>
													<h4 class="card-title">Create</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 hand" onclick="location='usersaccounts'">
								<div class="card card-stats card-primary">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-user"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Users Accounts</p>
													<h4 class="card-title">Create</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 hand" onclick="location='noticeboard'">
								<div class="card card-stats card-primary">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-clipboard"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Notice Board</p>
													<h4 class="card-title">Update</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row row-card-no-pd">
							<div class="col-md-12">
								<h6 class="mb-4">Today Transactions</h6>
							<div class="table-responsive">
								<table class="table table-sm table-hover table-bordered table-head-bg-primary" id="dataTable" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>User ID</th>
												<th>Txn ID</th>
												<th>Date Time</th>
												<th>Merchant</th>
												<th>Customer</th>
												<th>Txn Note</th>
												<th>Bank ID</th>
												<th>Bank RRN</th>
												<th>Order ID</th>
												<th>Amount</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
							<?php 
							 $sl = 1;
							 foreach ($today_transactions['result'] as $key => $value) {
							 	$user = rechpay_fetch(rechpay_query("SELECT * FROM `useraccount` WHERE user_id='".$value['user_id']."'"));
							 	$transactionData = json_encode(array(
                                    "txn_id" => $value['txn_id'],
                                    "merchant_id" => $value['merchant_id'],
                                    "merchant_name" => $value['merchant_name'],
                                    "merchant_upi" => $value['merchant_upi'],
                                    "client_orderid" => $value['client_orderid'],
                                    "txn_date" => $value['txn_date'],
                                    "txn_amount" => $value['txn_amount'],
                                    "txn_note" => $value['txn_note'],
                                    "product_name" => $value['product_name'],
                                    "customer_name" => $value['customer_name'],
                                    "customer_mobile" => $value['customer_mobile'],
                                    "customer_email" => $value['customer_email'],
                                    "customer_vpa" => $value['customer_vpa'],
                                    "bank_orderid" => $value['bank_orderid'],
                                    "utr_number" => $value['utr_number'],
                                    "payment_mode" => $value['payment_mode'],
                                    "status" => $value['status'],
                                ));
							?>				
										<tr>
											<th scope="row"><?=$sl?></th>
											<td><?=$user['username']?></td>
											<th><span class="badge badge-primary">
											<a class="text-white" href="javascript:void(0)" onclick="get_txn_details('<?=base64_encode($transactionData)?>')">
											<i class="la la-shekel"></i> <?=$value['txn_id']?></a></span>
											</th>
											<td><?=date("d-M-Y h:i:s A",strtotime($value['txn_date']))?></td>
											<td><?=$value['merchant_name']?></td>
											<td><?=$value['customer_name']?></td>
											<td><?=$value['txn_note']?></td>
											<td><?=$value['bank_orderid']?></td>
											<td><?=$value['utr_number']?></td>
											<td><?=$value['client_orderid']?></td>
											<td>₹<?=$value['txn_amount']?></td>
											<td><span class="badge <?=$value['status']?>"><?=$value['status']?></span></td>
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
<script src="assets/js/merchant.js?<?=time()?>"></script>
