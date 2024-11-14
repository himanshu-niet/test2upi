<?php
require_once("templates/header.php");
$today_transactions = today_transactions($userAccount);
?>

			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Transactions</h4>
						<div class="row row-card-no-pd">
							<div class="col-md-12">
							<form class="row mb-4">
								<div class="col-md-3 mb-2">
									<label>From Date</label>
									<input type="text" id="from_date" value="<?=date("d-m-Y")?>" placeholder="DD-MM-YYYY" class="form-control datepicker" readonly>
								</div>
								<div class="col-md-3 mb-2">
									<label>To Date</label>
									<input type="text" id="to_date" value="<?=date("d-m-Y")?>" placeholder="DD-MM-YYYY" class="form-control datepicker" readonly>
								</div>
								<div class="col-md-4 mb-2">
									<label>Search</label>
									<input type="text" id="search_input" placeholder="Search By Txn ID / Bank RRN / Order ID" class="form-control">
								</div>
								<div class="col-md-2 mb-2">
									<label>&nbsp;</label>
									<button type="button" id="search" class="btn btn-primary btn-block" onclick="search_txn($('#from_date').val(),$('#to_date').val(),$('#search_input').val())">Search</button>
								</div>
							</form>	
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
												<th>Invoice</th>
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
											<td><a href="invoice/<?=$value['txn_id']?>" target="blank">
											<span class="badge badge-primary"><i class="la la-print"></i> Print</span></a></td>
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
<?php datepicker();?>
<script src="assets/js/merchant.js?<?=time()?>"></script>				
<script type="text/javascript">
$(document).ready(function () {
//$("#search").click();
});	
</script>