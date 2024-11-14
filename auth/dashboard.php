<?php
require_once("templates/header.php");
$today_transactions = today_transactions($userAccount);
?>

			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Dashboard</h4>
<?php
alert_msg("<b>Note:</b> Pay Via Upi Button Will Only Work If Your Current Bank Account Joined In Merchant App Support It. Use Of {$site_data['brand']} In Any Manner That Is Unlawful, Gambling, Crypto Or Betting Is Strictly Prohibited. We Reserve The Right To Terminate Your Account And/or Block Your Access To {$site_data['brand']} If We Suspect Any Such Activity.",'danger');
?>
						<div class="row">
							<div class="col-md-3 hand" onclick="location='upisettings'">
								<div class="card card-stats card-info">
									<div class="card-body ">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
													<i class="la la-bank"></i>
												</div>
											</div>
											<div class="col-9 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">UPI Settings</p>
													<h4 class="card-title"><?=count(merchant_accounts($userAccount))?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
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
							<div class="col-md-3">
								<div class="card card-stats card-primary">
									<div class="card-body ">
										<div class="row">
											<div class="col-4">
												<div class="icon-big text-center">
													<i class="la la-shekel"></i>
												</div>
											</div>
											<div class="col-8 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Total Transactions</p>
													<h4 class="card-title"><?=$user_plan_data['limit']?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats card-primary">
									<div class="card-body ">
										<div class="row">
											<div class="col-4">
												<div class="icon-big text-center">
													<i class="la la-hourglass-end"></i>
												</div>
											</div>
											<div class="col-8 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Used Transactions</p>
													<h4 class="card-title"><?=($user_plan_data['limit']-$userAccount['plan_limit'])?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats card-primary">
									<div class="card-body">
										<div class="row">
											<div class="col-4">
												<div class="icon-big text-center">
													<i class="la la-newspaper-o"></i>
												</div>
											</div>
											<div class="col-8 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Plan Expire Date</p>
													<h4 class="card-title"><?=date("d-M-Y",strtotime($userAccount['expire_date']))?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 hand" onclick="location='subscription'">
								<div class="card card-stats card-primary">
									<div class="card-body ">
										<div class="row">
											<div class="col-4">
												<div class="icon-big text-center">
													<i class="la la-cart-plus"></i>
												</div>
											</div>
											<div class="col-8 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Plan Purchased</p>
													<h4 class="card-title"><?=$user_plan_data['name']?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row row-card-no-pd">
							<div class="col-md-12">
								<h6 class="btn badge bg-danger text-white mb-4" style="width: 100%;font-size:20px; ">
									<i class="la la-bell"></i>
									<marquee style="color: white;margin-bottom: -8px;" onmouseover="this.stop();" onmouseout="this.start();" direction="left" height="25"><?=$site_data['notice']?></marquee>
								</h6>
							<div class="table-responsive">
								<table class="table table-sm table-hover table-bordered table-head-bg-primary" id="dataTable" width="100%">
										<thead>
											<tr>
												<th class="d-none">#</th>
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
											<th scope="row" class="d-none"><?=$sl?></th>
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
require_once("templates/footer.php");
?>
<?php data_table();?>
<script src="assets/js/merchant.js?<?=time()?>"></script>